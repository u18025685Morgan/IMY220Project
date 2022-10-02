<?php
	require "database.php";
	require "nav.html";
    session_start(); 

    
    
    $user_id = $_SESSION['user'];
    $event_id = $_GET['event_id'];

    $query = "SELECT * FROM tbevents WHERE user_id = '$event_id'";
		$res= $mysqli->query($query);
		if($row = mysqli_fetch_array($res))
		{
            $name = $row['name'];
            $eventDescription = $row['description'];
			$date = $row['date'];
			$location = $row['location'];
			$hashtags = $row['hashtags'];
			$category = $row['category'];
			$status = $row['status'];
			

            $Iquery = "SELECT * FROM tbgallery WHERE event_id = '$event_id'";
		    $Ires= $mysqli->query($Iquery);
            if($i = mysqli_fetch_array($Ires))
            {
                $image = $i['image_name'];
            }

            

		}

    $uname = isset($_POST["name"]) ? $_POST["name"] : $name;
	$udescription = isset($_POST["description"]) ? $_POST["description"] : $eventDescription;
	$udate = isset($_POST["date"]) ? $_POST["date"] : $date;
	$ulocation = isset($_POST["location"]) ? $_POST["location"] : $location;
	$uhashtags = isset($_POST["hashtags"]) ? $_POST["hashtags"] : $hashtags;
	$ucategory = isset($_POST["category"]) ? $_POST["category"] : $category;
    $eventPic = isset($_FILES["eventPic"]) ? $_FILES["eventPic"] : $image;
    
    $updateQuery = "UPDATE tbevents SET name = '$uname', description = '$udescription', date = '$udate', location = '$ulocation', hashtags = '$uhashtags', category = '$ucategory', status = 'active' WHERE event_id = '$event_id'";
    $updateResult= $mysqli->query($updateQuery) == TRUE;
    

    if($eventPic != $image)
    {
        
        $target_dir = "gallery/";
		$target_file = $target_dir . basename($_FILES["eventPic"]["name"]);
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

		$allowed = array('jpeg', 'pjpeg', 'jpg');
		$filename = $_FILES["eventPic"]["name"];

        
        if(in_array($imageFileType, $allowed) && $eventPic["size"] < 1048576 ){ 
            if($eventPic["error"] > 0 ){
                echo "Error: " . $eventPic["error"] . "<br/>";
            }
            else
            {
                
                    move_uploaded_file($eventPic["tmp_name"], "gallery/" . $eventPic["name"]);
                    

                    $query = "UPDATE tbgallery SET image_name = '$filename' WHERE event_id = '$event_id'";
                    $res = mysqli_query($mysqli, $query) == TRUE;

                
            }
        }
    }
     
        
   
    

    ?>

<!DOCTYPE html>
<html>
<head>
	<title>EventScape Edit Event</title>
	<meta charset="utf-8" />
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/css/bootstrap.min.css" integrity="sha384-KyZXEAg3QhqLMpG8r+8fhAXLRk2vvoC2f3B09zVXn8CA5QIVfZOJ3BCsw2P0p/We" crossorigin="anonymous">
	<link rel="stylesheet" type="text/css" href="style.css" />
	<meta charset="utf-8" />
	<meta name="author" content="Morgan Else">
	<?php require "favicon.html"; ?>
</head>
<body>

	<div class="container">
        <?php echo "<h2 class='display-6' style='text-align:center'><a href='event.php?event_id=". $event_id ."'>Event: ".$name . "</a></h2>";?>
        <div class='card border-light shadow mb-5 rounded' id='newEvent'>
            <div class='card-body'>
            <h5 class='card-title'>Update Event</h5>
            <?php echo "<form action='editevent.php?event_id=". $event_id ."' method='POST' enctype='multipart/form-data'>
                    <div class='form-group'>
                        <div class='row'>
                            <div class='col-6 col-lg-4'>
                                <label for='regName'>Event Name:</label>
                                <input type='text' id='regName' class='form-control' value='". $uname."'  name='name' required>
                            </div>
                            <div class='col-6 col-lg-4'>
                                <label for='regDescription'>Event Description:</label>
                                <input type='text' id='regDescription' class='form-control' value='". $udescription ."' name='description' required>
                            </div>
                            <div class='col-6 col-lg-4'>
                                <label for='regEventDate'>Event Date:</label>
                                <input type='date' id='regEventDate' value='". $udate ."' class='form-control' name='date' required>
                            </div>
                        </div>
                        <div class='row mt-3'>
                            <div class='col-6 col-lg-4'>
                                <label for='regEventLoc'>Event Location:</label>
                                <input type='text' id='regEventLoc' class='form-control' value='". $ulocation ."' name='location'>
                            </div>
                            <div class='col-6 col-lg-4'>
                                <label for='regHash'>Event Hashtags:</label>
                                <input type='text' id='regHash' class='form-control' value='". $uhashtags ."' name='hashtags'>
                            </div>
                            <div class='col-6 col-lg-4'>
                                <label for='eventCategory'>Event Category:</label>
                                    <select id='inputCategory' class='form-control' name='eventCategory' value='". $ucategory ."'>
                                        <option selected>". $ucategory ."</option>";

                                            $queryCat = "SELECT * FROM tbcategory";
                                            $resCat= $mysqli->query($queryCat);
                                            while($cat = mysqli_fetch_array($resCat))
                                            {
                                                echo "<option>". $cat['category'] . "</option>";
                                            }
                                echo "</select><br>
                            </div>
                        </div>
                        <div class='row mt-3'>
                            <div class='col-6 col-lg-4'>
                                <label for='eventPic'>New Event Pic:</label>
                                <input type='file' class='form-control'  name='eventPic' id='eventPic' />
                            </div>
                           
                        </div>"; ?>
                        <div class="row mt-3">
                            <div class="col-12">
                                <button type="submit" class="btn btn-dark">Update Event</i></button>
                            </div>
                        </div>
                    </div>
				</form>
			</div>
		</div>
    </div>
</body>
</html>