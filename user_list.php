<?php
include_once('db/db.connection.php');
// Get users
$getUsers = $conn->query('SELECT * FROM users');

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
                    <a class="btn btn-sm btn-primary" href="edit_user.php?id=<?php echo $users['user_id'] ?>">
                        <i class="fas fa-pen"></i>
                    </a>
                    <a class="btn btn-sm btn-danger" href="delete_user.php?id=<?php echo $users['user_id'] ?>">
                        <i class="fas fa-trash-alt"></i>
                    </a>
                    <a class="btn btn-sm btn-info" href="about_user.php?id=<?php echo $users['user_id'] ?>">
                        <i class="fas fa-info-circle"></i>
                    </a>
                </td>
            </tr>
        <?php endwhile; ?>
        </tbody>
    </table>
<?php include('include/footer.inc.php'); ?>