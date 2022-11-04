<?php
	require "database.php";
	require "nav.html";
	
	session_start();
    $user_id = $_SESSION['user'];

	$duser_id = isset($_GET["user_id"]) ? $_GET["user_id"] : null;

	$notme = FALSE;
	if($duser_id)
	{
		$notme = TRUE;
		$query = "SELECT * FROM tbusers WHERE user_id = '$duser_id'";
		$res= $mysqli->query($query);
		if($row = mysqli_fetch_array($res))
		{
			$name = $row['name'];
		}
	}
	else
	{
		$notme = FALSE;
	}
    

    
    ?>

<!DOCTYPE html>
<html>
<head>
	<title>EventScape Delete Profile</title>
	<meta charset="utf-8" />
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/css/bootstrap.min.css" integrity="sha384-KyZXEAg3QhqLMpG8r+8fhAXLRk2vvoC2f3B09zVXn8CA5QIVfZOJ3BCsw2P0p/We" crossorigin="anonymous">
	<link rel="stylesheet" type="text/css" href="style.css" />
	<meta charset="utf-8" />
	<meta name="author" content="Morgan Else">
	<script src="https://code.jquery.com/jquery-3.6.1.js" integrity="sha256-3zlB5s2uwoUzrXK3BT7AX3FyvojsraNFxCc2vC/7pNI=" crossorigin="anonymous"></script>
	<?php require "favicon.html"; ?>
</head>
<body>

	<div class="container">
		<?php 
			if($notme)
			{
				echo "<h2 class='display-6'>Are you sure you want to delete ". $name ."'s EventScape account?</h2>
				<p class='lead text-center'>you cannot undo this action</p>
				<p class='lead text-center'><a class='btn btn-success' href='home.php' role='button'>just kidding</a><a class='btn btn-danger' href='logout.php?user_id=".$duser_id."' role='button'>delete account</a> </p>";
			}
			else
			{
				echo "<h2 class='display-6'>Are you sure you want to delete your EventScape account?</h2>
				<p class='lead text-center'>you cannot undo this action</p>
				<p class='lead text-center'><a class='btn btn-success' href='home.php' role='button'>just kidding</a><a class='btn btn-danger' href='logout.php?user_id=".$user_id."' role='button'>delete account</a> </p>"; 
			}
		?>
		
    </div>
</body>
</html>