<?php
include_once('db/db.connection.php');
include_once('uploads.php');

// Edited user id
$userId = $conn->real_escape_string($_GET['id']);

// Get user data
$getUser = $conn->query("SELECT * FROM users WHERE user_id = '$userId'");
$getUserSkills = $conn->query("SELECT userskills.skill_id, skills.skill_name
FROM userskills
JOIN skills ON skills.skill_id = userskills.skill_id
WHERE user_id = '$userId'");
$getAllSkills = $conn->query("SELECT * FROM skills");

// Store user data into array
$userData = $getUser->fetch_assoc();
while ($row = $getUserSkills->fetch_assoc()) {
    $userData['user_skill_list'][] = $row;
}

// Validate fields
if (array_key_exists('Edit', $_POST) && filter_has_var(INPUT_POST, 'Edit')) {
    if (isset($_POST) && !empty($_POST)) {

        $errors = [];

        // check on empty fields
        $errors[] = isFieldEmpty('First name', $_POST['firstName']);
        $errors[] = isFieldEmpty('Last name', $_POST['lastName']);
        $errors[] = isFieldEmpty('Email', $_POST['email']);
        $errors[] = isFieldEmpty('Personal Info', $_POST['personalInfo']);
        $errors[] = isFieldEmpty('Date of Birth', $_POST['dateOfBirth']);

        // validate fields
        $errors[] = validateField($_POST['firstName'], 'First name');
        $errors[] = validateField($_POST['lastName'], 'Last name');
        $errors[] = validateEmail($_POST['email']);

        // validate fields length
        $errors[] = validateFieldLength('First name', $_POST['firstName'], 60);
        $errors[] = validateFieldLength('Last name', $_POST['lastName'], 60);
        $errors[] = validateFieldLength('Personal info', $_POST['personalInfo'], 60);

        // validate user age
        $errors[] = validateDateOfBirth($_POST['dateOfBirth'], 18);

        // check if user email was edit
        if ($userData['email'] !== $_POST['email']) {
            // Check if email unique
            $errors[] = isUserAlreadyExists($_POST['email'], $conn);
        }

        if (!empty($imageUploadResult) && !is_bool($imageUploadResult)) {
            $errors['imageUploadError'] = $imageUploadResult;
        }

        // Update user if all is ok
        if (empty(array_filter($errors))) {

            $firstName = $conn->real_escape_string($_POST['firstName']);
            $lastName = $conn->real_escape_string($_POST['lastName']);
            $email = $conn->real_escape_string($_POST['email']);
            $dateOfBirth = $conn->real_escape_string($_POST['dateOfBirth']);
            $userStatus = $conn->real_escape_string($_POST['options']);
            $profileImg = $conn->real_escape_string($_FILES['image']['name']);
            $profileInfo = $conn->real_escape_string($_POST['personalInfo']);

            $update_user = "UPDATE users SET
            first_name = '$firstName',
            last_name = '$lastName',
            email = '$email',
            date_of_birth = '$dateOfBirth',
            user_status = '$userStatus',
            profile_img = '$profileImg',
            profile_info = '$profileInfo'
            WHERE user_id = '$userId'";


            // Updating user and user skills
            if (isset($_POST['skills']) && !empty($_POST['skills'])) {
                $delete_old_skills = "DELETE FROM userskills WHERE user_id = '$userId'";
                if ($conn->query($delete_old_skills) === true) {
                    echo "User skills deleted";
                    foreach ($_POST['skills'] as $skillId) {
                        $postUserSkills = "INSERT INTO userskills (skill_id, user_id) VALUES ('$skillId', '$userId')";
                        if ($conn->query($postUserSkills) === true) {
                            echo "User skill updated";
                            if ($conn->query($update_user) === true) {
                                echo "User successfully updated";
                                header('Location: user_list.php');
                            } else {
                                $logMsg = "Error on updating user: " . $conn->error;
                                echo $logMsg . "<br>";
                                writeLog('errors/error_log.txt', $logMsg);
                            }
                        } else {
                            $logMsg = "Error on added skill: " . $conn->error;
                            writeLog('errors/error_log.txt', $logMsg);
                        }
                    }
                } else {
                    $logMsg = "Error on editing skills: " . $conn->error;
                    writeLog('errors/error_log.txt', $logMsg);
                }
            }
        }
    }
}
?>

<?php include('include/header.inc.php'); ?>
    <div class="container mt-2">
        <h1>Edit User</h1>
        <hr>
        <?php if (filter_has_var(INPUT_POST, 'Edit') && array_filter($errors)): ?>
            <div class="alert alert-danger" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <?php foreach ($errors as $error): ?>
                    <p><?php echo $error ?></p>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
        <?php if (filter_has_var(INPUT_POST, 'Edit') && !array_filter($errors)): ?>
            <div class="alert alert-success" role="alert"><h4 class="alert-heading">Well
                    done!</h4> <?php echo "Thank You {$_POST['firstName']} {$_POST['lastName']}"; ?>
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        <?php endif; ?>
        <form action="<?php $_SERVER['PHP_SELF'] ?>" method="post" enctype="multipart/form-data">
            <div class="form-group">
                <label class="col-sm-2 col-form-label">First Name</label>
                <div class="col-sm-5">
                    <input type="text" class="form-control" placeholder="First Name" name="firstName"
                           value="<?php if (isset($userData['first_name']) && !empty($userData['first_name'])) echo $userData['first_name']; ?>">
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-5 col-form-label">Last Name</label>
                <div class="col-sm-5 col-form-label">
                    <input type="text" class="form-control" placeholder="Last Name" name="lastName"
                           value="<?php if (isset($userData['last_name']) && !empty($userData['last_name'])) echo $userData['last_name']; ?>">
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-5 col-form-label">Email</label>
                <div class="col-sm-5 col-form-label">
                    <input type="email" class="form-control" placeholder="Email" name="email"
                           value="<?php if (isset($userData['email']) && !empty($userData['email'])) echo $userData['email']; ?>">
                </div>
                <div class="form-group">
                    <label class="col-sm-5 col-form-label">Data of Birth</label>
                    <div class="col-sm-5 col-form-label">
                        <input type="date" class="form-control" placeholder="Data of Birth" name="dateOfBirth"
                               value="<?php echo date('Y-m-d', strtotime($userData['date_of_birth'])); ?>">
                    </div>
                </div>
                <fieldset class="form-group col">
                    <legend>Your current status?</legend>
                    <!-- TODO: make radio buttons by using loop -->
                    <div class="form-check">
                        <input type="radio" class="form-check-input" name="options"
                               value="0"<?php if ($userData['user_status'] == 0): ?> checked<?php endif; ?>>
                        <label class="form-check-label">Working on company</label>
                    </div>
                    <div class="form-check">
                        <input type="radio" class="form-check-input" name="options"
                               value="1"<?php if ($userData['user_status'] == 1): ?> checked<?php endif; ?>>
                        <label class="form-check-label">I'm self-employed</label>
                    </div>
                    <div class="form-check">
                        <input type="radio" class="form-check-input" name="options"
                               value="2" <?php if ($userData['user_status'] == 2): ?> checked<?php endif; ?>>
                        <label class="form-check-label">Unemployed</label>
                    </div>
                </fieldset>
                <fieldset class="form-group col">
                    <?php if (isset($getAllSkills) && !empty($getAllSkills)): ?>
                        <legend>Please Choose your skills</legend>
                        <?php while ($skill = $getAllSkills->fetch_assoc()): ?>
                            <div class="form-check">
                                <input type="checkbox" class="form-check-input" name="skills[]"
                                       value="<?php echo $skill['skill_id'] ?>"
                                    <?php if (isset($userData['user_skill_list']) && !empty($userData['user_skill_list'])): ?>
                                        <?php if (in_array($skill['skill_id'], array_column($userData['user_skill_list'], 'skill_id'))): ?>
                                            checked
                                        <?php endif; ?>
                                    <?php endif; ?>>
                                <label class="form-check-label"><?php echo strtoupper($skill['skill_name']) ?></label>
                            </div>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <div>
                            <h2>There are no skills please contact administrator that he add them</h2>
                        </div>
                    <?php endif; ?>
                </fieldset>
                <img src="./uploads/<?php echo $userData['profile_img'] ?>" alt="profile photo"
                     class="img-thumbnail h-25 w-25 mb-3">
                <?php if (empty($imageUploadResult)): ?>
                    <div></div>
                <?php elseif ($imageUploadResult === true): ?>
                    <div class="alert alert-dismissible alert-success">
                        <button type="button" class="close" data-dismiss="alert">&times;</button>
                        <strong>Well done!</strong> Your image successfully uploaded.
                    </div>
                <?php elseif (isset($errors['imageUploadError']) && !empty($errors['imageUploadError'])): ?>
                    <div class="alert alert-dismissible alert-danger">
                        <button type="button" class="close" data-dismiss="alert">&times;</button>
                        <strong>Oh snap!</strong>
                        <?php echo $errors['imageUploadError']; ?>
                    </div>
                <?php endif; ?>
                <div class="container-sm pb-3">
                    <input type="file" name="image" class="form-control-file">
                    <small class="form-text text-muted">Here upload your Profile photo. It must has .jpg, .png,
                        .jpeg
                        extensions.<br> Max file size 2MB
                    </small>
                </div>
                <?php if (empty($fileUploadResult)): ?>
                    <div></div>
                <?php elseif ($fileUploadResult === true): ?>
                    <div class="alert alert-dismissible alert-success">
                        <button type="button" class="close" data-dismiss="alert">&times;</button>
                        <strong>Well done!</strong> Your CV successfully uploaded.
                    </div>
                <?php elseif (isset($errors['fileUploadError']) && !empty($errors['fileUploadError'])): ?>
                    <div class="alert alert-dismissible alert-danger">
                        <button type="button" class="close" data-dismiss="alert">&times;</button>
                        <strong>Oh snap!</strong>
                        <?php echo $errors['fileUploadError']; ?>
                    </div>
                <?php endif; ?>
                <div class="container-sm">
                    <input type="file" name="resume">
                    <small class="form-text text-muted">Here upload your CV. It must has .doc, .pdf, docx
                        extensions.<br> Max file size 2MB
                    </small>
                </div>
            </div>
            <div class="form-group col pt-3">
                <label>Personal info</label>
                <textarea class="form-control" name="personalInfo"
                          rows="3"><?php if (isset($userData['profile_info']) && !empty($userData['profile_info'])) echo $userData['profile_info']; ?></textarea>
            </div>
            <div class="form-group col">
                <input type="hidden" name="update_id" value="<?php echo $userId ?>">
                <input type="submit" class="btn-dark" name="Edit" value="Edit">
            </div>
    </div>
    </form>
<?php include('include/footer.inc.php'); ?>