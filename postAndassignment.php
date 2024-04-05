<?php

class Post
{
    private $user;
    private $user_obj;
    private $con;
    private $code;
    public $fileDestination;

    public function __construct($con, $user, $code)
    {
        $this->con = $con;
        $this->user = $user;
        $this->code = $code;
        $this->user_obj = new User($con, $code, $user);
    }

    public function submitPost($body, $fileName, $fileDestination, $user_to)
    {
        $body = strip_tags($body);
        $body = mysqli_real_escape_string($this->con, $body);
        $check_empty = preg_replace('/\s+/', '', $body);

        if ($check_empty != "" && $fileName == "") {
           
            $date_added = date("Y-m-d H:i:s");
         
            $added_by = $this->user_obj->getUsername();
            
            if ($added_by == $user_to) {
                $user_to = 'none';
            }

            $query = mysqli_query($this->con, "INSERT INTO posts VALUES('', '$check_empty', '$added_by','$this->code', '$user_to', '$date_added','','')");
        }

        if ($fileName != "") { 
            $date_added = date("Y-m-d H:i:s");
            $added_by = $this->user_obj->getUsername();
            if ($added_by == $user_to) {
                $user_to = 'none';
            }
            $course_code = $this->user_obj->getCourseCode();

            $query = mysqli_query($this->con, "INSERT INTO posts VALUES('', '$body', '$added_by','$this->code', '$user_to', '$date_added', '$fileName','$fileDestination',NULL)");
        }
    }

    public function loadPosts()
    {
    
        $userLoggedIn = $this->user_obj->getUsername();
    
        $str = "";
        $data_query = mysqli_query($this->con, "SELECT * FROM posts WHERE courseCode='$this->code' AND files ='none' ORDER BY id DESC");
    
        if (mysqli_num_rows($data_query) > 0) {
    
            while ($row = mysqli_fetch_array($data_query)) {
                $id = $row['id'];
                $body = $row['body'];
                $added_by = $row['added_by'];
                $date_time = $row['date_added'];
    
                if ($row['user_to'] == "none") {
                    $user_to = "";
                } else {
                    $user_to_obj = new User($this->con, $this->code, $row['user_to']);
                    $user_to_name = $user_to_obj->getFirstAndLastName();
                    $user_to = "to <a href='" . $row['user_to'] . "'>" . $user_to_name . "</a>";
                }
                					
					if ($userLoggedIn == $added_by) {
						$deletePost_button = "<a  href='delete.php?post_id=$id&amp;classCode=$this->code'><input style='background:red;color:white;cursor:pointer;border:none;border-radius:2px;padding:3px;' id='delete_post_btn' type='button' value='Delete'></a>";
					} else {
						$deletePost_button = "";
					}
                $user_logged_obj = new User($this->con, $this->code, $userLoggedIn);
                if ($user_logged_obj->getUsername($added_by)) {
    
                    $user_details_query = mysqli_query($this->con, "SELECT first_name, last_name FROM users WHERE username='$added_by'");
                    $user_row = mysqli_fetch_array($user_details_query);
                    $first_name = $user_row['first_name'];
                    $last_name = $user_row['last_name'];
                   
    
                    ?>
                    <script>
                        function toggle<?php echo $id; ?>() {
                            var element = document.getElementById("toggleComment<?php echo $id; ?>");
    
                            if (element.style.display == "block")
                                element.style.display = "none";
                            else
                                element.style.display = "block";
                        }
                    </script>
                    <?php
    
                    $comments_check = mysqli_query($this->con, "SELECT * FROM comments WHERE post_id='$id'");
                    $comments_check_num = mysqli_num_rows($comments_check);
    
                    // Timeframe
                    $date_time_now = date("Y-m-d H:i:s");
                    $start_date = new DateTime($date_time); 
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
    
                   
    
                    $str .= "<div class='status_post' style='font-size:1.3rem;'>
                             
                                <div class='posted_by' style='color:gray;'>
                                    <a style='text-decoration:none;color:#2c2c2c;font-size:1.3rem;' href='$added_by'> $first_name $last_name </a> &nbsp;&nbsp;<span style='font-size: 14px; '>$time_message </span>
                                </div>
                                <div id='post_body'>
                                    <p>$body $deletePost_button</p>
                                    
                                </div>
                                <div class='commentOption' onClick='javascript:toggle$id()'> 
                                    Comments($comments_check_num)<span class='edited-det'> </span> 
                                </div>
                            </div>
                            <div class='post_comment' id='toggleComment$id' style='display:none;'>
                                <iframe src='comment.php?post_id=$id' id='comment_iframe' frameborder='0'></iframe>
                            </div>
                            <hr>";
                }
            }
            echo $str;
        }
    }
    
