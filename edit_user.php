<?php
include_once('db/db.connection.php');

$userId = $conn->real_escape_string($_GET['id']);
$getUser = $conn->query("SELECT * FROM users WHERE user_id = '$userId'");
$userData = $getUser->fetch_assoc();

print_r($userData);

echo date('"m/d/Y"', strtotime($userData['date_of_birth'])) . "<br>";

?>

<?php include('include/header.inc.php'); ?>
    <div class="container mt-2">
    <h1>Edit User</h1>
    <hr>
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
                <input type="date" class="form-control" placeholder="Data of Birth" name="date_of_birth"
                       value="12-12-2020">
            </div>
        </div>
        <fieldset class="form-group col">
            <legend>Your current status?</legend>
            <!-- TODO: Get user current status and display it-->
            <!-- TODO: Change radio btn values-->
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
        <div class="form-group col pt-3">
            <label>Personal info</label>
            <textarea class="form-control" name="personalInfo"
                      rows="3"><?php if (isset($userData['profile_info']) && !empty($userData['profile_info'])) echo $userData['profile_info']; ?></textarea>
        </div>
        <div class="form-group col">
            <input type="submit" class="btn-dark" name="Edit" value="edit">
        </div>
    </div>
<?php include('include/footer.inc.php'); ?>