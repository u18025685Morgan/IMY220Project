<?php
	require "database.php";
	require "nav.html";
	
	session_start();
    $search = $_GET['search'];
    $user_id = $_SESSION['user'];

    

    
    ?>

<!DOCTYPE html>
<html>
<head>
	<title>EventScape Search Results</title>
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
        echo "<p class='lead'>Events that match your search: '". $search ."'</p>
        <div class='row eventsGallery scroll'>";
            $query = "SELECT * FROM tbevents WHERE (name LIKE '%$search%' OR description LIKE '%$search%' OR date LIKE '%$search%' OR location LIKE '%$search%' OR hashtags LIKE '%$search%')";
            $res= $mysqli->query($query);
            while($events = mysqli_fetch_array($res))
            {
                echo "
                
                    <div class='col-lg-3 col-sm-6'>";
                    $query2 = "SELECT image_name FROM tbgallery WHERE event_id ='$events[event_id]'";
                    $img = $mysqli->query($query2);
                    if($i = mysqli_fetch_array($img))
                    {
                        $image = $i['image_name'];
                        echo	"    
                        <div class='card border-light shadow mb-5 rounded' id='privateEvents'>
                            <a id='cardLink' href='event.php?event_id=".$events['event_id']."' title='Go to ".$events['name']." event page'>
                            <img class='card-img-top' src='gallery/". $image ."' alt='Card image not found'>
                            </a>
                                <div class='card-body'>
                                    <h5 class='card-title'>". $events['name']."</h5>
                                    <p class='card-text'>". $events['description']  ."</p>
                                </div>
                                <ul class='list-group list-group-flush'>
                                    <li class='list-group-item' id='when'>When: ". $events['date']."</li>
                                    <li class='list-group-item'id='where'>Where: ". $events['location']."</li>
                                    <li class='list-group-item'id='hash' >". $events['hashtags']."</li>
                                </ul>
                        </div>";
                    }
                    echo "</div>";
            }
            echo "</div>
            
            <p class='lead'>Users that match your search: '". $search ."'</p>
                <div class='row eventsGallery scroll'>";
            $query1 = "SELECT * FROM tbusers WHERE (name LIKE '%$search%' OR surname LIKE '%$search%' OR email LIKE '%$search%')";
            $res1= $mysqli->query($query1);
            while($users = mysqli_fetch_array($res1))
            {
                echo "
                    <div class='col-lg-3 col-sm-6'>";
                    $userQuery = "SELECT * FROM tbusergallery WHERE user_id = '$users[user_id]'";
                    $userResult= $mysqli->query($userQuery);
                    if($userImage = mysqli_fetch_array($userResult))
                    {
                        $userI = $userImage['image_name'];
                    }
                    else
                    {
                        $userI = "chilldog.jpg";
                    }
                    echo "
                    <div class='card border-light shadow mb-5 rounded' id='publicEvents' >
                        <a id='cardLink' href='profile.php?user_id=".$users['user_id']."' style='border-radius: 50%' title='Go to ".$users['name']."s profile'>
                        <img class='card-img-top' src='usergallery/". $userI ."' style='border-radius: 50%' alt='Card image not found'>
                        </a>
                            <div class='card-body'>
                                <h5 class='card-title'>". $users['name']."</h5>
                                <p class='card-text'>". $users['bio']  ."</p>
                            </div>
                        
                        </div>
                </div> ";
            }
            echo "</div>";
        ?>
    </div>
</body>
</html>