<?php
	require "database.php";
	require "nav.html";
    session_start(); 

    $event_id = $_GET['event_id'];
    $user_id = $_SESSION['user'];

    

    $query = "SELECT * FROM tbevents WHERE event_id = '$event_id'";
	$res= $mysqli->query($query);
    if($row = mysqli_fetch_array($res))
    {
        $eventUser = $row['user_id'];
        $eventName = $row['name'];
        $eventDescription = $row['description'];
        $eventDate = $row['date'];
        $eventLocation = $row['location'];
        $eventHashtags = $row['hashtags'];
        $eventCategory = $row['category'];

        $query2 = "SELECT image_name FROM tbgallery WHERE event_id ='$event_id'";
        $img = $mysqli->query($query2);
        if($i = mysqli_fetch_array($img))
        {
            $image = $i['image_name'];
        }
	}

    if($eventUser != $user_id)
    {
        $query1 = "SELECT * FROM tbusers WHERE user_id ='$eventUser'";
        $res1 = $mysqli->query($query1);
        if($e = mysqli_fetch_array($res1))
        {
            $eventUserName = $e['name'];
            $eventUserSurname = $e['surname'];
            $eventUserID = $e['user_id'];
        }
    }

    $eventAttendReview = isset($_POST["eventAttendReview"]) ? $_POST["eventAttendReview"] : null;
	$rate = isset($_POST["rate"]) ? $_POST["rate"] : null;
	$reviewUser_id = isset($_POST["user_id"]) ? $_POST["user_id"] : null;
	$eventAttendImage = isset($_FILES["eventAttendImage"]) ? $_FILES["eventAttendImage"] : null;
	
	if($eventAttendReview !== null && $rate !== null && $reviewUser_id !== null & $eventAttendImage !== null)
	{
		$target_dir = "gallery/";
		$target_file = $target_dir . basename($_FILES["eventAttendImage"]["name"]);
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

		$allowed = array('jpeg', 'pjpeg', 'jpg');
		$filename = $_FILES["eventAttendImage"]["name"];

		if(in_array($imageFileType, $allowed) && $eventAttendImage["size"] < 1048576 ){ 
            if($eventAttendImage["error"] > 0 ){
                echo "Error: " . $eventAttendImage["error"] . "<br/>";
            }
            else
            {
                
					move_uploaded_file($eventAttendImage["tmp_name"], "gallery/" . $eventAttendImage["name"]);
					$queryR = "INSERT INTO tbreviews (event_id, user_id, stars, comment) VALUES ('$event_id', '$reviewUser_id', '$rate', '$eventAttendReview');";
					$resR = mysqli_query($mysqli, $queryR) == TRUE;

					$query = "SELECT review_id FROM tbreviews WHERE review_id = '$reviewUser_id'";
					$review = $mysqli->query($query);
					if($row = mysqli_fetch_array($review))
					{
						$review_id = $row['review_id'];
                        $query = "INSERT INTO tbreviewgallery (review_id, image_name) VALUES ('$review_id', '$filename');";
					    $res = mysqli_query($mysqli, $query) == TRUE;
					}

					

				
            }

        }else{
            echo "<div class='alert alert-danger mt-3' role='alert'> Invalid file </div>";
        }
	}

    $bailedEvent = isset($_POST["bail_id"]) ? $_POST["bail_id"] : null;
    
    if($bailedEvent != null){
        $bail = "DELETE FROM tbreviews WHERE review_id = '$bailedEvent' && user_id = '$user_id'";
        $bailed = mysqli_query($mysqli, $bail) == TRUE;

        $bailImg = "DELETE FROM tbreviewgallery WHERE review_id = '$bailedEvent'";
        $bailed = mysqli_query($mysqli, $bailImg) == TRUE;
    }



?>

