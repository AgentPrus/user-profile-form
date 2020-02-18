<?php
include_once('db/db.connection.php');

$user_status = ["Working on company", "I'm self-employed", "Unemployed"];

$userId = $conn->real_escape_string($_GET['id']);
$getUser = $conn->query("SELECT * FROM users WHERE user_id = '$userId'");
$user_info = $getUser->fetch_assoc();

$getUserSkills = $conn->query("SELECT skills.skill_name
FROM userskills
JOIN skills ON skills.skill_id = userskills.skill_id
WHERE user_id = '$userId'");

?>


<?php include('include/header.inc.php'); ?>
<div class="container">
    <div class="media">
        <img class="align-self-center mr-5" src="./uploads/<?php echo $user_info['profile_img'] ?>" alt="profile photo"
             style="width: 200px; height: 200px">
        <div class="media-body">
            <h2 class="mt-0"><?php echo $user_info['first_name'] . ' ' . $user_info['last_name'] ?></h2>
            <div class="mt-3">
                <h3>Skills: </h3>
                <?php while ($row = $getUserSkills->fetch_assoc()): ?>
                    <span class="badge badge-primary"><?php echo $row['skill_name'] ?></span>
                <?php endwhile; ?>
            </div>
            <hr>
            <ul class="list-group">
                <li class="list-group-item"><i class="fas fa-envelope mr-3"></i><?php echo $user_info['email'] ?></li>
                <li class="list-group-item"><i class="fas fa-birthday-cake mr-3">
                    </i><?php echo date('Y-m-d', strtotime($user_info['date_of_birth'])) ?>
                </li>
                <li class="list-group-item"><i
                            class="fas fa-briefcase mr-3"></i><?php echo $user_status[$user_info['user_status']] ?></li>
            </ul>
            <hr>
            <h3>About me</h3>
            <p class="lead"><?php echo $user_info['profile_info'] ?></p>
        </div>
    </div>
</div>
<?php include('include/footer.inc.php'); ?>
