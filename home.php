<?php 
include("header.php");
include("classManager.php");
if(isset($_SESSION['username'])){
    $userLoggedIn  = $_SESSION['username'];
    $user_details_query = mysqli_query($con, "SELECT * FROM users WHERE username = '$userLoggedIn'");
    $user = mysqli_fetch_array($user_details_query);

}
else{
  header("Location:registration.php");
}
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
$username=$user['username'];
$classManager = new ClassManager($con, $username);
$checkTeaching = $classManager->checkTeachingClass();
$checkEnrolled = $classManager->checkEnrolledClass();

if ($checkTeaching) {
    echo "<div class='teaching'>
            <h3><span class='header'>Class conducted by <br> </span><br> {$user['first_name']}</h3>";
    $classManager->loadTeachingClasses();
    echo "</div>";
}

if ($checkEnrolled) {
    echo "<div class='enrolled'>
            <h3><span class='header'>Class Enrolled In  :</span></h3>";
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