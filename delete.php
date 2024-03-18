<?php
include ("config.php");
if (isset($_GET['createClass_id'])) {
	$createClass_id = $_GET['createClass_id'];
	$courseCode = $_GET['courseCode'];
	$query = mysqli_query($con, "DELETE FROM createclass WHERE id='$createClass_id'");
	$query2 = mysqli_query($con, "DELETE FROM posts WHERE courseCode='$courseCode'");
	$query3 = mysqli_query($con, "DELETE FROM comments WHERE courseCode='$courseCode'");
	header("Location:home.php");
}

if (isset($_GET['Enrolled_Student'])) {
	$enrolled_Student = $_GET['Enrolled_Student'];
	$courseCode = $_GET['classCode'];
	$query = mysqli_query($con, "UPDATE createclass SET student_array = REPLACE(student_array, '$enrolled_Student', '') WHERE courseCode LIKE '$courseCode' AND student_array  LIKE '%$enrolled_Student%'");
	header("Location: home.php");
}