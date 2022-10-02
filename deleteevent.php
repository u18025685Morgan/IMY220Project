<?php
	require "database.php";
	require "nav.html";
    session_start(); 

    $event_id = $_GET['event_id'];
    $user_id = $_SESSION['user'];

    $deletedevent_id = isset($_POST["deletedevent_id"]) ? $_POST["deletedevent_id"] : null;

    $deleted = FALSE;
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
        $eventStatus = $row['status'];

        $query2 = "SELECT image_name FROM tbgallery WHERE event_id ='$event_id'";
        $img = $mysqli->query($query2);
        if($i = mysqli_fetch_array($img))
        {
            $image = $i['image_name'];
        }
	}
    if($deletedevent_id !=null)
    {
        
        $queryR = "SELECT * FROM tbreviews WHERE event_id = '$deletedevent_id'";
        $resR= $mysqli->query($queryR);
        if($resR)
        {
            $reviews = mysqli_num_rows($resR);
            if($reviews)
            {
                $updateQuery = "UPDATE tbevents SET status = 'deleted' WHERE event_id = '$deletedevent_id'";
                $updateResult= $mysqli->query($updateQuery) == TRUE;
    
            }
            else{
                $bail = "DELETE FROM tbevents WHERE event_id = '$deletedevent_id'";
                $bailed = mysqli_query($mysqli, $bail) == TRUE;

                $bailImg = "DELETE FROM gbgallery WHERE event_id = '$deletedevent_id'";
                $bailed = mysqli_query($mysqli, $bailImg) == TRUE;
            }
        }

        $deleted = TRUE;
    }
   

?>

<!DOCTYPE html>
<html>
<head>
    <title>EventScape Delete Event</title>
    <meta charset="utf-8" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/css/bootstrap.min.css" integrity="sha384-KyZXEAg3QhqLMpG8r+8fhAXLRk2vvoC2f3B09zVXn8CA5QIVfZOJ3BCsw2P0p/We" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="style.css" />
    <meta charset="utf-8" />
    <meta name="author" content="Morgan Else">
    <?php require "favicon.html"; ?>
</head>
<body>

    <div class="container">
        <div class="row align-items-center">
            <?php 
            if($deleted)
            {
                echo "<div class='col-5 offset-3'>
                                            
                    <div class='card border-light shadow mb-5 rounded' id='privateEvents' style='text-align: center' >
                        <div class='card-body'>
                            <h5 class='card-title'>Event deleted</h5>
                            <a class='btn btn-dark' href='home.php' role='button' >Go Back Home</a>
                            
                        </div>
                    </div>
                </div>";
            }
            else
            {
                echo "<div class='col-3 offset-2'>
                                            
                <div class='card border-light shadow mb-5 rounded' id='privateEvents' >
                <a id='cardLink' href='event.php?event_id=".$event_id."' title='Go to ".$eventName." event page'>
                <img class='card-img-top' src='gallery/". $image ."' alt='Card image not found'>
                </a>
                    <div class='card-body'>
                        <h5 class='card-title'>". $eventName."</h5>
                        <p class='card-text'>". $eventDescription  ."</p>
                    </div>
                    <ul class='list-group list-group-flush'>
                        <li class='list-group-item' id='when'>When: ". $eventDate."</li>
                        <li class='list-group-item'id='where'>Where: ". $eventLocation."</li>
                        <li class='list-group-item'id='hash' >". $eventHashtags."</li>
                    </ul>
                </div>
                
            </div>
            <div class='col-5'>
                <div class='card-body' style='text-align: center'>
                    <h5 class='card-title'>Are you sure you want to delete this event?</h5>
                    <form action='deleteevent.php?event_id=".$event_id ."' method='POST' enctype='multipart/form-data'>
                        <input type='hidden' name='deletedevent_id' value='". $event_id ."'/>
                        <input type='submit' class='btn btn-dark' value='Delete Event' name='delete' />
                        <a class='btn btn-dark' href='home.php' role='button' >Go Back Home</a>
                    </form>
                </div>
            </div>";
            }
           
            
                ?>
            </div>
        </div>

    </div>
</body>
</html>