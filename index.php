<?php

$errorMsg = [];
$firstName = '';
$lastName = '';
$personalInfo = '';

$isFirstNameValid = false;
$isLastNameValid = false;
$isPersonalInfoValid = false;

function validateFirstNameForm($array, $firstName)
{
    if (empty($firstName)) {
        array_push($array, 'First name is required field');
    }
    if (!preg_match('/^[A-Za-z]+$/', $firstName)) {
        array_push($array, 'First name should contain only English letters');
    }
    if (strlen($firstName) > 60) {
        array_push($array, 'First name cannot be greater than 60 chars');
    }
    return $array;
}

function validateLastNameForm($array, $lastName)
{
    if (empty($lastName)) {
        array_push($array, 'Last name is required field');
    }
    if (!preg_match('/^[A-Za-z]+$/', $lastName)) {
        array_push($array, 'Last name should contain only English letters');
    }
    if (strlen($lastName) > 60) {
        array_push($array, 'Last name cannot be greater than 60 chars');
    }
    return $array;
}

function validatePersonalInfoForm($array, $personalInfo)
{
    if (empty($personalInfo)) {
        array_push($array, 'Personal in is required field');
    }
    if (strlen($personalInfo) > 500) {
        array_push($array, 'Personal in cannot be greater than 500 chars');
    }
    return $array;
}


// Check for submit form
if (filter_has_var(INPUT_POST, 'submit')) {

    // Validate user input
    if (isset($_POST) && !empty($_POST)) {
        $firstName = $_POST['firstName'];
        $lastName = $_POST['lastName'];
        $personalInfo = $_POST['personalInfo'];
    }

    $isFirstNameValid = !empty(validateFirstNameForm($errorMsg, $firstName));
    $isLastNameValid = !empty(validateLastNameForm($errorMsg, $lastName));
    $isPersonalInfoValid = !empty(validatePersonalInfoForm($errorMsg, $personalInfo));

    $errorMsg = validateFirstNameForm($errorMsg, $firstName);
    $errorMsg = validateLastNameForm($errorMsg, $lastName);
    $errorMsg = validatePersonalInfoForm($errorMsg, $personalInfo);
}
?>

<?php include('include/header.inc.php'); ?>
    <div class="container pt-5">
        <h1>Profile Form</h1>
        <hr>
        <?php if (!empty($errorMsg)): ?>
            <div class="alert alert-danger" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <?php foreach ($errorMsg as $error): ?>
                    <p><?php echo $error ?></p>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
        <?php if (filter_has_var(INPUT_POST, 'submit') && empty($errorMsg)): ?>
            <div class="alert alert-success" role="alert"><h4 class="alert-heading">Well
                    done!</h4> <?php echo "Thank You {$_POST['firstName']} {$_POST['lastName']}"; ?>
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        <?php endif; ?>
        <form action="<?php htmlspecialchars($_SERVER['PHP_SELF']) ?>" method="post">
            <div class="form-group">
                <label class="col-sm-2 col-form-label">First Name</label>
                <div class="col-sm-5">
                    <input type="text" class="form-control" placeholder="First Name" name="firstName"
                           value="<?php if ($isFirstNameValid) echo $firstName; ?>">
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-5 col-form-label">Last Name</label>
                <div class="col-sm-5 col-form-label">
                    <input type="text" class="form-control" placeholder="Last Name" name="lastName"
                           value="<?php if ($isLastNameValid) echo $lastName; ?>">
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-5 col-form-label">Data of Birth</label>
                <div class="col-sm-5 col-form-label">
                    <input type="date" class="form-control" placeholder="Data of Birth" name="dateOfBirth">
                </div>
            </div>

            <fieldset class="form-group col">
                <legend>Are you working now?</legend>
                <div class="form-check">
                    <input type="radio" class="form-check-input" name="options" value="No">
                    <label class="form-check-label">Yes</label>
                </div>
                <div class="form-check">
                    <input type="radio" class="form-check-input" name="options" value="No">
                    <label class="form-check-label">No</label>
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
                <label>Personal info</label>
                <textarea class="form-control" name="personalInfo" rows="3"
                          placeholder="<?php if ($isPersonalInfoValid) echo $personalInfo; ?>"></textarea>
            </div>

            <div class="form-group col">
                <input type="submit" class="btn-dark" name="submit">
            </div>
        </form>
    </div>
<?php include('include/footer.inc.php'); ?>