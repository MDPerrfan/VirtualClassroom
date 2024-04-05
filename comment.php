<html>

<head>
    <title></title>
	<style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
			
        }

        .comment_wrapper {
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
            background-color: #42b883;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
			
        }
		body::-webkit-scrollbar {
    width: 10px;
}
        .comment_section {
            margin-bottom: 20px;
        }

        .comment_section a {
            text-decoration: none;
            color: #333;
        }

        .comment_section a:hover {
            text-decoration: underline;
        }

        .comment_section hr {
            border: none;
            border-top: 1px solid #ccc;
            margin-top: 5px;
            margin-bottom: 10px;
        }

        #comment_form {
            margin-bottom: 20px;
        }

        #comment_form input[type="text"] {
            width: calc(100% - 80px);
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px 0 0 5px;
            margin-right: 5px;
        }

        #comment_form input[type="submit"] {
            padding: 10px 20px;
            border: none;
            border-radius: 0 5px 5px 0;
            background-color: #007bff;
            color: #fff;
            cursor: pointer;
        }

        #comment_form input[type="submit"]:hover {
            background-color: #0056b3;
        }

        #delete_comment_btn {
            background-color: #dc3545;
            color: #fff;
            border: none;
            padding: 5px 10px;
            border-radius: 3px;
            cursor: pointer;
            text-decoration: none;
        }

        #delete_comment_btn:hover {
            background-color: #c82333;
        }
    </style>
</head>

<body>
    <div class="comment_wrapper">

        <?php 
		require 'config.php';
		include("User.php");
		include("postAndassignment.php");


		$userLoggedIn = "";
		if (isset($_SESSION['username'])) {
			$userLoggedIn = $_SESSION['username'];
			$user_details_query = mysqli_query($con, "SELECT * FROM users WHERE username='$userLoggedIn'");
			$user = mysqli_fetch_array($user_details_query);
		}

		?>
        <script>
            function toggle() {
                var element = document.getElementById("comment_section");

                if (element.style.display == "block")
                    element.style.display = "none";
                else
                    element.style.display = "block";
            }
        </script>

        <?php 

		if (isset($_GET['post_id'])) {
			$post_id = $_GET['post_id'];
		}

		$user_query = mysqli_query($con, "SELECT added_by, courseCode, user_to FROM posts WHERE id='$post_id'");
		$row = mysqli_fetch_array($user_query);

		$posted_to = isset($row['added_by']) ? $row['added_by'] : '';
		$courseCode = isset($row['courseCode']) ? $row['courseCode'] : '';
		$user_to = isset($row['user_to']) ? $row['user_to'] : '';
		

		if (isset($_POST['postComment' . $post_id])) {
			$post_body = $_POST['post_body'];
			$post_body = mysqli_escape_string($con, $post_body);
			$date_time_now = date("Y-m-d H:i:s");
			$insert_post = mysqli_query($con, "INSERT INTO comments VALUES ('', '$post_body','$courseCode', '$userLoggedIn', '$posted_to', '$date_time_now', 'no', '$post_id')");
			
	
			
			echo "<p style='text-align: center; margin: 0 0 0.5rem 0;'>Comment Posted! </p>";
		}
		?>

        <form action="comment.php?post_id=<?php echo $post_id; ?>" id="comment_form" name="postComment<?php echo $post_id; ?>" method="POST" autocomplete="off">
            <input type="text" name="post_body" placeholder="Add a comment">
            <input type="submit" name="postComment<?php echo $post_id; ?>" value="Post">

        </form>
        <?php 
		$get_comments = mysqli_query($con, "SELECT * FROM comments WHERE post_id='$post_id' ORDER BY id DESC");
		$count = mysqli_num_rows($get_comments);

		if ($count != 0) {

			while ($comment = mysqli_fetch_array($get_comments)) {
				$id = $comment['id'];
				$courseCode = $comment['courseCode'];
				$comment_body = $comment['post_body'];
				$posted_to = $comment['posted_to'];
				$posted_by = $comment['posted_by'];
				$date_added = $comment['date_added'];
				$removed = $comment['removed'];
				$post_id = $comment['post_id'];

				if ($userLoggedIn == $posted_by) {
					$deleteComment_button = "<a href='delete.php?comment_id=$id&amp;post_id=$post_id'><input id='delete_comment_btn' type='button' value='Delete'></a>";
				} else {
					$deleteComment_button = "";
				}

				//Timeframe
				$date_time_now = date("Y-m-d H:i:s");
				$start_date = new DateTime($date_added);
				$end_date = new DateTime($date_time_now); 
				$interval = $start_date->diff($end_date);  
				if ($interval->y >= 1) {
					if ($interval == 1)
						$time_message = $interval->y . " year ago"; 
					else
						$time_message = $interval->y . " years ago"; 
				} else if ($interval->m >= 1) {
					if ($interval->d == 0) {
						$days = " ago";
					} else if ($interval->d == 1) {
						$days = $interval->d . " day ago";
					} else {
						$days = $interval->d . " days ago";
					}


					if ($interval->m == 1) {
						$time_message = $interval->m . " month" . $days;
					} else {
						$time_message = $interval->m . " months" . $days;
					}
				} else if ($interval->d >= 1) {
					if ($interval->d == 1) {
						$time_message = "Yesterday";
					} else {
						$time_message = $interval->d . " days ago";
					}
				} else if ($interval->h >= 1) {
					if ($interval->h == 1) {
						$time_message = $interval->h . " hour ago";
					} else {
						$time_message = $interval->h . " hours ago";
					}
				} else if ($interval->i >= 1) {
					if ($interval->i == 1) {
						$time_message = $interval->i . " minute ago";
					} else {
						$time_message = $interval->i . " minutes ago";
					}
				} else {
					if ($interval->s < 30) {
						$time_message = "Just now";
					} else {
						$time_message = $interval->s . " seconds ago";
					}
				}

				$user_obj = new User($con,$courseCode, $posted_by);


				?>
        <div class="comment_section">
            <a href="<?php echo $posted_by ?>" target="_parent"> <b> <?php echo $user_obj->getFirstAndLastName(); ?> </b></a>
            &nbsp;&nbsp;<?php echo "<span style='font-size: 11px;'>$time_message </span>" .  $deleteComment_button   . "<br>" . "<p >$comment_body<p>"; ?>

            <hr>
        </div>
        <?php

	}
} else {
	echo "<p style='text-align: center; margin-bottom:4rem;'>No Comments to Show!</p>";
}

?>
    </div>
</body>

</html> 