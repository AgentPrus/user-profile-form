<?php

// Form fields validation
function isFieldEmpty($fieldName, $filedValue)
{
    if (empty($filedValue)) {
        return "$fieldName is required";
    }
}

function validateField($filedValue, $filedName)
{
    if (!empty($filedValue) && !preg_match('/^[A-Za-z]+$/', $filedValue)) {
        return "$filedName should contain only English letters";
    }
}

function validateFieldLength($fieldName, $filedValue, $length)
{
    if (strlen($filedValue) > $length) {
        return "$fieldName cannot be greater than $length";
    }
}

function validateDateOfBirth($birthDay, $age)
{
    if (time() < strtotime("+$age years", strtotime($birthDay))) {
        return "You must be $age years old or above";
    }
}

function validateEmail($email)
{
    $emailRegexp = '/^([a-z0-9_\.-]+)@([\da-z\.-]+)\.([a-z\.]{2,6})$/';
    if (!empty($email) && !preg_match($emailRegexp, $email)) {
        return "Incorrect email";
    }
}


// File validation
function getFileExtension($fileName)
{
    $fileExt = explode('.', $fileName);
    return strtolower(end($fileExt));
}

// Check if user choose the file
function isFileChosen($fileName)
{
    return !empty($fileName);
}

function validateFilesType($allowFilesExt, $fileActualExt)
{
    return in_array($fileActualExt, $allowFilesExt);
}

// Check file for errors
function isFileHasErrors($fileErrors)
{
    return $fileErrors > 0;
}

// Check file size
function validateFileSize($fileSize)
{
    $maxFileSize = 2000000; // max file size in KB is equal to 2 MB
    return $fileSize < $maxFileSize;
}

function uploadFile($fileTmpName, $fileName)
{
    $fileDestination = 'uploads/' . $fileName;

    return move_uploaded_file($fileTmpName, $fileDestination);
}

// DB validations
function isUserAlreadyExists($email, $conn)
{
    $getUsr = $conn->query("SELECT email FROM users_profiles.users WHERE email = '$email';");

    if ($getUsr->num_rows !== 0){
        return "User with this email is already exits";
    }
    $conn->close();
}



