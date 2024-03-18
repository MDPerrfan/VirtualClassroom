<?php 
require 'config.php';
require 'registerhandler.php';
?>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Regsitration</title>
    <link rel="stylesheet" type="text/css" href="registerstyle.css">
</head>

<body>
        <header>
            <a href="index.html"><img src="images/Port_City_International_University_Logo.png" alt="PCIU" style="width: 50px;"></a>
            <h2>Port City International University</h2>
        </header>
 <form action="registration.php" method="POST" id="register-form">
 <div class="wrapper">
    <h2>Registration</h2>
        <div class="input-box">
            <input type="text" name="reg_fname" placeholder="First name" value="<?php if (isset($_SESSION['reg_fname'])) echo $_SESSION['reg_fname']; ?>" required>
        </div>
        <br>

        <div class="input-box">
            <input type="text" name="reg_lname" placeholder="Last name" value="<?php if (isset($_SESSION['reg_lname'])) echo $_SESSION['reg_lname']; ?>" required>
        </div>
        <br>

        <div class="input-box">
            <input type="email" name="reg_email" placeholder="Email" value="<?php if (isset($_SESSION['reg_email'])) echo $_SESSION['reg_email']; ?>" required>
        </div>
        <br>
        <div class="input-box">
            <input type="email" name="reg_email2" placeholder="Confirm email" value="<?php if (isset($_SESSION['reg_email2'])) echo $_SESSION['reg_email2']; ?>" required>
        </div>
        <br>

        <?php if (in_array("Email already in use<br>", $error_array)) echo "Email already in use<br>";
        else if (in_array("Invalid email format<br>", $error_array)) echo "Invalid email format<br>";
        else if (in_array("Email do not match<br>", $error_array)) echo "Email do not match<br>"; ?>

        <div class="input-box">
            <input type="password" name="reg_password" placeholder="Password" required>
        </div>
        <br>

        <div class="input-box">
            <input type="password" name="reg_password2" placeholder="Confirm password" required>
        </div>
        <br>

        <?php if (in_array("Your password do not match<br>", $error_array)) echo "Your password do not match<br>"; ?>

        <div class="input-box button">
            <input type="submit" name="register_button" id="button" value="Register Now">
        </div>

        <div class="text">
            <h3>Already have an account? <a href="login.php">Login now</a></h3>
        </div>
    </form>
</div>
</body>
</html>
