<?php
require 'config.php';
require 'loginhandler.php';
?>

<html>

<head>
<meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Welcome!</title>
    <link rel="stylesheet" type="text/css" href="login.css">
</head>
<body>
            <header>
                <a href="index.html"><img src="images/Port_City_International_University_Logo.png" alt="PCIU" style="width: 50px;"></a>
                <h2>Port City International University</h2>
            </header>
            <div id="first">
                <form class="login" action="login.php" method="POST" id="login-form">
                <input type="email" name="log_email" placeholder="Email address" value="" required>
                    <br>

                    <input type="password" name="log_password" placeholder="Password">
                    <br>
                    <?php $error_array = isset($error_array) ? $error_array : []; if (in_array("Email or password was incorrect<br>", $error_array)) echo "<span style='color:red; font-size:0.78rem;'>Email or password was incorrect<br><br></span>"; ?>
                  
                    <input type="submit" name="login_button" id="button" value="Login">
                    <a href="registration.php"><h3>Don't have an account? <span>Registration here!</span></h3></a>
                </form>
           </div>
</body>

</html>
