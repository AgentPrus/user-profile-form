<?php
include_once('db/db.connection.php');
// Get users
$getUsers = $conn->query('SELECT * FROM users');

if (array_key_exists('edit', $_POST)) {
    echo "move to edit user page";
}

if (array_key_exists('delete', $_POST)) {
    echo "delete user";
}

if (array_key_exists('info', $_POST)) {
    echo "move to user info page";
}
?>

<?php include('include/header.inc.php'); ?>
    <table class="table">
        <thead class="thead-dark">
        <tr class="d-flex">
            <th class="col-3">User ID</th>
            <th class="col-3">Email</th>
            <th class="col-3">Birthday</th>
            <th class="col-3">Actions</th>
        </tr>
        </thead>
        <tbody>
        <?php while ($users = $getUsers->fetch_assoc()): ?>
            <tr class="d-flex">
                <th class="col-sm-3"># <?php echo $users['user_id'] ?></th>
                <td class="col-sm-3"><?php echo $users['email'] ?></td>
                <td class="col-sm-3"><?php echo date("d/m/Y", strtotime($users['date_of_birth'])) ?></td>
                <td class="col-sm-3">
                    <form action="<?php $_SERVER['PHP_SELF'] ?>" method="post">
                            <a class="btn btn-sm btn-primary" href="edit_user.php?id=<?php echo $users['user_id'] ?>"><i class="fas fa-pen"></i></a>
                        <button type="submit" class="btn btn-sm btn-danger" name="delete" value="delete">
                            <i class="fas fa-trash-alt"></i>
                        </button>
                        <button type="submit" class="btn btn-sm btn-info" name="info" value="info">
                            <i class="fas fa-info-circle"></i>
                        </button>
                    </form>
                </td>
            </tr>
        <?php endwhile; ?>
        </tbody>
    </table>
<?php include('include/footer.inc.php'); ?>