<?php
include_once('../db/db.connection.php');
include_once('../validations.php');

if (isset($_POST['login']) && !empty($_POST['login'])) {
    $errors = [];

    $errors[] = $errors[] = validateFieldLength('email', $_POST['email'], 45);
    $errors[] = $errors[] = validateFieldLength('password', $_POST['password'], 45);


    if (empty(array_filter($errors))) {
        $email = $conn->real_escape_string($_POST['email']);
        $password = $conn->real_escape_string($_POST['password']);

        $sql = $conn->query("SELECT * FROM register_users
        WHERE  email = '$email';");

        if ($row = $sql->fetch_assoc()) {
            $password_check = password_verify($password, $row['password']);
            if ($password_check == false) {
                $errors[] = 'wrong password';
            } else {
                session_start();
                $_SESSION['user_id'] = $row['id'];
                $_SESSION['name'] = $row['username'];
                $_SESSION['email'] = $row['email'];

                header('Location: /user-profile-form/auth/auth.home.php');
            }
        } else {
            $errors[] = 'No user with this email';
        }
    }
    print_r($errors);
}


?>


<?php include('../include/header.inc.php'); ?>
    <header>
        <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
            <a class="navbar-brand" href="#">EK</a>
            <div class="collapse navbar-collapse" id="navbarColor01">
                <ul class="navbar-nav mr-auto">
                    <li class="nav-item active">
                        <a class="nav-link" href="../auth/auth.home.php">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">User List</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Add skills</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">About</a>
                    </li>
                </ul>
                <form class="form-inline my-2 my-lg-0">
                    <a href="../auth/auth.registration.php" class="form-control mr-sm-2">Sign Up</a>
                </form>
            </div>
        </nav>
    </header>
    <div class="mt-3">
        <form action="<?php $_SERVER['PHP_SELF'] ?>" method="post">
            <div class="container">
                <div class="row">
                    <div class="col-md-3 bg-light">
                        <h1>Login</h1>
                        <?php if (filter_has_var(INPUT_POST, 'login') && array_filter($errors)): ?>
                            <div class="alert alert-danger" role="alert">
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                                <?php foreach ($errors as $error): ?>
                                    <p><?php echo $error ?></p>
                                <?php endforeach; ?>
                            </div>
                        <?php endif; ?>
                        <?php if (filter_has_var(INPUT_POST, 'login') && !array_filter($errors)): ?>
                            <div class="alert alert-success" role="alert"><h4 class="alert-heading">Well
                                    done!</h4> <?php echo "Thank {$_POST['username']}! You are successfully register"; ?>
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                        <?php endif; ?>
                        <label for="email"><b>Email</b></label>
                        <input class="form-control" type="text" name="email" required
                               value="<?php if (isset($_POST['email']) && !empty($_POST['email'])) echo $_POST['email']; ?>">

                        <label for="password"><b>Password</b></label>
                        <input class="form-control" type="password" name="password" required
                               value="<?php if (isset($_POST['password']) && !empty($_POST['password'])) echo $_POST['password']; ?>">
                        <hr class="mb-3">
                        <input class="btn-primary" type="submit" name="login" value="Log in">
                    </div>
                </div>
            </div>
        </form>
    </div>
<?php include('../include/footer.inc.php'); ?>