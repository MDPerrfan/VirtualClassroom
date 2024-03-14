<?php 
include("header.php");
require 'config.php' ;
require 'handler/createJoinClasshandler.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create or Join Class</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <link rel="stylesheet" href="cj.css">
</head>
<body>
<div class="bg">
    <div class="wrapper">
        <div class="creatClass_box">  	
            <div id="first">
                <div class="creatClass_header">
                    <h1>Create Class</h1>
                </div>
                <form action="createJoinClass.php" method="POST">
                    <input type="text" name="className" autocomplete="off" placeholder="Class Name/Course Code" value="">
                    <br>
                    <input type="text" name="section" autocomplete="off" placeholder="Section" value="">
                    <br>
                    <input type="text" name="subject" autocomplete="off" placeholder="Subject/Course Title" value="">
                    <br>
                    <button class="cancel_button"><a href="index.php">Cancel</a></button>
                    <button type="submit" name="createClass_button" id="create_class_button">Create</button>
                    <br>
                    <br>
                    <a href="#" id="joinClass" class="joinClass">Want to join a Class? Click Here</a>
                </form>
            </div>
             
            <div id="second">
                <div class="joinClass_header">
                    <h1>Join class</h1>
                </div>
                <form action="createJoinClass.php" method="POST">
                    <input type="text" name="code" placeholder="Class code" autocomplete="off" value="<?php 
                        if(isset($_SESSION['code'])){
                            echo $_SESSION['code'];
                        } 
                    ?>">
                    <br>
                    <button class="cancel_button"><a href="index.php">Cancel</a></button>
                    <button type="submit" name="joinClass_button" id="join_class_button">Join</button>
                    <br>
                    <br>
                    <a href="#" id="createClass" class="createClass">Want to create a new Class? Click here!</a>
                </form>
            </div>
        </div>          
    </div>
</div>
               
</body>
</html>

<script>
    // jQuery script to show/hide sections
    $(document).ready(function(){
        $("#first").hide(); // Initially hide the create class section
        $("#second").show(); // Show the join class section

        // Toggle between Create Class and Join Class sections
        $("#createClass").click(function(){
            $("#first").toggle();
            $("#second").toggle();
        });
    });
</script>
