<?php
	require "database.php";
    session_start();

    $user_id = $_SESSION["user"];
	$query = "SELECT * FROM tbusers WHERE user_id = '$user_id'";
	$user = $mysqli->query($query);
    if($row = mysqli_fetch_array($user))
		{
			$name = $row['name'];
		}

        

        
?>

<!DOCTYPE html>
<html>
<head>
	<title>EventScape - Logged Out</title>
	<link rel="stylesheet" type="text/css" href="style.css" />
	<meta charset="utf-8" />
	<meta name="author" content="Morgan Else">	
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.2/css/bootstrap.min.css" integrity="sha384-Smlep5jCw/wG7hdkwQ/Z5nLIefveQRIY9nfy6xoR1uRYBtpZgI6339F5dgvm/e9B" crossorigin="anonymous">	
    <?php require "favicon.html"; ?>
</head>
<body>
	<div class="container">
        <div class="logout">
        <?php
            echo 	"<h2 class='display-2' style='text-align:center'>You're Logged out of EventScape!</h2>
        
            <p class='lead text-center'>Didn't mean to log out? Log back in <a href='index.html' class='badge badge-light'>here</a> </p>";
        ?>
        </div>
    </div>
</body>
</html>

<?php session_destroy(); ?>