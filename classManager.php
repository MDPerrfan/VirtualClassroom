<?php
class ClassManager
{
    private $con;
    private $user;

    public function __construct($con, $user)
    {
        $this->con = $con;
        $this->user = $user;
    }

    public function checkTeachingClass()
    {
        $checkTeaching = false;
        $data_query = mysqli_query($this->con, "SELECT * FROM createclass where username='$this->user' ORDER BY id DESC");
        if (mysqli_num_rows($data_query) > 0) {
            $checkTeaching = true;
        }
        return $checkTeaching;
    }

    public function loadTeachingClasses()
    {
        $this->checkTeaching = true;
        $str = ""; //String to return 
        $data_query = mysqli_query($this->con, "SELECT * FROM createclass where username='$this->user' ORDER BY id DESC");

        if (mysqli_num_rows($data_query) > 0) {
            while ($row = mysqli_fetch_array($data_query)) {
                $id = $row['id'];
                $className = $row['className'];
                $section = $row['section'];
                $subject = $row['subject'];
                $code = $row['courseCode'];
                $added_by = $row['username'];
                $str .= "<div class='classBox'>
                            <a href='classRoom.php?classCode=$code'><h3>$className</h3></a>
                            Section: $section<br>
                            $subject<br>
                        </div>";
            }
            echo $str;
        }
    }

    public function checkEnrolledClass()
    {
        $checkEnrolled = false;
        $data_query = mysqli_query($this->con, "SELECT * FROM createclass where student_array LIKE '%$this->user%' ORDER BY id DESC");
        if (mysqli_num_rows($data_query) > 0) {
            $checkEnrolled = true;
        }
        return $checkEnrolled;
    }

    public function loadEnrolledClasses()
    {
        $str = ""; //String to return 
        $data_query = mysqli_query($this->con, "SELECT * FROM createclass where student_array LIKE '%$this->user%' ORDER BY id DESC");

        if (mysqli_num_rows($data_query) > 0) {
            while ($row = mysqli_fetch_array($data_query)) {
                $className = $row['className'];
                $section = $row['section'];
                $subject = $row['subject'];
                $code = $row['courseCode'];

                $str .= "<div class='EnrolledclassBox'>
                            <a href='classRoom.php?classCode=$code'><h3>$className</h3></a>
                            Section: $section<br>
                            $subject<br>
                        </div>";
            }
            echo $str;
        }
    }
}
?>
