<?php
	require "database.php";
	require "nav.html";
	
	session_start();
	if(isset($_SESSION["user"]))
	{
		$user_id = $_SESSION["user"];
		$query = "SELECT * FROM tbusers WHERE user_id = '$user_id'";
		$user = $mysqli->query($query);
		if($row = mysqli_fetch_array($user))
		{
			$email = $row['email'];
			$pass = $row['password'];
		}
	}
	else{
		
		$email = isset($_POST["email"]) ? $_POST["email"] : null;
		$pass = isset($_POST["pass"]) ? $_POST["pass"] : null;
		// If email and/or pass POST values are set, set the variables to those values, otherwise make them false

		$query = "SELECT user_id FROM tbusers WHERE email = '$email' AND password = '$pass'";
		$user = $mysqli->query($query);
		if($row = mysqli_fetch_array($user))
		{
			$user_id = $row['user_id'];
			$_SESSION["user"] = $user_id;
		}

		
	}
	
	
	$eventName = isset($_POST["eventName"]) ? $_POST["eventName"] : null;
	$eventDescription = isset($_POST["eventDescription"]) ? $_POST["eventDescription"] : null;
	$eventDate = isset($_POST["eventDate"]) ? $_POST["eventDate"] : null;
	$picToUpload = isset($_FILES["picToUpload"]) ? $_FILES["picToUpload"] : null;
	$eventLocation = isset($_POST["eventLocation"]) ? $_POST["eventLocation"] : null;
	$eventHashtags = isset($_POST["eventHashtags"]) ? $_POST["eventHashtags"] : null;
	$eventCategory = isset($_POST["eventCategory"]) ? $_POST["eventCategory"] : null;

	if($eventDate !== null && $eventDescription !== null && $eventDate !== null & $picToUpload !== null)
	{
		$target_dir = "gallery/";
		$target_file = $target_dir . basename($_FILES["picToUpload"]["name"]);
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

		$allowed = array('jpeg', 'pjpeg', 'jpg');
		$filename = $_FILES["picToUpload"]["name"];

		if(in_array($imageFileType, $allowed) && $picToUpload["size"] < 1048576 ){ 
            if($picToUpload["error"] > 0 ){
                echo "Error: " . $picToUpload["error"] . "<br/>";
            }
            else
            {
                if(file_exists("gallery/" . $picToUpload["name"])){
					// $query = "SELECT event_id FROM tbevents WHERE user_id = '$user_id'";
					// $event_id = $mysqli->query($query);
				}else{
					move_uploaded_file($picToUpload["tmp_name"], "gallery/" . $picToUpload["name"]);
					$query = "INSERT INTO tbevents (user_id, name, description, date, location, hashtags, category) VALUES ('$user_id', '$eventName', '$eventDescription', '$eventDate', '$eventLocation', '$eventHashtags', '$eventCategory');";
					$res = mysqli_query($mysqli, $query) == TRUE;

					$query = "SELECT event_id FROM tbevents WHERE name = '$eventName'";
					$event = $mysqli->query($query);
					if($row = mysqli_fetch_array($event))
					{
						$event_id = $row['event_id'];
					}

					$query = "INSERT INTO tbgallery (event_id, image_name) VALUES ('$event_id', '$filename');";
					$res = mysqli_query($mysqli, $query) == TRUE;

				}
            }

        }else{
            echo "<div class='alert alert-danger mt-3' role='alert'> Invalid file </div>";
        }
	}

?>

