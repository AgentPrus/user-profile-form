<?php
session_start();

if (isset($_POST['logout']) && !empty($_POST['logout'])) {
    session_unset();
    session_destroy();
    header('Location:  /user-profile-form/auth/auth.login.php');
}
?>
<?php include('../include/header.inc.php'); ?>
<header>
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
        <a class="navbar-brand" href="#"><?php echo $_SESSION['name'] ?></a>
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
            <form class="form-inline my-2 my-lg-0" action="<?php $_SERVER['PHP_SELF'] ?>" method="post">
                <input type="submit" name="logout" value="Log out">
            </form>
        </div>
    </nav>
</header>

<div class="container">
    <h1></h1>
</div>
<pre><?php print_r($_SESSION) ?></pre>
<?php include('../include/footer.inc.php'); ?>

