<?php 
include("header.php");
require 'config.php' ;
require 'createJoinClasshandler.php';
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

<div id="first" class="subscribe-box">
    <div class="creatClass_header">
        <h1>Create Class</h1>
    </div>
    <form class="subscribe" action="createJoinClass.php" method="POST">
        <div class="form-input-material">
            <input type="text" name="className" autocomplete="off" placeholder="Class Name/Course Code"  value="">
            <label for="className"></label>
        </div>
        <div class="form-input-material">
            <input type="text" name="section" autocomplete="off" placeholder="Section"  value="">
            <label for="section"></label>
        </div>
        <div class="form-input-material">
            <input type="text" name="subject" autocomplete="off" placeholder="Subject/Course Title" value="">
            <label for="subject"></label>
        </div>
        <button type="submit" name="createClass_button" id="create_class_button" class="subscribe-button btn btn-primary btn-ghost">Create</button>
        <br>
        <br>
        <a href="#" id="joinClass" class="joinClass">Want to join a Class? Click Here</a>
    </form>
</div>



<div id="second" class="subscribe-box">
    <div class="joinClass_header">
        <h1>Join class</h1>
    </div>
    <form class="subscribe" action="createJoinClass.php" method="POST">
         <input type="text" name="code" placeholder="Class code" autocomplete="off" value="<?php 
                                                         if(isset($_SESSION['code'])){
                                                         echo $_SESSION['code'];
                                                                                } 
                                                                            ?>">
         <br>
         <button type="submit" name="joinClass_button" id="join_class_button" class="subscribe-button">Join</button>
         <br>
        <br>
        <a href="#" id="createClass" class="createClass">Want to create a new Class? Click here!</a>
    </form>
</div>

</body>

</html>

<script>
    $(document).ready(function() {
        $("#first").hide();
        $("#second").show(); 
        $("#createClass").click(function() {
            $("#first").toggle();
            $("#second").toggle();
        });
        $("#joinClass").click(function() {
            $("#first").toggle();
            $("#second").toggle();
        });
    });
</script>