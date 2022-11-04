<?php
	require "database.php";
    session_start();

    $user_id = $_SESSION["user"];

	$duser_id = isset($_GET["user_id"]) ? $_GET["user_id"] : null;

	if($duser_id)
	{
		require "nav.html";
		$bail = "DELETE FROM tbusers WHERE user_id = '$duser_id'";
		$bailed = mysqli_query($mysqli, $bail) == TRUE;

		$bail = "DELETE FROM tbusergallery WHERE user_id = '$duser_id'";
		$bailed = mysqli_query($mysqli, $bail) == TRUE;

		$query = "SELECT * FROM tbreviews WHERE user_id = '$duser_id'";
		$user = $mysqli->query($query);
		while($row = mysqli_fetch_array($user))
		{
			$bail = "DELETE FROM tbreviewgallery WHERE review_id = '$row[review_id]'";
			$bailed = mysqli_query($mysqli, $bail) == TRUE;
		}

		$bail = "DELETE FROM tbreviews WHERE user_id = '$duser_id'";
		$bailed = mysqli_query($mysqli, $bail) == TRUE;
		
		$query = "SELECT * FROM tbconvos WHERE friend1_id = '$duser_id' OR friend2_id = '$duser_id'";
		$convos = $mysqli->query($query);
		while($row = mysqli_fetch_array($convos))
		{
			$bail = "DELETE FROM tbmessages WHERE convo_id = '$row[convo_id]'";
			$bailed = mysqli_query($mysqli, $bail) == TRUE;
		}

		$bail = "DELETE FROM tbconvos WHERE friend1_id = '$duser_id' OR friend2_id = '$duser_id'";
		$bailed = mysqli_query($mysqli, $bail) == TRUE;

		$query = "SELECT * FROM tblists WHERE user_id = '$duser_id'";
		$lists = $mysqli->query($query);
		while($row = mysqli_fetch_array($lists))
		{
			$bail = "DELETE FROM tblistevents WHERE list_id = '$row[list_id]'";
			$bailed = mysqli_query($mysqli, $bail) == TRUE;
		}

		$bail = "DELETE FROM tblists WHERE user_id = '$duser_id'";
		$bailed = mysqli_query($mysqli, $bail) == TRUE;

		$bail = "DELETE FROM tbfriends WHERE friend1_id = '$duser_id' OR friend2_id = '$duser_id'";
		$bailed = mysqli_query($mysqli, $bail) == TRUE;

		$query = "SELECT * FROM tbevents WHERE user_id = '$duser_id'";
		$events = $mysqli->query($query);
		$deleteEvent = TRUE;
		while($row = mysqli_fetch_array($events))
		{
			$query1 = "SELECT * FROM tbreviews WHERE event_id = '$row[event_id]'";
			$reviews = $mysqli->query($query1);
			if($row = mysqli_fetch_array($reviews))
			{
				$updateQuery = "UPDATE tbevents SET status = 'deleted' WHERE event_id = '$row[event_id]'";
    			$updateResult= $mysqli->query($updateQuery) == TRUE;
				$deleteEvent = false;
			}
			$bail = "DELETE FROM tbgallery WHERE event_id = '$row[event_id]'";
			$bailed = mysqli_query($mysqli, $bail) == TRUE;
		}

		if($deleteEvent)
		{
			$bail = "DELETE FROM tbevents WHERE user_id = '$duser_id'";
			$bailed = mysqli_query($mysqli, $bail) == TRUE;
		}
		

		echo "<div class='alert alert-success ' role='alert'>
                                    Profile Deleted Successfully
                                    
                                </div>";
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
		if($duser_id)
		{
			echo "<p class='lead text-center'>You did it! Go back home <a id='nicelink' href='home.php' class='badge badge-light'>here</a> </p>";
		}
		else
		{
			echo 	"<h2 class='display-2' style='text-align:center'>You're Logged out of EventScape!</h2>
        
            <p class='lead text-center'>Didn't mean to log out? Log back in <a id='nicelink' href='index.html' class='badge badge-light'>here</a> </p>";
			session_destroy();
		}
            
        ?>
        </div>
    </div>
</body>
</html>

