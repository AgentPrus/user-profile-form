<?php
include_once('db/db.connection.php');

// Select user by id
$userId = $conn->real_escape_string($_GET['id']);
$getUser = $conn->query("SELECT * FROM users WHERE user_id = '$userId'");
$currentUser = $getUser->fetch_assoc();


if (isset($_POST) && !empty($_POST)) {
    if (array_key_exists('yes', $_POST)) {
        $delete_user = "DELETE FROM users WHERE user_id = '$userId'";
        // Delete user
        if ($conn->query($delete_user) === TRUE) {
            header('Location: user_list.php');
        } else {
            $logMsg = "Error on delete user: " . $conn->error;
            writeLog('errors/error_log.txt', $logMsg);
        }
    } else {
        // Redirect to user list page
        header('Location: user_list.php');
    }
}
?>

<?php include('include/header.inc.php'); ?>
<div class="container">
    <h1>Are you sure to delete <?php echo $currentUser['first_name'] . ' ' . $currentUser['last_name'] ?></h1>
    <form action="<?php $_SERVER['PHP_SELF'] ?>" method="post">
        <div class="btn-group">
            <button type="submit" class="btn btn-success " value="false" name="false">No</button>
            <button type="submit" class="btn btn-danger ml-2" value="true" name="yes">Yes</button>
        </div>
    </form>
</div>
<?php include('include/footer.inc.php'); ?>
