<?php
	require "database.php";
	require "nav.html";
    session_start(); 
    $user_id = $_SESSION['user'];

    $query = "SELECT * FROM tblists WHERE user_id = '$user_id'";
	$res= $mysqli->query($query);
    if($row = mysqli_fetch_array($res))
    {
        $list_id = $row['list_id'];
    }
    else
    {
        $list_id = null;
    }



    ?>

<!DOCTYPE html>
<html>
<head>
	<title>EventScape New List</title>
	<meta charset="utf-8" />
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/css/bootstrap.min.css" integrity="sha384-KyZXEAg3QhqLMpG8r+8fhAXLRk2vvoC2f3B09zVXn8CA5QIVfZOJ3BCsw2P0p/We" crossorigin="anonymous">
	<link rel="stylesheet" type="text/css" href="style.css" />
	<meta charset="utf-8" />
	<meta name="author" content="Morgan Else">
    <script src="https://code.jquery.com/jquery-3.6.1.js" integrity="sha256-3zlB5s2uwoUzrXK3BT7AX3FyvojsraNFxCc2vC/7pNI=" crossorigin="anonymous"></script>
    <script src="script.js"></script>
	<?php require "favicon.html"; ?>
</head>
<body>

	<div class="container">
    <div class='card border-light shadow mb-5 rounded' id='newEvent'>
            <div class='card-body'>
            <h5 class='card-title'>List Details</h5>
            <?php echo "<form action='lists.php' method='POST' enctype='multipart/form-data'>
                    <div class='form-group'>
                        <div class='row'>
                            <div class='col-6 col-lg-4'>
                                <label for='regName'>List Name:</label>
                                <input type='text' id='regName' class='form-control'  name='listName' required>
                            </div>
                            <div class='col-6 col-lg-4'>
                                <label for='regDescription'>List Description:</label>
                                <input type='text' id='regDescription' class='form-control' name='listDescription' required> </br>
                            </div>
                            
                        </div>
                        <div class='row eventsGallery scroll'>";
                        $eventsquery = "SELECT * FROM tbevents WHERE status = 'active' ORDER BY date DESC";
	                    $eventsres= $mysqli->query($eventsquery);
                        while($events = mysqli_fetch_array($eventsres))
                        {
                            $query2 = "SELECT image_name FROM tbgallery WHERE event_id ='$events[event_id]'";
							$img = $mysqli->query($query2);
							if($i = mysqli_fetch_array($img))
							{
								$image = $i['image_name'];
                            echo "<div class='col-3'>
								
                                    <div class='form-check'>
                                        <input class='form-check-input' type='checkbox' name='events[]' value='". $events['event_id'] ."id='gridCheck'>
                                        <label class='form-check-label' for='gridCheck'>
                                            <div class='card border-light shadow mb-5 rounded' id='privateEvents'>
                                                <a id='cardLink' href='event.php?event_id=".$events['event_id']."' title='Go to ".$events['name']." event page'>
                                                <img class='card-img-top' src='gallery/". $image ."' alt='Card image not found'>
                                                </a>
                                                    <div class='card-body'>
                                                        <h5 class='card-title'>". $events['name']."</h5>
                                                        <p class='card-text'>". $events['description']  ."</p>
                                                    </div>
                                                    
                                            </div>
                                        </label>
                                    </div>
									
									
								</div>";
                            }
                        }
                            
                        echo "</div>
                        "; ?>
                        <div class="row mt-3">
                            <div class="col-12">
                                <button type="submit" class="btn btn-dark">Create List</i></button>
                            </div>
                        </div>
                    </div>
				</form>
			</div>
		</div>
    </div>
</body>
</html>