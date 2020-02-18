<?php
include_once('../db/db.connection.php');
include_once('../validations.php');

if (isset($_POST['register']) && !empty($_POST['register'])) {
    $errors = [];

    $errors[] = validateField($_POST['username'], 'username');

    // Check fields lengths
    $errors[] = $errors[] = validateFieldLength('username', $_POST['username'], 45);
    $errors[] = $errors[] = validateFieldLength('email', $_POST['email'], 45);
    $errors[] = $errors[] = validateFieldLength('password', $_POST['password'], 45);
    $errors[] = $errors[] = validateFieldLength('repeat_password', $_POST['repeat_password'], 45);

    // Check if email is unique
    $email = $conn->real_escape_string($_POST['email']);
    $getUsr = $conn->query("SELECT email FROM register_users WHERE email = '$email';");
    if ($getUsr->num_rows !== 0) {
        $errors[] = "User with this email is already exist";
    }

    // Check if passwords are matches
    if ($_POST['password'] !== $_POST['repeat_password']) {
        $errors[] = "Passwords are no matches";
    }

    if (empty(array_filter($errors))) {
        $username = $conn->real_escape_string($_POST['username']);
        $password = $conn->real_escape_string($_POST['password']);
        $hashed_pwd = password_hash($password, PASSWORD_DEFAULT);

        $register_user = "INSERT INTO register_users (username, email, password) 
    VALUES ('$username', '$email', '$hashed_pwd')";

        if ($conn->query($register_user) === TRUE) {
            echo "New user successfully registered";
            header('Location: /user-profile-form/auth/auth.login.php');
        } else {
            $logMsg = "Error on register user: " . $conn->error;
            echo $logMsg;
            writeLog('errors/error_log.txt', $logMsg);
        }
    }
    $conn->close();
}
?>

<?php include('../include/header.inc.php'); ?>
    <div class="mt-3">
        <form action="<?php $_SERVER['PHP_SELF'] ?>" method="post">
            <div class="container">
                <div class="row">
                    <div class="col-md-3 bg-light">
                        <h1>Registration</h1>
                        <?php if (filter_has_var(INPUT_POST, 'register') && array_filter($errors)): ?>
                            <div class="alert alert-danger" role="alert">
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                                <?php foreach ($errors as $error): ?>
                                    <p><?php echo $error ?></p>
                                <?php endforeach; ?>
                            </div>
                        <?php endif; ?>
                        <?php if (filter_has_var(INPUT_POST, 'register') && !array_filter($errors)): ?>
                            <div class="alert alert-success" role="alert"><h4 class="alert-heading">Well
                                    done!</h4> <?php echo "Thank {$_POST['username']}! You are successfully register"; ?>
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                        <?php endif; ?>
                        <label for="username"><b>Username</b></label>
                        <input class="form-control" type="text" name="username" required
                               value="<?php if (isset($_POST['username']) && !empty($_POST['username'])) echo $_POST['username']; ?>">

                        <label for="email"><b>Email</b></label>
                        <input class="form-control" type="text" name="email" required
                               value="<?php if (isset($_POST['email']) && !empty($_POST['email'])) echo $_POST['email']; ?>">

                        <label for="password"><b>Password</b></label>
                        <input class="form-control" type="password" name="password" required
                               value="<?php if (isset($_POST['password']) && !empty($_POST['password'])) echo $_POST['password']; ?>">

                        <label for="repeat_password"><b>Repeat Password</b></label>
                        <input class="form-control" type="password" name="repeat_password" required
                               value="<?php if (isset($_POST['repeat_password']) && !empty($_POST['repeat_password'])) echo $_POST['repeat_password']; ?>">
                        <hr class="mb-3">
                        <input class="btn-primary" type="submit" name="register" value="Sign Up">
                    </div>
                </div>
            </div>
        </form>
    </div>
<?php include('../include/footer.inc.php'); ?>