    public function loadFiles()
    {
        $userLoggedIn = $this->user_obj->getUsername();
        $str = ""; 
    
        $data_query = mysqli_query($this->con, "SELECT * FROM posts WHERE courseCode='$this->code' AND files != 'none' ORDER BY id DESC");
    
        if (mysqli_num_rows($data_query) > 0) {
            while ($row = mysqli_fetch_array($data_query)) {
                $id = $row['id'];
                $body = $row['body'];
                $added_by = $row['added_by'];
                $date_time = $row['date_added'];
                $file = $row['files'];
                $path = $row['fileDestination'];
                $marks = $row['marks']; 
                
                $str .= "<div class='file'>";
                $str .= "<a style='text-decoration:none;color:maroon;font-size:1.4rem;' href='download.php?file=$path' download='$path'>$path</a>";
                $str .= "<p>$body</p>";
                if ($marks !== null) {
                    $str .= "<p style='color:maroon;font-weight:700;'>Marks: $marks</p>";
                } else {
                    
                    $str .= "<form method='POST'>";
                    $str .= "<input type='hidden' name='post_id' value='$id'>";
                    $str .= "<input style='font-size:1.2rem;border-radius:3px;border:none;margin:3px;' type='number' name='marks' placeholder='Enter marks'>";
                    $str .= "<input style='font-size:1.2rem;border-radius:3px;border:none;margin:3px;cursor:pointer;' type='submit' name='mark' value='Mark Assignment'>";
                    $str .= "</form>";
                }
                $str .= "<hr>";
                $str .= "</div>";
            }
        } else {
            $str = "<p>No files found.</p>";
        }
    
        echo $str;
    }
    
    
    public function markAssignment($postId, $marks)
    {
        
        $postId = mysqli_real_escape_string($this->con, $postId);
        $marks = mysqli_real_escape_string($this->con, $marks);
    
        $query = "UPDATE posts SET marks = '$marks' WHERE id = '$postId'";
        $result = mysqli_query($this->con, $query);
    }
        
public function loadFiles1()
{
$userLoggedIn = $this->user_obj->getUsername();
$str = ""; 

$data_query = mysqli_query($this->con, "SELECT * FROM posts WHERE courseCode='$this->code' AND files != 'none' ORDER BY id DESC");

if (mysqli_num_rows($data_query) > 0) {
    while ($row = mysqli_fetch_array($data_query)) {
        $id = $row['id'];
        $body = $row['body'];
        $added_by = $row['added_by'];
        $date_time = $row['date_added'];
        $file = $row['files'];
        $path = $row['fileDestination'];
        $marks = $row['marks'];
      
        $str .= "<div class='file'>";
        $str .= "<h3>$path</h3>";
        $str .= "<p>$body</p>";
        if ($marks !==Null) {
            $str .= "<p style='color:maroon;font-weight:700;'>Marks: $marks</p>";
        }
        else{
            $str.="<p style='color:maroon;font-weight:700;'>Assignment has not been marked!</p>";

        }
        $str .= "</div>";         
}
echo $str;
} 

}
}
?>

