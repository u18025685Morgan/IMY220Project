<?php
	require "database.php";
	require "nav.html";
    session_start(); 
	$user_id = $_SESSION['user'];

	
    ?>

<!DOCTYPE html>
<html>
<head>
	<title>EventScape Profile</title>
	<meta charset="utf-8" />
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/css/bootstrap.min.css" integrity="sha384-KyZXEAg3QhqLMpG8r+8fhAXLRk2vvoC2f3B09zVXn8CA5QIVfZOJ3BCsw2P0p/We" crossorigin="anonymous">
	<link rel="stylesheet" type="text/css" href="style.css" />
	<meta charset="utf-8" />
	<meta name="author" content="Morgan Else">
	<script src="https://code.jquery.com/jquery-3.6.1.js" integrity="sha256-3zlB5s2uwoUzrXK3BT7AX3FyvojsraNFxCc2vC/7pNI=" crossorigin="anonymous"></script>
	<script src="https://kit.fontawesome.com/d183f81595.js" crossorigin="anonymous"></script>
	<?php require "favicon.html"; ?>
</head>
<body>

	<div class="container">
	<p class='lead'>Your friends:</p>
		<div class="row eventsGallery scroll">
			

					<?php 
					$cardColours = array(" ", "privateEvents", "publicEvents");
					$count = 0;
					$queryfriends = "SELECT * FROM tbfriends WHERE (friend1_id = '$user_id' OR friend2_id = '$user_id') AND friend_status = 'friends'";
					$resfriends= $mysqli->query($queryfriends);
					while($rowfriends = mysqli_fetch_array($resfriends))
					{if($count == 3)
						{
							$count = 0;
						}
						if($rowfriends['friend1_id'] == $user_id)
						{
							$friend_id = $rowfriends['friend2_id'];
						}
						else{
							$friend_id = $rowfriends['friend1_id'];
						}
						
						$friendQuery = "SELECT * FROM tbusers WHERE user_id = '$friend_id'";
						$friendResult= $mysqli->query($friendQuery);
						while($friend = mysqli_fetch_array($friendResult))
						{		
							
							$friendI = "SELECT * FROM tbusergallery WHERE user_id = '$friend_id'";
							$friendResultI= $mysqli->query($friendI);
							if($friendimage = mysqli_fetch_array($friendResultI))
							{
								$friendImagei = $friendimage['image_name'];
							}
							else
							{
								$friendImagei = "chilldog.jpg";
							}
							echo "
							<div class='col-3'>
										
								<div class='card border-light shadow mb-5 rounded' id='". $cardColours[$count] ."' >
								<a id='cardLink' href='profile.php?user_id=".$friend['user_id']."' style='border-radius: 50%' title='Go to ".$friend['name']."s profile'>
								<img class='card-img-top' src='usergallery/". $friendImagei ."' style='border-radius: 50%' alt='Card image not found'>
								</a>
									<div class='card-body'>
										<h5 class='card-title'>". $friend['name']."</h5>
										<p class='card-text'>". $friend['bio']  ."</p>
									</div>
								
								</div>
								
							</div>";

							
						}
							
						$count++;
					}
					?>

				
		</div>
    </div>
</body>
<script>
// $('li#convo').on('click', function() {
//     $.ajax({
//         url:'friendchats.php',
//         type: 'POST',
//         data : {user_id: <?php echo "'$user_id'"; ?>, friend : <?php echo "'$friend_id'"; ?>}
//     })
//     .done(data =>{
// 		if(data){
// 			console.log(data);
// 			$('div.row').append(
//             $("<div></div>", {
//                 class : 'col-lg-8',
//                 id : 'chatarea'
//             })
//         );
// 		// document.getElementById('accept').innerHTML = 'Remove Friend';
// 		// document.getElementById('accept').id = 'remove';
        
//     }
// });

// });
</script>
</html>