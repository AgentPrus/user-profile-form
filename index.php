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
    <form action="index.php" method="post">
        <fieldset>
            <div class="container">
                <div class="form-group">
                    <label class="col-form-label">First Name
                        <input type="text" class="form-control" placeholder="First Name" name="firstName">
                    </label>
                </div>
            </div>
            <div class="container">
                <div class="form-group">
                    <label class="col-form-label">Last Name
                        <input type="text" class="form-control" placeholder="Last Name" name="lastName">
                    </label>
                </div>
            </div>
            <div class="container">
                <div class="form-group">
                    <label class="col-form-label">Data of Birth
                        <input type="date" class="form-control" placeholder="Data of Birth" name="dateOfBirth">
                    </label>
                </div>
            </div>

            <div class="container">
                <fieldset>
                    <legend>Are you working now?</legend>
                    <label class="form-check-label">
                        <input type="radio" name="options" value="Yes" checked="checked"> Yes
                    </label>
                    <label class="orm-check-label">
                        <input type="radio" name="options" value="No"> No
                    </label>
                </fieldset>
            </div>
            <div class="container form-check">
                <fieldset>
                    <legend>Please Choose Technologies Which You Know</legend>
                    <label class="form-check">
                        <input type="checkbox" name="check_boxes_list[]" value="JS">JS<br>
                    </label>
                    <label class="form-check">
                        <input type="checkbox" name="check_boxes_list[]" value="CSS">CSS<br>
                    </label>
                    <label class="form-check">
                        <input type="checkbox" name="check_boxes_list[]" value="HTML">HTML<br>
                    </label>
                    <label class="form-check">
                        <input type="checkbox" name="check_boxes_list[]" value="PHP">PHP<br>
                    </label>
                    <label class="form-check">
                        <input type="checkbox" name="check_boxes_list[]" value="NODEJS">NODE JS<br>
                    </label>
                </fieldset>
            </div>
            <div class="container form-group">
                <label>Personal info info
                    <textarea class="form-control" name="personalInfo" rows="3"></textarea>
                </label>
            </div>
        </fieldset>
        <div class="container">
            <input type="submit" class="btn-dark">
        </div>
    </form>
<?php include('include/footer.inc.php'); ?>