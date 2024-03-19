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
        $str = ""; 
        $data_query = mysqli_query($this->con, "SELECT * FROM createclass where username='$this->user' ORDER BY id DESC");

        if (mysqli_num_rows($data_query) > 0) {
            while ($row = mysqli_fetch_array($data_query)) {
                $id = $row['id'];
                $className = $row['className'];
                $section = $row['section'];
                $subject = $row['subject'];
                $code = $row['courseCode'];
                $added_by = $row['username'];
                if ($_SESSION['username']== $added_by) {
                    $delete_teachingClass = "<a href='delete.php?createClass_id=$id&courseCode=$code'><input type='button' id='delete_class_btn' value='Remove'style='background-color: #4CAF50; 
                    border: none;
                    color: white;
                    border-radius:3px;
                    padding: 5px 9px;
                    text-align: center;
                    text-decoration: none;
                    display: inline-block;
                    font-size: 16px;
                    margin-top:15px;
                    cursor: pointer;'></a>";
                } else {
                    $delete_teachingClass = "";
                }
    
                $str .= "<div class='classBox'>
                                    <a href = 'insideClassroom.php?classCode=$code'> <h3>$className </h3></a> 
                                    Section: $section
                                    <br>
                                    $subject
                                    <br>
                                    <p> $delete_teachingClass </p>
                            </div> ";
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
        $str = "";
        $data_query = mysqli_query($this->con, "SELECT * FROM createclass where student_array LIKE '%$this->user%' ORDER BY id DESC");

        if (mysqli_num_rows($data_query) > 0) {
            while ($row = mysqli_fetch_array($data_query)) {
                $className = $row['className'];
                $section = $row['section'];
                $subject = $row['subject'];
                $code = $row['courseCode'];
                $delete_EnrolledClass = "<a href='delete.php?Enrolled_Student=$this->user&amp;classCode=$code'><input type='button' id='delete_class_btn' value='Leave' style='background-color: #4CAF50; 
              border: none;
              color: white;
              border-radius:3px;
              padding: 5px 9px;
              text-align: center;
              text-decoration: none;
              display: inline-block;
              font-size: 16px;
              margin-top:15px;
              cursor: pointer;'></a>";
              $str .= "<div class='EnrolledclassBox'>
                           <a href = 'insideClassroom.php?classCode=$code'> <h3>$className </h3></a>
                           Section: $section
                           <br>
                           $subject
                           <br>
                           <p> $delete_EnrolledClass </p>
                           </a>
                    </div> ";
            }
            echo $str;
        }
    }
}
?>
