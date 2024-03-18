<?php 
include("header.php");
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
    $post = new Post($con, $userLoggedIn2, $classCode);
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

/* if (isset($_GET['uploadsuccess'])) {   // hold back the assignment div(#second) after delete or upload
    echo '<script>
                     $(document).ready(function(){
                         $("#first").hide();
                         $("#second").show();
                       });
                       </script>
                       ';
} */
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your Page Title</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }

        .Wrapper2 {
            display: flex;
            align-items:center;
            justify-content: center;
            margin-top: 6rem;
        }

        .user_details {
            margin:2rem;
            width: 30%;
            background-color: #f2f2f2;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .user_details h1 {
            font-size: 24px;
            margin-top: 20px;
        }

        .people_column {
            width: 30%;
            background-color: #f2f2f2;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .people_column h4 {
            font-size: 18px;
            margin-bottom: 10px;
        }

        .people_column a {
            text-decoration: none;
            color: #333;
        }

        .main_column {
            flex-grow: 1;
            background-color: #f2f2f2;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .post_form textarea,
        .assignment_form textarea {
            width: 100%;
            height: 100px;
            margin-bottom: 10px;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            resize: none;
        }

        .post_form #post_button,
        .assignment_form #assignment-upload-button {
            padding: 10px 20px;
            background-color: #4CAF50;
            border: none;
            color: white;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        .post_form #post_button:hover,
        .assignment_form #assignment-upload-button:hover {
            background-color: #45a049;
        }
    </style>
</head>
<body>
<div class=Wrapper2>
    <div class="user_details cloumn">
        <center><h1> <i class="fa fa-chalkboard-teacher" style="margin-top:6rem;"></i> <?php echo $courseName ?></h1></center>
        <p style='line-height:30px; display: inline-block;'><b>Section:</b> <?php echo $sec ?>
            <br>
            <b>Class Code:</b> <?php echo $classCode ?>
        </p> 
        <div class="assignment_box">
            <a href="#" id="postBtn"><i class="fab fa-megaport" style='margin-right: 5px;'></i>Post</a>
            
            <a href="#" id="assignmentBtn"><i class="far fa-file-word" style='margin-right: 5px;'></i>Assignment Section</a>
            <?php  if(isset($_POST['upload'])) {
             echo'<span class="assgn-Btn_notification_badge" id="unread_notification"></span>';   
            }?>
        </div>
    </div>
    <div class="people_column">
       <h4>Instructor:</h4><a href="<?php echo $teacherName; ?>"><img src='<?php echo $teacherDetails['profilePic'] ?>' width='40'><?php echo $teacherDetails['first_name'] . " " . $teacherDetails['last_name'] ?></a>
        <br>
        <!-- <?php echo "Posts: " . $user_array['num_posts'] . "<br>"; ?> -->
        <!-- <?php 
        $stundentsName  = new User($con, $classCode ,$userLoggedIn);
        echo "<p><b>Class Members: </b></p>"; ?>
             <?php $stundentsName=implode(', ',$array);
             echo $stundentsName; ?>  -->

    <?php 
        $stundentsName  = new User($con, $classCode ,$userLoggedIn);
        echo "<p><b>Class Members:</b> </p>"; ?>
             <?php $stundentsName->getStudentsInfo($classID); ?>
    </div>

    <div class="main_column">
        <div id="first">
            <form class="post_form" method="POST">
                <textarea name='post_text' id='post_text_area' placeholder='Share something...'></textarea>
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
                <a href='classRoom.php?classCode=$courseCode'><input type='submit' name='upload' id='assignment-upload-button' value='Upload'></a>
                <hr>
            </form>
            <?php
            $post = new Post($con, $userLoggedIn, $classCode);
            $post->loadFiles();
            ?>
        </div>
    </div>
</div>


<!-- <script>
    var expandBtn = document.getElementById('code_expand');
    var modal = document.getElementById("modal");
    var closeBtn = document.getElementById("close_btn");

    expandBtn.addEventListener('click', openModal);

    closeBtn.addEventListener('click', closeModal);

    window.addEventListener('click', clickOutsideModal);

    function openModal() {
        modal.style.display = 'block';
    }

    function closeModal() {
        modal.style.display = 'none';
    }

    function clickOutsideModal(e) {
        if (e.target == modal) {
            modal.style.display = 'none';
        }
    }

    let editBtn = document.getElementsByClassName('edit_post_btn');
    let modal2 = document.getElementById("modal2");
    let updateBtn = document.getElementById("update_btn");
    let cancelBtn = document.getElementById('update_cancel_btn');

    // for (var i = 0; i < editBtn.length; i++) {
    //     editBtn[i].addEventListener('click', openModal2);
    // }

    updateBtn.addEventListener('click', closeModal2);
    // cancelBtn.addEventListener('click', closeModal2);

    // function openModal2() {
    //     modal2.style.display = 'block';
    // }

    function closeModal2() {
        modal.style.display = 'none';
    }

    $(document).ready(function() {
        $('edit_post_btn').click(function() {
            modal2.style.display = 'block';
        });
    });


    //slide up down of post and assignment 

    //on click signup, hide login and show registration form
    $(document).ready(function() {

        $("#assignmentBtn").click(function() { //show assignment form and hide post form 
            $("#first").slideUp("slow", function() {
                $("#second").slideDown("slow");
            });
        });

        $("#postBtn").click(function() {
            $("#second").slideUp("slow", function() { //vice versa
                $("#first").slideDown("slow");
            });
        });
    });
    
    
</script> -->
</body>

</html> 