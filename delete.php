<?php
include ("config.php");
if (isset($_GET['post_id'])) {
	$post_id = $_GET['post_id'];
	$courseCode = $_GET['classCode'];

	$query = mysqli_query($con, "DELETE FROM posts WHERE id='$post_id'");
	header("Location: insideClassroom.php?classCode=$courseCode");
}
if(isset($_GET['comment_id'])){
	$id = $_GET['comment_id'];
	$post_id = $_GET['post_id'];
	$courseCode = $_GET['classCode'];
	$query = mysqli_query($con, "DELETE FROM comments WHERE id='$id'");
	header("Location: comment.php?post_id=$post_id");
  }


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
    $delete_query = "DELETE FROM joinclass WHERE class_id_fk = (SELECT id FROM createclass WHERE courseCode = '$courseCode')";
    mysqli_query($con, $delete_query);
    $update_query = "UPDATE createclass SET student_array = REPLACE(student_array, '$enrolled_Student', '') WHERE courseCode LIKE '$courseCode' AND student_array  LIKE '%$enrolled_Student%'";
    mysqli_query($con, $update_query);

    header("Location: home.php");
}
?>