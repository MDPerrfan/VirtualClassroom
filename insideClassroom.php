<?php 
include("header.php");
include("User.php");
include("postAndassignment.php");
include("classManager.php");
$user_array = "";
$courseName = "";
$sec = "";
$body = "";
$post_id = "";


$classCode = $_GET['classCode'];
$user_details_query = mysqli_query($con, "SELECT * FROM createclass WHERE courseCode='$classCode'");
$user_array = mysqli_fetch_array($user_details_query);
$courseName = $user_array['className'];
$sec = $user_array['section'];
$classMates  = $user_array['student_array'];
$classMates = str_replace(',', ' ', $classMates);
$array = explode(" ", $classMates);
$classID = $user_array['id'];

$teacherName = $user_array['username'];
$user_details_query2 = mysqli_query($con, "SELECT * FROM users WHERE username='$teacherName'");
$teacherDetails = mysqli_fetch_array($user_details_query2);

if (isset($_POST['post'])) {
    $post = new Post($con, $userLoggedIn, $classCode);
    $post->submitPost($_POST['post_text'], 'none', 'none', $teacherName);
}

if (isset($_POST['upload'])) {

    $file = $_FILES['file'];

    $fileName = $_FILES['file']['name'];
    $fileSize = $_FILES['file']['size'];
    $fileType = $_FILES['file']['type'];
    $fileTmpName = $_FILES['file']['tmp_name'];
    $fileError = $_FILES['file']['error'];

    $fileExt = explode('.', $fileName);
    $fileActualExt = strtolower(end($fileExt));

    $allowed  = array('jpg', 'jpeg', 'png', 'pdf', 'docx', 'doc', 'xlsx', 'pptx', 'ppt');
    $res = str_replace($allowed, "", $fileName);

    if (in_array($fileActualExt, $allowed)) {
        if ($fileError === 0) {
            if ($fileSize < 1000000000000) {
      
                $username = $userLoggedIn;
 
                $classCode = $classCode;
      
                $fileNameNew = $username . '_' . uniqid() . '_' . $classCode . '.' . $fileActualExt;
   
                $fileDestination = 'Uploaded by' . $fileNameNew;
                move_uploaded_file($fileTmpName, $fileDestination);

                $post = new Post($con, $userLoggedIn, $classCode);
                $post->submitPost($_POST['assignment_text'], $fileNameNew, $fileDestination,$teacherName);


                header("Location: insideClassroom.php?classCode=$classCode&uploadsuccess");
            } else {
                echo "your file is too big";
            }
        } else {
            echo "Error uploading your file!  ";
        }
    } else {
        echo "You can't upload file of this";
    }
}
$username=$user['username'];
$classManager = new ClassManager($con, $username);
$checkTeaching = $classManager->checkTeachingClass();
if (isset($_POST['mark'])) {
    $postID = $_POST['post_id'];
    $marks = $_POST['marks'];
    $post = new Post($con, $userLoggedIn, $classCode);
    $post->markAssignment($postID, $marks);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Class</title>
    <link rel="stylesheet" href="class.css">
</head>
<body>
<div class="Wrapper2">
    <div class="user_details">
        <center><h1> <i class="fa fa-chalkboard"></i> <?php echo $courseName ?></h1></center>
        <p style='line-height:30px; display: inline-block;'><b>Section:</b> <?php echo $sec ?>
            <br>
            <b>Class Code:</b> <?php echo $classCode ?>
            <br>
            <b>Instructor:</b><?php echo $teacherDetails['first_name'] . " " . $teacherDetails['last_name'] ?>
            <br>
            <div class="people_column">
            <?php 
                $classMates = $user_array['student_array'];
                $classMates = str_replace(',', ' ', $classMates);
                echo "<p><b>Class Members:</b> $classMates <br></p>";
             ?>
             </div>
             <br>
            <button id="showStudentsButton">Students</button>
            </p>
    </div>
</div>
<div class="main2">
        <div id="first">
            <form class="post_form" method="POST">
                <textarea name='post_text' id='post_text_area' placeholder='Share your thoughts'></textarea>
                <input type='submit' name='post' id='post_button' value='post'>
            </form>
            <?php
            $post = new Post($con, $userLoggedIn, $classCode);
            $post->loadPosts();
            ?>
        </div>

        <div id="second">
            <form class="assignment_form" method="POST" enctype="multipart/form-data">
                <input type="file" name="file" id="fileToUpload">
                <textarea name='assignment_text' id='assignment-textarea' placeholder='Type here'></textarea>
                <a href='insideClassroom.php'><input type='submit' name='upload' id='assignment-upload-button' value='Upload'></a>
                <hr>
            </form>
            <?php
            $post = new Post($con, $userLoggedIn, $classCode);
            if($checkTeaching){
                $post->loadFiles();
            }
            else{
                $post->loadFiles1();
            }
            ?>
        </div>
        <div class="navigation-menu"> 
            <button class="navigation-link" id="assignment-button">Assignment</button>
            <button class="navigation-link" id="post-button">Post</button>
        </div>
    </div>

   
    <script>
    const assignmentButton = document.getElementById('assignment-button');
    const postButton = document.getElementById('post-button');
    const firstSection = document.getElementById('first');
    const secondSection = document.getElementById('second');

    assignmentButton.addEventListener('click', function() {
        if (secondSection.style.display === 'none') {
            firstSection.style.display = 'none';
            secondSection.style.display = 'block';
        } else {
            secondSection.style.display = 'none';
        }
    });

    postButton.addEventListener('click', function() {
        if (firstSection.style.display === 'none') {
            firstSection.style.display = 'block';
            secondSection.style.display = 'none';
        } else {
            firstSection.style.display = 'none';
        }
    });
    assignmentButton.addEventListener('dblclick', function(event) {
        secondSection.style.display = 'none';
    });

    postButton.addEventListener('dblclick', function(event) {
        firstSection.style.display = 'none';
    });
</script>
<script>
const showStudentsButton = document.getElementById('showStudentsButton');
const peopleColumn = document.querySelector('.people_column');

showStudentsButton.addEventListener('click', function() {
    if (peopleColumn.style.display === 'none') {
        peopleColumn.style.display = 'block';
    } else {
        peopleColumn.style.display = 'none';
    }
});
</script>

</body>
</html>