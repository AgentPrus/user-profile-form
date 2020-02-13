<?php
include('../config/config.php');
include('db.connection.php');


$firstName = $_POST['firstName'];
$lastName = $_POST['lastName'];
$dateOfBirth = $_POST['dateOfBirth'];
$userStatus = $_POST['options'];
$profileImg = $_FILES['image']['name'];
$profileInfo = $_POST['personalInfo'];

$createUser = "insert into users_profiles.users(first_name, last_name, date_of_birth, profile_img, profile_info, user_status)
values ('$firstName', '$lastName', '$dateOfBirth', '$profileImg', '$profileInfo', '$userStatus')";

if ($conn->query($createUser) === true) {
    echo "User successfully created";
} else {
    echo "Error: " . $createUser . "<br>" . $conn->error;
}