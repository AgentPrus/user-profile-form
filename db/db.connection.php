<?php
include('/Users/mprus/scripts/user-profile-form/config/config.php');
include_once('/Users/mprus/scripts/user-profile-form/errors/errorlog.php');
// Create connection
$conn = new mysqli(DB_SERVER_NAME, DB_USER_NAME, DB_PASSWORD);

// Check connection
if ($conn->connect_error) {
    $logMsg = "Connection failed:" . $conn->connect_error;
    writeLog('errors/error_log.txt', $logMsg);
} else {
    echo "Connection success" . "<br>";
}
