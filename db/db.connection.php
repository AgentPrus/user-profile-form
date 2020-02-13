<?php
include('config/config.php');

// Create connection
$conn = new mysqli(DB_SERVER_NAME, DB_USER_NAME, DB_PASSWORD);

// Check connection
if ($conn->connect_error){
    die("Connection failed:" . $conn->connect_error);
} else {
    echo "Connection success" . "<br>";
}

$createDb = "create database if not exists users_profiles";
