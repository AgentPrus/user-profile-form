<?php
include_once('db.connection.php');

// Create database
$createDb = "create database if not exists users_profiles";

if ($conn->query($createDb) === true) {
    echo "Database created successfully" . "<br>";
} else {
    echo "Error creating database: " . $conn->error;
}
// Create tables
$createUsersTable = "create table if not exists users_profiles.users
(
user_id int primary key auto_increment not null,
first_name varchar(60) not null,
last_name varchar(60) not null,
date_of_birth datetime not null,
user_status varchar(30) not null,
profile_img varchar(100),
profile_info varchar(500) not null
);";

$createSkillsTable = "create table if not exists users_profiles.skills
(
skill_id int primary key auto_increment,
skill_name varchar(30) not null
);";

$createUserSkillsTable = "create table if not exists users_profiles.userskills
(
id int primary key auto_increment not null,
skill_id int not null,
user_id int not null,
foreign key (skill_id) references users_profiles.skills(skill_id) on delete cascade,
foreign key (user_id) references users_profiles.users(user_id) on delete cascade
);";


if ($conn->query($createUsersTable) === true && $conn->query($createSkillsTable) === true && $conn->query($createUserSkillsTable) === true) {
    echo "Tables are successfully created" . "<br>";
} else {
    echo "Error creating table: " . $conn->connect_error;
}