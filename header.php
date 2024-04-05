<?php 
require 'config.php' ;
   if(isset($_SESSION['username'])){
		 $userLoggedIn  = $_SESSION['username'];
		 $user_details_query = mysqli_query($con, "SELECT * FROM users WHERE username = '$userLoggedIn'");
		 $user = mysqli_fetch_array($user_details_query);

   }
   else{
   	header("Location:registration.php");
   }
 ?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">
	<title></title>
	  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css" integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">
		<link rel="stylesheet" type="text/css" href="header.css">
</head>

<body>
	<div class="top_bar">
		<div class="logo">
			<a href="home.php" style="text-decoration: none"><img src="images/Port_City_International_University_Logo.png" alt="" style="width: 50px;"></a>
		</div>
             <div class="icon">
				<nav>
					<a href="<?php echo $userLoggedIn; ?>" style="text-decoration: none">Welcome!
									<span class="name"><?php echo $user['first_name'] ?></span>
									<span class="tooltiptext">Profile</span>
					</a>
					<a href="createJoinClass.php"><i class="fas fa-chalkboard"></i>
							<span class="tooltiptext">Create or Join Class</span>
					</a>
					<a href="home.php">
						<i class="fas fa-home">
							<span class="tooltiptext">Home</span></i>
					</a>
					<a href="logout.php">
					<i class="fas fa-power-off"></i>
    				<span class="tooltiptext">Sign out</span>
					</a>
				</nav>			
			</div>		
		</div>
	</body>
</html>
