<?php

$inputData = [
    'firstName' => $_POST['firstName'],
    'lastName' => $_POST['lastName'],
    'dateOfBirth' => $_POST['dateOfBirth'],
    'options' => $_POST['options'],
    'personalInfo' => $_POST['personalInfo'],

];

$checkBoxesData = !empty($_POST['check_boxes_list']) ? $_POST['check_boxes_list'] : [];
if (count($checkBoxesData) > 0) {
    array_push($inputData, $checkBoxesData);
}

print_r($inputData);
?>

<?php include('include/header.inc.php'); ?>
    <div class="container">
        <form action="index.php" method="post">
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
                    <input type="radio" class="form-check-input" name="options" value="No" checked>
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
                <input type="submit" class="btn-dark">
            </div>
        </form>
    </div>
<?php include('include/footer.inc.php'); ?>