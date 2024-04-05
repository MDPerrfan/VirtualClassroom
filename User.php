<?php
class User {
    private $user;
    private $user2;
    private $con;

    public function __construct($con, $code, $user){
        $this->con = $con;
        $this->user = $user;
        $user_details_query = mysqli_query($con, "SELECT * FROM users WHERE username='$user'");
        $this->user = mysqli_fetch_array($user_details_query);
        $user2_details_query = mysqli_query($con, "SELECT * FROM createclass WHERE courseCode='$code'");
        $this->code = mysqli_fetch_array($user2_details_query);
        $user2_details_query = mysqli_query($con, "SELECT * FROM createclass WHERE username='$user'");
        $this->user2 = mysqli_fetch_array($user2_details_query);
    }

    public function getUsername() {
        return $this->user['username'];
    }

    public function getCourseCode() {
        return $this->code['courseCode'];
    }
    public function getFirstAndLastName() {
        $username = $this->user['username'];
        $query = mysqli_query($this->con, "SELECT first_name, last_name FROM users WHERE username='$username'");
        $row = mysqli_fetch_array($query);
        return $row['first_name'] . " " . $row['last_name'];
    }
    public function isStudent($username_to_check) {
        if(isset($this->user2) && isset($this->user2['student_array']) && $this->user2['student_array'] !== null) {
            $usernameComma = "," . $username_to_check . ",";
            if(strstr($this->user2['student_array'], $usernameComma) || $username_to_check == $this->user2['username']) {
                return true;
            }
        }
    
        if(isset($this->code) && isset($this->code['student_array']) && $this->code['student_array'] !== null) {
            $usernameComma = "," . $username_to_check . ",";
            if(strstr($this->code['student_array'], $usernameComma)) {
                return true;
            }
        }
    
        return false; 
    }
    
}
?>
