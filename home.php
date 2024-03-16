<?php 
include("header.php");
include("classManager.php");
require 'handler/createJoinClasshandler.php'; 
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>
    <link rel="stylesheet" href="home.css">
</head>

<body>
    <div class="wrapper">
        <?php
        $username = $user['username'];
        $classManager = new ClassManager($con, $username);
        $checkTeaching = $classManager->checkTeachingClass();
        $checkEnrolled = $classManager->checkEnrolledClass();

        if ($checkTeaching) {
            echo "<div class='teaching'>
                    <h3><span class='header'>Teaching</span></h3>";
            $classManager->loadTeachingClasses();
            echo "</div>";
        }

        if ($checkEnrolled) {
            echo "<div class='enrolled'>
                    <h3><span class='header'>Enrolled:</span></h3>";
            $classManager->loadEnrolledClasses();
            echo "</div>";
        }

        if (!$checkTeaching && !$checkEnrolled) {
            echo "<div id='nullTeachingEnrolled'>
                    <p>It seems you haven't created or enrolled in any class yet!</p>
                    <p>Click the button below or <i class='fas fa-plus' style='padding:0.4rem; color:inherit'></i> above to start with your class</p>
                    <a href='createJoinClass.php'>
                        <button class='null-button'>Create/Join</button>
                    </a>
                </div>";
        }
        ?>
    </div>
    <div class="bg"></div>
    <div class="bg bg2"></div>
    <div class="bg bg3"></div>
</body>

</html>