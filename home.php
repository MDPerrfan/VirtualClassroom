<?php 
include("header.php");
include("classManager.php");
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
                    <p>Oops! You are not in any class</p>
                    <a href='createJoinClass.php'>
                        <button class='null-button'>Create/Join</button>
                    </a>
                </div>";
        }
        ?>
    </div>
</body>

</html>