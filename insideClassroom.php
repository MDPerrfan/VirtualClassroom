<?php 
include("header.php");
include("User.php");
include("postAndassignment.php");
$user_array = "";
$courseName = "";
$sec = "";
$body = "";
$post_id = "";
$searchedPost = "";

//fetching class room details
$classCode = $_GET['classCode'];
$user_details_query = mysqli_query($con, "SELECT * FROM createclass WHERE courseCode='$classCode'");
$user_array = mysqli_fetch_array($user_details_query);
$courseName = $user_array['className'];
$sec = $user_array['section'];
$classMates  = $user_array['student_array'];
$classMates = str_replace(',', ' ', $classMates);
$array = explode(" ", $classMates);
$classID = $user_array['id'];

//fetching teacher details
$teacherName = $user_array['username'];
$user_details_query2 = mysqli_query($con, "SELECT * FROM users WHERE username='$teacherName'");
$teacherDetails = mysqli_fetch_array($user_details_query2);

//when hitting the post 
if (isset($_POST['post'])) {
    $post = new Post($con, $userLoggedIn, $classCode);
    $post->submitPost($_POST['post_text'], 'none', 'none', $teacherName);
}

//when uploading files
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
                $fileNameNew = uniqid(" ", true) . "." . $fileActualExt;
                $fileDestination = 'uploads/' . $res . $fileNameNew;
                move_uploaded_file($fileTmpName, $fileDestination); //file uploaded okay

                $post = new Post($con, $userLoggedIn, $classCode);
                $post->submitPost($_POST['assignment_text'], $fileNameNew, $fileDestination,$teacherName);
                //$post->getFileDestination($fileDestination); 

                header("Location: classRoom.php?classCode=$classCode&uploadsuccess");
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
<div class="Wrapper">
    <div class="user_details">
        <center><h1> <i class="fa fa-chalkboard"></i> <?php echo $courseName ?></h1></center>
        <p style='line-height:30px; display: inline-block;'><b>Section:</b> <?php echo $sec ?>
            <br>
            <b>Class Code:</b> <?php echo $classCode ?>
        </p>
     <!--    <div class="assignment_box">
            <a href="#" id="postBtn"><i class="fab fa-megaport" style='margin-right: 5px;'></i>Post</a>
            <a href="#" id="assignmentBtn"><i class="far fa-file-word" style='margin-right: 5px;'></i>Assignment Section</a>
            <?php  if(isset($_POST['upload'])) {
             echo'<span class="assgn-Btn_notification_badge" id="unread_notification"></span>';   
            }?>
        </div> -->
    </div>
    <div class="people_column">
       <h4>Instructor:</h4><a href="<?php echo $teacherName; ?>"><img src='<?php echo $teacherDetails['profilePic'] ?>' width='40'><?php echo $teacherDetails['first_name'] . " " . $teacherDetails['last_name'] ?></a>
        <br>
    <?php 
        $stundentsName  = new User($con, $classCode ,$userLoggedIn);
        echo "<p><b>Class Members:</b> </p>"; ?>
             <?php $stundentsName->getStudentsInfo($classID); ?>
    </div>
</div>
<div class="main">
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
                <a href='insideClassroom.php?classCode=$courseCode'><input type='submit' name='upload' id='assignment-upload-button' value='Upload'></a>
                <hr>
            </form>
            <?php
            $post = new Post($con, $userLoggedIn, $classCode);
            $post->loadFiles();
            ?>
        </div>
        <button id="assignment-button">Assignment</button>
        <button id="post-button" style="display: none;">Post</button>
    </div>

<script>
    const assignmentButton = document.getElementById('assignment-button');
    const postButton = document.getElementById('post-button');
    const firstSection = document.getElementById('first');
    const secondSection = document.getElementById('second');

    assignmentButton.addEventListener('click', function() {
        firstSection.style.display = 'none';
        secondSection.style.display = 'block';
        assignmentButton.style.display = 'none';
        postButton.style.display = 'block';
    });

    postButton.addEventListener('click', function() {
        firstSection.style.display = 'block';
        secondSection.style.display = 'none';
        assignmentButton.style.display = 'block';
        postButton.style.display = 'none';
    });
</script>
</body>
</html>