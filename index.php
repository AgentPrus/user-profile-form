<?php

$errorMsg = '';
$success = false;

// Check for submit form
if (filter_has_var(INPUT_POST, 'submit')) {

    // Get form data
    $firstName = $_POST['firstName'];
    $lastName = $_POST['lastName'];
    $personalInfo = $_POST['personalInfo'];

    // Validate user input
    if (empty($firstName) || empty($lastName) || empty($personalInfo)) {
        $errorMsg = '<strong>First Name, Last Name, Personal Info</strong> are required fields';
    } elseif (empty($firstName) || !ctype_alpha($firstName) || strlen($firstName) > 60) {
        $errorMsg = '<strong>First name</strong> should contain only English letters and not greater than 60 chars';
    } elseif (empty($lastName) || !ctype_alpha($lastName) || strlen($lastName) > 60) {
        $errorMsg = '<strong>Last name</strong> should contain only English letters and not greater than 60 chars';
    } elseif (strlen($personalInfo) > 500) {
        $errorMsg = '<strong>Personal info</strong> cannot be greater than 500 chars';
    } else {
        $success = true;
    }
}
?>

<?php include('include/header.inc.php'); ?>
    <div class="container pt-5">
        <h1>Profile Form</h1>
        <hr>
        <?php if ($errorMsg != ''): ?>
            <div class="alert alert-danger <?php echo $errorMsg ?>" role="alert"> <?php echo $errorMsg; ?>
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        <?php endif; ?>
        <?php if ($success): ?>
            <div class="alert alert-success <?php echo $errorMsg ?>" role="alert"><h4 class="alert-heading">Well
                    done!</h4> <?php echo "Thank You {$firstName} {$lastName}"; ?>
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        <?php endif; ?>
        <form action="<?php htmlspecialchars($_SERVER['PHP_SELF']) ?>" method="post">
            <div class="form-group">
                <label class="col-sm-2 col-form-label">First Name</label>
                <div class="col-sm-5">
                    <input type="text" class="form-control" placeholder="First Name" name="firstName">
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-5 col-form-label">Last Name</label>
                <div class="col-sm-5 col-form-label">
                    <input type="text" class="form-control" placeholder="Last Name" name="lastName">
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
                <label>Personal info info</label>
                <textarea class="form-control" name="personalInfo" rows="3"></textarea>
            </div>

            <div class="form-group col">
                <input type="submit" class="btn-dark" name="submit">
            </div>
        </form>
    </div>
<?php include('include/footer.inc.php'); ?>