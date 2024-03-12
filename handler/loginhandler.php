<?php
// Initialize $error_array as an array
$error_array = array();

if (isset($_POST['login_button'])) {
    $email = filter_var($_POST['log_email'], FILTER_SANITIZE_EMAIL); // Sanitize email

    $_SESSION['log_email'] = $email; // Store email into session variable
    $password = md5($_POST['log_password']); // Get password

    $check_database_qurey = mysqli_query($con, "SELECT * FROM users WHERE email = '$email' AND password = '$password'");
    $check_login_query = mysqli_num_rows($check_database_qurey);

    if ($check_login_query == 1) {
        $row = mysqli_fetch_array($check_database_qurey);
        $username = $row['username'];

        $_SESSION['username'] = $username;
        header("Location: home.php");
        exit();
    } else {
        // Check if $error_array is an array before using array_push
        if (!is_array($error_array)) {
            // If $error_array is not an array, create a new array
            $error_array = array();
        }
        array_push($error_array, "Email or password was incorrect<br>");
    }
}
?>
