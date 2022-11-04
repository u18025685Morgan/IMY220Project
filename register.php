<?php
	require "database.php";
	session_start();

	$name = isset($_POST["fname"])? $_POST["fname"] : null;
	$surname = isset($_POST["lname"])? $_POST["lname"] : null;
	$email = isset($_POST["email"])? $_POST["email"] : null;
	$date = isset($_POST["date"])? $_POST["date"] : null;
	$pass = isset($_POST["pass"])? $_POST["pass"] : null;

	$query = "INSERT INTO tbusers (name, surname, email, birthday, password, user_type) VALUES ('$name', '$surname', '$email', '$date', '$pass', 'normie');";


	$res = mysqli_query($mysqli, $query) == TRUE;
	$query = "SELECT user_id FROM tbusers WHERE email = '$email' AND password = '$pass'";
		$user = $mysqli->query($query);
		if($row = mysqli_fetch_array($user))
		{
			$user_id = $row['user_id'];
		}

		$_SESSION["user"] = $user_id;
		$_SESSION["user_type"] = "normie";
?>

<!DOCTYPE html>
<html>
<head>
	<title>EventScape - Registration</title>
	<link rel="stylesheet" type="text/css" href="style.css" />
	<meta charset="utf-8" />
	<meta name="author" content="Morgan Else">	
	<?php require "favicon.html"; ?>
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.2/css/bootstrap.min.css" integrity="sha384-Smlep5jCw/wG7hdkwQ/Z5nLIefveQRIY9nfy6xoR1uRYBtpZgI6339F5dgvm/e9B" crossorigin="anonymous">	
</head>
<body id="index">
	<div class="container">
		<div class="logout">
		<?php 
			if($res)
				echo 	"<h2 class='display-2' style='text-align:center'>Your account has been created!</h2>
        
					  <p class='lead text-center'>Let's go to your <a href='home.php' class='badge badge-light'>home page</a> </p>";
  			else
  				echo '<div class="alert alert-danger mt-3" role="alert">
  						The account could not be created! <a href="index.html" class="alert-link">Eish, go back babe...</a>
  					</div>';
		?>
		</div>
	</div>
</body>
</html>