<!DOCTYPE html>
<html>
<head>
	<title>EventScape Home</title>
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
			
			$query = "SELECT * FROM tbusers WHERE email = '$email' AND password = '$pass'";
			$res = $mysqli->query($query);
			if($row = mysqli_fetch_array($res))
			{
				echo 	"<h2 class='display-6' style='text-align:center'> Hi ".$row['name'] . ", welcome back!</h2>";
						

				echo 	"<p class='lead'>Here's what you're up to:</p>
							<div class='row'>
								<div class='col-8 ' >
									<div class='row eventsGallery' >";	
						
						$query1 = "SELECT * FROM tbevents WHERE user_id = '$user_id' ORDER BY date DESC";
						$res1= $mysqli->query($query1);
							while($r = mysqli_fetch_array($res1))
							{	
								$query2 = "SELECT image_name FROM tbgallery WHERE event_id ='$r[event_id]'";
								$img = $mysqli->query($query2);
								if($i = mysqli_fetch_array($img))
								{
									$image = $i['image_name'];
									echo	"
									<div class='col-4'>
										
										<div class='card border-light shadow mb-5 rounded' id='privateEvents'>
										<a id='cardLink' href='event.php?event_id=".$r['event_id']."' title='Go to ".$r['name']." event page'>
										<img class='card-img-top' src='gallery/". $image ."' alt='Card image not found'>
										</a>
											<div class='card-body'>
												<h5 class='card-title'>". $r['name']."</h5>
												<p class='card-text'>". $r['description']  ."</p>
											</div>
											<ul class='list-group list-group-flush'>
												<li class='list-group-item' id='when'>When: ". $r['date']."</li>
												<li class='list-group-item'id='where'>Where: ". $r['location']."</li>
												<li class='list-group-item'id='hash' >". $r['hashtags']."</li>
											</ul>
										</div>
										
									</div>";
									
									// else
									// {
									// 	echo "<p class='lead'><strong>You have no events! Try making some so you don't feel left out...</strong></p>";
									// }
								}
								
								
							
							}
						
						
						

				echo			"</div>
				</div>
							<div class='col-4'>
								<div class='card border-light shadow mb-5 rounded' id='newEvent'>
								<div class='card-body'>
								<h5 class='card-title'>New Event</h5>
									<form action='home.php' method='POST' enctype='multipart/form-data'>
									<div class='form-group'>
										
										<label for='eventName'>Event Name:</label><br>
										<input type='text' class='form-control' name='eventName' /><br>								
										<label for='eventDescription'>Event Description:</label><br>
										<input type='text' class='form-control' name='eventDescription' /><br>

										<label for='eventCategory'>Event Category:</label>
										<select id='inputCategory' class='form-control' name='eventCategory'>
											<option selected>Choose Event Category...</option>";

											$queryCat = "SELECT * FROM tbcategory";
											$resCat= $mysqli->query($queryCat);
											while($cat = mysqli_fetch_array($resCat))
											{
												echo "<option>". $cat['category'] . "</option>";
											}
										echo "
										</select><br>

										<label for ='eventDate'>Event Date:</label><br>
										<input type='date' class='form-control' name='eventDate' /><br>	

										<label for='eventLocation'>Event Location:</label><br>
										<input type='text' class='form-control' name='eventLocation' /><br>								
										<label for='eventHashtags'>Event Hashtags:</label><br>
										<input type='text' class='form-control' name='eventHashtags' /><br>

										<input type='file' class='form-control' name='picToUpload' id='picToUpload' /><br/>								
										<input type='hidden' name='email' value='". $email ."'/>
										<input type='hidden' name='pass' value='". $pass ."'/>
										<input type='submit' class='btn btn-dark' value='Upload event' name='submit' />
									</div>
									</form>
								</div>
								</div>
							</div>
						</div>";
						  
				

				echo 	"<p class='lead'>Here's what everyone else is up to:</p>
							<div class='row eventsGallery scroll'>";	
						
						$query1 = "SELECT * FROM tbevents WHERE user_id != '$user_id' ORDER BY date DESC";
						$res1= $mysqli->query($query1);
						while($r = mysqli_fetch_array($res1))
						{		
							$query3 = "SELECT * FROM tbusers WHERE user_id ='$r[user_id]'";
							$u = $mysqli->query($query3);
							if($person = mysqli_fetch_array($u))
							{
								$name = $person['name'];
								$surname = $person['surname'];
							}
							$query2 = "SELECT image_name FROM tbgallery WHERE event_id ='$r[event_id]'";
							$img = $mysqli->query($query2);
							if($i = mysqli_fetch_array($img))
							{
								$image = $i['image_name'];
								echo	"
								<div class='col-3'>
								
									<div class='card border-light shadow mb-5 rounded' id='publicEvents'>
									<div class='card-header'>".$name . " ". $surname."'s event</div>
									<a id='cardLink' href='event.php?event_id=".$r['event_id']."' title='Go to ".$r['name']." event page'>
									<img class='card-img-top' src='gallery/". $image ."' alt='Card image not found'>
									</a>
										<div class='card-body'>
											<h5 class='card-title'>". $r['name']."</h5>
											<p class='card-text'>". $r['description']  ."</p>
										</div>
										<ul class='list-group list-group-flush'>
											<li class='list-group-item' id='when'>When: ". $r['date']."</li>
											<li class='list-group-item'id='where'>Where: ". $r['location']."</li>
											<li class='list-group-item'id='hash' >". $r['hashtags']."</li>
										</ul>
									</div>
									
								</div>";
								
							}
						
						
						}
						echo "</div>";
			}//end if

			else
			{
				echo 	'<div class="alert alert-danger mt-3" role="alert">
  							You are not registered on this site! Log in again or register <a href="index.html" class="alert-link">here!</a>
  						</div>';
			}//end else
		?>
	</div>
</body>
</html>