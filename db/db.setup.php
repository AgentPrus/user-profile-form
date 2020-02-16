<?php
include_once('db.connection.php');
// Create database
$createDb = "CREATE DATABASE IF NOT EXISTS users_profiles";

if ($conn->query($createDb) === true) {
    echo "Database created successfully" . "<br>";
} else {
    $logMsg = "Error creating database: " . $conn->error;
    writeLog('errors/error_log.txt', $logMsg);
}
// Create tables
$createUsersTable = "CREATE TABLE IF NOT EXISTS users_profiles.users
(
user_id INT PRIMARY KEY AUTO_INCREMENT NOT NULL,
first_name VARCHAR(60) NOT NULL,
last_name VARCHAR(60) NOT NULL,
email VARCHAR(255) NOT NULL,
date_of_birth DATETIME NOT NULL,
user_status INT NOT NULL,
profile_img VARCHAR(100),
profile_info VARCHAR(500) NOT NULL
);";

$createSkillsTable = "CREATE TABLE IF NOT EXISTS users_profiles.skills
(
skill_id INT PRIMARY KEY AUTO_INCREMENT,
skill_name VARCHAR(30) NOT NULL
);";

$createUserSkillsTable = "CREATE TABLE IF NOT EXISTS users_profiles.userskills
(
id INT PRIMARY KEY AUTO_INCREMENT NOT NULL,
skill_id INT NOT NULL,
user_id INT NOT NULL,
FOREIGN KEY (SKILL_ID) REFERENCES users_profiles.skills(skill_id) ON DELETE CASCADE,
FOREIGN KEY (USER_ID) REFERENCES users_profiles.users(user_id) ON DELETE CASCADE
);";


if ($conn->query($createUsersTable) === true && $conn->query($createSkillsTable) === true && $conn->query($createUserSkillsTable) === true) {
    echo "Tables are successfully created" . "<br>";
} else {
    $logMsg = "Error creating database: " . $conn->error;
    writeLog('errors/error_log.txt', $logMsg);
}