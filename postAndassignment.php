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
        $body = strip_tags($body); //removes html tags 
        $body = mysqli_real_escape_string($this->con, $body);
        $check_empty = preg_replace('/\s+/', '', $body); //Deletes all spaces 

        if ($check_empty != "" && $fileName == "") {
            // Current date and time
            $date_added = date("Y-m-d H:i:s");
            // Get username
            $added_by = $this->user_obj->getUsername();
            
            // If user is on own class room, user_to is 'none'
            if ($added_by == $user_to) {
                $user_to = 'none';
            }

            // Insert post 
            $query = mysqli_query($this->con, "INSERT INTO posts VALUES('', '$check_empty', '$added_by','$this->code', '$user_to', '$date_added','','')");
        }

        if ($fileName != "") {  //only assignment
            // Current date and time
            $date_added = date("Y-m-d H:i:s");
            // Get username
            $added_by = $this->user_obj->getUsername();
            // If user is on own class room, user_to is 'none'
            if ($added_by == $user_to) {
                $user_to = 'none';
            }

            // Get course Code
            $course_code = $this->user_obj->getCourseCode();
            // Insert post
            $query = mysqli_query($this->con, "INSERT INTO posts VALUES('', '$body', '$added_by','$this->code', '$user_to', '$date_added', '$fileName','$fileDestination')");
        }
    }

    public function loadPosts()
    {
        $userLoggedIn = $this->user_obj->getUsername();
        $str = ""; // String to return 
        $data_query = mysqli_query($this->con, "SELECT * FROM posts WHERE courseCode='$this->code' AND files ='none' ORDER BY id DESC");
    
        if (mysqli_num_rows($data_query) > 0) {
            while ($row = mysqli_fetch_array($data_query)) {
                $post_body = $row['body']; // Assuming 'body' is the column name for post text in your database
                $added_by = $row['added_by']; // Assuming 'added_by' is the column name for the user who added the post
                $date_added = $row['date_added']; // Assuming 'date_added' is the column name for the date the post was added
                
                // Construct the HTML for the post
                $str .= "<div class='post'>";
                $str .= "<p><strong>$added_by</strong> - $date_added</p>";
                $str .= "<p>$post_body</p>";
                $str .= "</div>";
            }
        }
        echo $str;
    }
        public function loadFiles()
        {
        $userLoggedIn = $this->user_obj->getUsername();
        $str = ""; // String to return
        $data_query = mysqli_query($this->con, "SELECT * FROM posts WHERE courseCode='$this->code' AND files != 'none' ORDER BY id DESC");
    
        if (mysqli_num_rows($data_query) > 0) {
            while ($row = mysqli_fetch_array($data_query)) {
                $id = $row['id'];
                $body = $row['body'];
                $added_by = $row['added_by'];
                $date_time = $row['date_added'];
                $file = $row['files'];
                $path = $row['fileDestination'];
    
                // Add the HTML for displaying the file
                $str .= "<div class='file'>";
                $str .= "<a href='download.php?file=$path' download='$path'>$path</a>";
                $str .= "</div>";
            }
        }
        echo $str;
    } 

    
}
?>
