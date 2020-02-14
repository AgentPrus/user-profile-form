<?php
include_once('db/db.connection.php');
include_once('validations.php');

$errorMsg = '';
$successMsg = '';

// Get skills form db
$getSkills = $conn->query('SELECT * FROM users_profiles.skills');

// Check if button pressed
if (array_key_exists('add', $_POST)) {
    if (!empty($_POST['addSkill']) && isset($_POST['addSkill'])) {
        // Check if skill Already Exist
        $errorMsg = isSkillAlreadyExists($_POST['addSkill'], $conn);
        // Add skill to DB
        if (empty($errorMsg)) {
            $addableSkill = $conn->real_escape_string($_POST['addSkill']);
            $addSkill = "INSERT INTO users_profiles.skills (skill_name) VALUES ('$addableSkill')";
            if ($conn->query($addSkill) === true) {
                $successMsg = "Skill successfully added";
            } else {
                $logMsg = "Error creating database: " . $conn->error;
                writeLog('errors/error_log.txt', $logMsg);
            }
            $conn->close();
        }
    }
}


?>

<?php include('include/header.inc.php'); ?>
<form action="<?php $_SERVER['PHP_SELF'] ?>" method="post">
    <div class="container">
        <h1>Add skills</h1>
        <?php if (!empty($errorMsg)): ?>
            <div class="alert alert-danger" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h4><?php echo $errorMsg ?></h4>
            </div>
        <?php elseif (!empty($successMsg)): ?>
            <div class="alert alert-success" role="alert"><h4 class="alert-heading">Well
                    done!</h4> <?php echo $successMsg; ?>
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        <?php endif; ?>
        <div class="form-group form-row">
            <input type="text" class="form-control form-control-lg" name="addSkill">
            <button type="submit" class="btn btn-success" name="add" value="Add">Add</button>
        </div>
        <div class="container">
            <h2>Skills which already exists</h2>
            <?php while ($skill = $getSkills->fetch_assoc()): ?>
                <ul class="list-group list-group-flush">
                    <li class="list-group-item"><?php echo strtoupper($skill['skill_name']) ?></li>
                </ul>
            <?php endwhile; ?>
        </div>
    </div>
    </div>
</form>
<?php include('include/footer.inc.php'); ?>
