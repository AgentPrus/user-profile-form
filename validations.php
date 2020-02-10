<?php

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



