<?php
include('validations.php');

// Extension  types of the files available to upload
$allowedResumeExt = ['pdf', 'doc', 'docx'];
$allowedImageExt = ['jpg', 'jpeg', 'png'];

$imageUploadStatus = false;
$fileUploadStatus = false;

$imageUploadResult = '';
$fileUploadResult = '';

// Upload file validation
if (isset($_FILES) && !empty($_FILES)) {
    $imageExtension = getFileExtension($_FILES['image']['name']);
    $fileExtension = getFileExtension($_FILES['resume']['name']);

    // Check if user chose file
    if (isFileChosen($_FILES['image']['name']) && isFileChosen($_FILES['resume']['name'])) {
        $imageUploadStatus = true;
        $fileUploadStatus = true;
        // Check files size
        if (validateFileSize($_FILES['image']['size']) && validateFileSize($_FILES['resume']['size'])) {
            $imageUploadStatus = true;
            $fileUploadStatus = true;

            // Check files format
            if (validateFilesType($allowedImageExt, $imageExtension)) {
                $imageUploadStatus = true;
            } else {
                $errorMsg = "You cannot upload image of this type!";
                $imageUploadStatus = false;
            }
            if (validateFilesType($allowedResumeExt, $fileExtension)) {
                $fileUploadStatus = true;
            } else {
                $errorMsg = "You cannot upload file of this type!";
                $fileUploadStatus = false;
            }

        } else {
            $errorMsg = "Files are too big";
            $imageUploadStatus = false;
            $fileUploadStatus = false;
        }

    } else {
        $errorMsg = 'Files are required. Please upload their';
        $fileUploadStatus = false;
        $imageUploadStatus = false;

    }

    if ($imageUploadStatus) {
        $imageUploadResult = uploadFile($_FILES['image']['tmp_name'], $_FILES['image']['name']);
    } else {
        $imageUploadResult = $errorMsg;
    }

    if ($fileUploadStatus) {
        $fileUploadResult = uploadFile($_FILES['resume']['tmp_name'], $_FILES['resume']['name']);
    } else {
        $fileUploadResult = $errorMsg;
    }
}