<!DOCTYPE html>
<html>
<head>
	<title>EventScape</title>
	<meta charset="utf-8" />
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/css/bootstrap.min.css" integrity="sha384-KyZXEAg3QhqLMpG8r+8fhAXLRk2vvoC2f3B09zVXn8CA5QIVfZOJ3BCsw2P0p/We" crossorigin="anonymous">
	<link rel="stylesheet" type="text/css" href="style.css" />
	<meta charset="utf-8" />
	<meta name="author" content="Morgan Else">
    <script src="https://kit.fontawesome.com/d183f81595.js" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.6.1.js" integrity="sha256-3zlB5s2uwoUzrXK3BT7AX3FyvojsraNFxCc2vC/7pNI=" crossorigin="anonymous"></script>
    
	<?php require "favicon.html"; ?>
</head>
<body>

	<div class="container">
        <?php echo "<h2 class='display-6' style='text-align:center'>Event: ".$eventName . "</h2>"; 
        if($eventUser == $user_id)
        {
            echo 	"<p class='lead'>You created this event  <a class='btn btn-dark' href='editevent.php?event_id=". $event_id ."' role='button'>Edit Event</a> <a class='btn btn-dark' href='deleteevent.php?event_id=". $event_id ."' role='button'>Delete Event</a></p>";
        }else
        {
            echo 	"<p class='lead'><a href='profile.php?user_id=". $eventUserID ."'>". $eventUserName . " " . $eventUserSurname . "</a> created this event</p>";
        }
         ?>
        <div class="row">
            <div class="col-lg-3 col-sm-6">
                <div class="card border-light shadow mb-5 rounded" style="height: 18rem">
                    
                        <div class="img-square-wrapper">
                        <?php echo "<img class='card-img-top' src='gallery/". $image ."' alt='Card image cap'>"; ?>
                        </div>
                       
                </div>
            </div>
            <div class="col-lg-3 col-sm-6">
                <div class="card border-light shadow mb-5 rounded" style="height: 18rem">
                   <?php echo "<div class='card-body'>
                            <h5 class='card-title'>". $eventName."</h5>
                            <p class='card-text'>". $eventDescription  ."</p>
                        </div>
                        <ul class='list-group list-group-flush'>
                            <li class='list-group-item' id='when'>When: ". $eventDate."</li>
                            <li class='list-group-item'id='where'>Where: ". $eventLocation."</li>
                            <li class='list-group-item'id='hash' >". $eventHashtags."</li>
                        </ul>
                    </div>"; ?>
                </div>

            <div class="col-lg-6 col-sm-12">   
                <div class="card border-light shadow mb-5 rounded" style="height: 18rem" id='newEvent'>

                <?php 
                 $queryRev = "SELECT * FROM tbreviews WHERE event_id = '$event_id' && user_id ='$user_id'";
                 $resRev= $mysqli->query($queryRev);
                 if($row = mysqli_fetch_array($resRev))
                 {
                    $review_id = $row['review_id'];
                    echo "<div class='card-body'>
                            <h5 class='card-title'>You are already going to this event, do you wanna bail?</h5>
                            <form action='event.php?event_id=".$event_id ."' method='POST' enctype='multipart/form-data'>
                                <input type='hidden' name='bail_id' value='". $review_id ."'/>
                                <input type='submit' class='btn btn-dark' value='Bail' name='submit' />
                            </form>
                        </div>";
                 }
                 else{
                    echo"<div class='card-body'>
                    <h5 class='card-title'>Are ya going?</h5>
                    <form action='event.php?event_id=".$event_id ."' method='POST' enctype='multipart/form-data'>
                        <div class='form-group'>
                            <label for='eventAttendImage'>Attach an image from the event!</label>
                            <input type='file' class='form-control-file' name='eventAttendImage' id='eventAttendImage'><br>
                            <label for='eventAttendReview'>Comments</label>
                            <textarea class='form-control' name='eventAttendReview' id='eventAttendReview' rows='3'></textarea><br>
                            <div class='rate'>
                                <input type='radio' id='star5' name='rate' value='5' />
                                <label for='star5' title='text'>5 stars</label>
                                <input type='radio' id='star4' name='rate' value='4' />
                                <label for='star4' title='text'>4 stars</label>
                                <input type='radio' id='star3' name='rate' value='3' />
                                <label for='star3' title='text'>3 stars</label>
                                <input type='radio' id='star2' name='rate' value='2' />
                                <label for='star2' title='text'>2 stars</label>
                                <input type='radio' id='star1' name='rate' value='1' />
                                <label for='star1' title='text'>1 star</label>
                            </div>
                            <input type='hidden' name='user_id' value='". $user_id ."'/>
                            <input type='submit' class='btn btn-dark' value='Attend' name='submit' />
                        </div>
                    </form>
                        
                </div>";
                 }
                ?>
                   
                </div>
            </div>
        </div>  
        <div class="row">
            <div class="col-lg-6 col-sm-6">
                <div class="card border-light shadow mb-5 rounded" id='privateEvents'>
                    <div class="card-body" style="text-align:center">
                        <h5 class='card-title'>Rating</h5>
                        <?php 
                             $queryStars = "SELECT AVG(stars) FROM tbreviews WHERE event_id = '$event_id'";
                             $resStars= $mysqli->query($queryStars);
                             while($stars = mysqli_fetch_array($resStars)){
                                if($stars['AVG(stars)'] != 0){
                                echo "<p class='card-text'>This event has an average rating of ". floor($stars['AVG(stars)']);
                    
                                    for($i = 0; $i <$stars['AVG(stars)']; $i++)
                                    {
                                        echo " ★ ";
                                    }
                                echo "</p>";}
                                else{
                                    echo "<p class='card-text'>No one has attended this event yet</p> ";
                                }
                             }
                        
                        ?>
                        
                    </div>
                </div>
            </div>
            <div class="col-lg-6 col-sm-6">
                <div class="card border-light shadow mb-5 rounded">
                    <div class="card-body" id="dynamicList" style="text-align:center">
                        <h5 class='card-title'>Add this event to a list?  <button type='submit' class='btn btn-dark' id="addToList">Add to List <i class="fa-solid fa-plus"></i></button></h5>
                        
                    </div>
                </div>
            </div>
        </div>
       <div class="row scroll" style="height: 40rem">
            <div class='row eventsGallery' >
            <?php 
                $cardColours = array(" ", "privateEvents", "publicEvents");
                $count = 0;
                $queryRev = "SELECT * FROM tbreviews WHERE event_id = '$event_id' ORDER BY review_date DESC";
                $resRev= $mysqli->query($queryRev);
                while($row = mysqli_fetch_array($resRev)){
                    if($count == 3)
                    {
                        $count = 0;
                    }
                    $userRev = $row['user_id'];
                    
                    $uv = "SELECT * FROM tbusers WHERE user_id = '$userRev'";
                    $u= $mysqli->query($uv);
                    if($uvs = mysqli_fetch_array($u))
                    {
                        $query2 = "SELECT image_name FROM tbreviewgallery WHERE review_id ='$row[review_id]'";
						$img = $mysqli->query($query2);
						if($i = mysqli_fetch_array($img))
                        {
                            $image = $i['image_name'];
                            echo "<div class='col-3'>
                            <div class='card' id='". $cardColours[$count] ."'>
                                <img class='card-img-top' src='gallery/". $image ."' alt='Card image not found'>
                                <div class='card-body'>
                                    <h5 class='card-title'><a id='cardLink' href='profile.php?user_id=". $userRev ."'>". $uvs['name'] . " " . $uvs['surname'] . " </a> <br>". $row['stars'] . " stars ";
                                    for($i = 0; $i < $row['stars']; $i++)
                                    {
                                        echo "★";
                                    }
                                    echo " </h5>
                                    <p class='card-text'>". $row['comment'] ."</p>
                                </div>
                                <div class='card-footer text-muted'>
                                    at ". $row['review_date'] ."
                                </div>
                            </div>
                            </div>";
                        }
                        
                    }

                    
                    $count++;
                } ?>
            </div>
        </div>
            
           
        
         
               
    </div>
</body>
<script>
    <?php echo "let userid = '$user_id';"; ?>
$('button#addToList').on('click', function() {
    $.ajax({
        url:'getlists.php',
        type: 'POST',
        data : {user:  <?php echo "'$user_id'"; ?> }
    })
    .done(data =>{
        $('div#dynamicList').append(
            $("<ul></ul>", {
                class : 'list-group list-group-flush',
                id : 'dynamicList'
            })
        );

        $('ul#dynamicList').append(data);
    })
});
    </script>
</html>