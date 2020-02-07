<?php
if (isset($_POST) && !empty($_POST)) {

    // TODO: Reduce uploading file validation code

    // Extension  types of the files available to upload
    $allowedImageExt = ['jpg', 'jpeg', 'png'];
    $allowedResumeExt = ['pdf', 'doc', 'docx'];

    function getFileExtension($fileName)
    {
        $fileExt = explode('.', $fileName);
        return strtolower(end($fileExt));
    }

    function uploadFile($fileActualExt, $allowedExt, $fileErrors, $fileSize, $fileTmpName, $fileName)
    {
        $fileDestination = 'uploads/' . $fileName;
        $maxFileSize = 2000000; // max file size in KB is equal to 2 MB

        // Check if file has correct type
        if (in_array($fileActualExt, $allowedExt)) {
            // Check if file has errors
            if ($fileErrors === 0) {
                // Check file size
                if ($fileSize < $maxFileSize) {
                    return move_uploaded_file($fileTmpName, $fileDestination);
                } else {
                    return 'File is too big';
                }
            } else {
                return "There were errors while uploading your file";
            }
        } else {
            return "You cannot upload file of this type!";
        }
    }

    // Check if image exists
    if (isset($_FILES['image']['name']) && !empty($_FILES['image']['name'])) {
        $uploadedImageResult = uploadFile(getFileExtension($_FILES['image']['name']), $allowedImageExt, $_FILES['image']['error'], $_FILES['image']['size'], $_FILES['image']['tmp_name'], $_FILES['image']['name']);
    }
    // Check if resume exists
    if (isset($_FILES['resume']['name']) && !empty($_FILES['resume']['name'])) {
        $uploadedCVResult = uploadFile(getFileExtension($_FILES['resume']['name']), $allowedResumeExt, $_FILES['resume']['error'], $_FILES['resume']['size'], $_FILES['resume']['tmp_name'], $_FILES['resume']['name']);
    }
}