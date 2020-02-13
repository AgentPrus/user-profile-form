<?php
include_once('db/db.connection.php');
include('uploads.php');

// Check for submit form
if (filter_has_var(INPUT_POST, 'submit')) {

    if (isset($_POST) && !empty($_POST)) {
        $firstName = $conn->real_escape_string($_POST['firstName']);
        $lastName = $conn->real_escape_string($_POST['lastName']);
        $email = $conn->real_escape_string($_POST['email']);
        $dateOfBirth = $conn->real_escape_string($_POST['dateOfBirth']);
        $userStatus = $conn->real_escape_string($_POST['options']);
        $profileImg = $conn->real_escape_string($_FILES['image']['name']);
        $profileInfo = $conn->real_escape_string($_POST['personalInfo']);

        $errors = [];

        // check on empty fields
        $errors[] = isFieldEmpty('First name', $firstName);
        $errors[] = isFieldEmpty('Last name', $lastName);
        $errors[] = isFieldEmpty('Email', $email);
        $errors[] = isFieldEmpty('Personal Info', $profileInfo);
        $errors[] = isFieldEmpty('Date of Birth', $dateOfBirth);

        // validate fields
        $errors[] = validateField($firstName, 'First name');
        $errors[] = validateField($lastName, 'Last name');
        $errors[] = validateEmail($email);

        // validate fields length
        $errors[] = validateFieldLength('First name', $firstName, 60);
        $errors[] = validateFieldLength('Last name', $lastName, 60);
        $errors[] = validateFieldLength('Personal info', $profileInfo, 60);

        // validate user age
        $errors[] = validateDateOfBirth($dateOfBirth, 18);

        // Add an error if it occurred while loading the file
        if (!empty($fileUploadResult) && !is_bool($fileUploadResult)) {
            $errors['fileUploadError'] = $fileUploadResult;
        }

        if (!empty($imageUploadResult) && !is_bool($imageUploadResult)) {
            $errors['imageUploadError'] = $imageUploadResult;
        }

        // Check if email unique
        $errors[] = isUserAlreadyExists($email, $conn);

        // Create user if all is ok
        if (empty(array_filter($errors))) {
            $createUser = "INSERT INTO users_profiles.users(first_name, last_name, email, date_of_birth, profile_img, profile_info, user_status)
        VALUES ('$firstName', '$lastName', '$email', '$dateOfBirth', '$profileImg', '$profileInfo', '$userStatus')";

            if ($conn->query($createUser) === true) {
                echo "User successfully created";
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
    <div class="container pt-5">
        <h1>Profile Form</h1>
        <hr>
        <?php if (filter_has_var(INPUT_POST, 'submit') && array_filter($errors)): ?>
            <div class="alert alert-danger" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <?php foreach ($errors as $error): ?>
                    <p><?php echo $error ?></p>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
        <?php if (filter_has_var(INPUT_POST, 'submit') && !array_filter($errors)): ?>
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
                           value="<?php if (isset($_POST['firstName']) && !empty($_POST['firstName'])) echo $_POST['firstName']; ?>">
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-5 col-form-label">Last Name</label>
                <div class="col-sm-5 col-form-label">
                    <input type="text" class="form-control" placeholder="Last Name" name="lastName"
                           value="<?php if (isset($_POST['lastName']) && !empty($_POST['lastName'])) echo $_POST['lastName']; ?>">
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-5 col-form-label">Email</label>
                <div class="col-sm-5 col-form-label">
                    <input type="email" class="form-control" placeholder="Email" name="email"
                           value="<?php if (isset($_POST['email']) && !empty($_POST['email'])) echo $_POST['email']; ?>">
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-5 col-form-label">Data of Birth</label>
                <div class="col-sm-5 col-form-label">
                    <input type="date" class="form-control" placeholder="Data of Birth" name="dateOfBirth"
                           value="<?php if (isset($_POST['dateOfBirth']) && !empty($_POST['dateOfBirth'])) echo htmlspecialchars(date($_POST['dateOfBirth'])); ?>">
                </div>
            </div>

            <fieldset class="form-group col">
                <legend>Your current status?</legend>
                <div class="form-check">
                    <input type="radio" class="form-check-input" name="options" value="Working on company" checked>
                    <label class="form-check-label">Working on company</label>
                </div>
                <div class="form-check">
                    <input type="radio" class="form-check-input" name="options" value="I'm self-employed">
                    <label class="form-check-label">I'm self-employed</label>
                </div>
                <div class="form-check">
                    <input type="radio" class="form-check-input" name="options" value="Unemployed">
                    <label class="form-check-label">Unemployed</label>
                </div>
            </fieldset>
            <fieldset class="form-group col">
                <legend>Please Choose Technologies Which You Know</legend>
                <div class="form-check">
                    <input type="checkbox" class="form-check-input" name="check_boxes_list[]" value="JS">
                    <label class="form-check-label">JS</label>
                </div>
                <div class="form-check">
                    <input type="checkbox" class="form-check-input" name="check_boxes_list[]" value="CSS">
                    <label class="form-check-label">CSS</label>
                </div>
                <div class="form-check">
                    <input type="checkbox" class="form-check-input" name="check_boxes_list[]" value="HTML">
                    <label class="form-check-label">HTML</label>
                </div>
                <div class="form-check">
                    <input type="checkbox" class="form-check-input" name="check_boxes_list[]" value="PHP">
                    <label class="form-check-label">PHP</label>
                </div>
                <div class="form-check">
                    <input type="checkbox" class="form-check-input" name="check_boxes_list[]" value="NODEJS">
                    <label class="form-check-label">NODE JS</label>
                </div>
            </fieldset>
            <div class="form-group col">
                <h5>Upload your files</h5>
                <?php if (empty($imageUploadResult)): ?>
                    <div></div>
                <?php elseif ($imageUploadResult === true): ?>
                    <div class="alert alert-dismissible alert-success">
                        <button type="button" class="close" data-dismiss="alert">&times;</button>
                        <strong>Well done!</strong> Your image successfully uploaded.
                    </div>
                <?php else: ?>
                    <div class="alert alert-dismissible alert-danger">
                        <button type="button" class="close" data-dismiss="alert">&times;</button>
                        <strong>Oh snap!</strong> <?php echo $errors['imageUploadError']; ?>
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
                <?php else: ?>
                    <div class="alert alert-dismissible alert-danger">
                        <button type="button" class="close" data-dismiss="alert">&times;</button>
                        <strong>Oh snap!</strong> <?php echo $errors['fileUploadError']; ?>
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
                          rows="3"><?php if (isset($_POST['personalInfo']) && !empty($_POST['personalInfo'])) echo $_POST['personalInfo']; ?></textarea>
            </div>
            <div class="form-group col">
                <input type="submit" class="btn-dark" name="submit">
            </div>
        </form>
    </div>
<?php include('include/footer.inc.php'); ?>