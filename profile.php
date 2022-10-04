<?php
	require "database.php";
	require "nav.html";
    session_start(); 

    
    $userPage_id = isset($_GET["user_id"]) ? $_GET["user_id"] : null;
    $user_id = $_SESSION['user'];
	$notme = FALSE;
	if($userPage_id == null || $userPage_id == $user_id)
	{
		$notme = FALSE;
		$query = "SELECT * FROM tbusers WHERE user_id = '$user_id'";
		$res= $mysqli->query($query);
		if($row = mysqli_fetch_array($res))
		{
			$userFullName = $row['name'] . " " . $row['surname'];
			$email = $row['email'];
			$password = $row['password'];
			$birthday = $row['birthday'];
			$relationship = $row['relationship_status'];
			$work = $row['work'];
			$bio = $row['bio'];
			$pronouns = $row['pronouns'];

			$iquery = "SELECT * FROM tbusergallery WHERE user_id = '$user_id'";
			$ires= $mysqli->query($iquery);
			if($i = mysqli_fetch_array($ires))
			{
				
				if($i['image_name'] != null)
				{
					$image = $i['image_name'];
					
				}
			}else{
				$image = "chilldog.jpg";
			}
		}
		
	}
	else
	{
		$notme = TRUE;
		$query = "SELECT * FROM tbusers WHERE user_id = '$userPage_id'";
		$res= $mysqli->query($query);
		if($row = mysqli_fetch_array($res))
		{
			$userFullName = $row['name'] . " " . $row['surname'];
			$name = $row['name'];
			$email = $row['email'];
			$password = $row['password'];
			$birthday = $row['birthday'];
			$relationship = $row['relationship_status'];
			$work = $row['work'];
			$bio = $row['bio'];
			$pronouns = $row['pronouns'];

			$iquery = "SELECT * FROM tbusergallery WHERE user_id = '$userPage_id'";
			$ires= $mysqli->query($iquery);
			if($i = mysqli_fetch_array($ires))
			{
				
				if($i['image_name'] != null)
				{
					$image = $i['image_name'];
					
				}
			}else{
				$image = "chilldog.jpg";
			}
		}
	}

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
		<div class="row">
            <div class="col-lg-3 col-sm-6">
                <div class="card border-light shadow mb-5 rounded-circle" style="height: 18rem, border-radius: 50%">
                    
                        <div class="img-square-wrapper">
                        <?php echo "<img class='card-img-top' src='usergallery/". $image ."' alt='Card image cap' style='border-radius: 50%'>"; ?>
                        </div>
                       
                </div>
            </div>
            <div class="col-lg-6 col-sm-6">
                <div class="card border-light shadow mb-5 rounded"  id="privateEvents">
					<div class="card-body">
					<?php echo "<p id='pronoun'>". $pronouns ."</p>"; ?>
						<div class="profile-user-settings">
							<?php 
							if($notme)
							{
								$wrwQuery = "SELECT * FROM tbfriends WHERE (friend1_id = '$user_id' AND friend2_id = '$userPage_id') OR (friend1_id = '$userPage_id' AND friend2_id = '$user_id')";
								$wrwRes= $mysqli->query($wrwQuery);
								if($wrw = mysqli_fetch_array($wrwRes))
								{
									if($wrw['friend1_id'] == $user_id && $wrw['friend_status'] == "pending")
									{
										$friends = false;
										echo "<h3 class='profile-user-name'>". $userFullName ." </h3>
										<button type='submit' class='btn btn-dark' id='pending'>Pending</button>";
									}
									else if($wrw['friend1_id'] == $userPage_id && $wrw['friend_status'] == "pending")
									{
										$friends = false;
										echo "<h3 class='profile-user-name'>". $userFullName ." </h3>
										<button type='submit' class='btn btn-dark' id='accept'>Accept Request</button>";
									}
									else
									{
										$friends = TRUE;
										echo "<h3 class='profile-user-name'>". $userFullName ." </h3>
										<button type='submit' class='btn btn-dark' id='remove'>Remove Friend</button>
										<a class='btn profile-edit-btn' href='chat.php?friend_id=". $userPage_id ."'>Message</a>";
									}
								}
								else
								{
									$friends = false;
									echo "<h3 class='profile-user-name'>". $userFullName ." </h3>
									<button type='submit' class='btn btn-dark' id='add'>Add Friend</button>";
								}
								
							}else
							{
								echo "<h3 class='profile-user-name'>". $userFullName ." </h3>
								<a class='btn profile-edit-btn' href='editprofile.php'>Edit Profile</a>";
							} ?>
						</div>
						
						
						<div class="profile-stats">
							<ul>
								<?php 
								if($notme)
								{
									$queryE = "SELECT * FROM tbevents WHERE user_id = '$userPage_id'";
									$resE= $mysqli->query($queryE);
									if($resE)
									{
										$E = mysqli_num_rows($resE);
										if($E)
										{
											echo "<li><span class='profile-stat-count'>" . $E ."</span> events created</li>";
										}
										else
										{
											echo "<li><span class='profile-stat-count'>0</span> events created</li>";
										}
									}
									

									$queryF = "SELECT * FROM tbfriends WHERE (friend1_id = '$userPage_id' OR friend2_id = '$userPage_id') AND friend_status = 'friends'";
									$resF= $mysqli->query($queryF);
									
									if($resF)
									{	
										$F = mysqli_num_rows($resF);
										if($F)
										{
											echo "<li id='friends'><span class='profile-stat-count'>" . $F ."</span> friends</li>";
										}
										else
										{
											echo "<li id='friends'><span class='profile-stat-count'>0</span> friends</li>";
										}
									}

									$queryF = "SELECT * FROM tbreviews WHERE user_id = '$userPage_id'";
									$resF= $mysqli->query($queryF);
									
									if($resF)
									{	
										$F = mysqli_num_rows($resF);
										if($F)
										{
											echo "<li><span class='profile-stat-count'>" . $F ."</span> events attended</li>";
										}
										else
										{
											echo "<li><span class='profile-stat-count'>0</span> events attended</li>";
										}
									}
								}
								else
								{
									$queryE = "SELECT * FROM tbevents WHERE user_id = '$user_id'";
									$resE= $mysqli->query($queryE);
									if($resE)
									{
										$E = mysqli_num_rows($resE);
										if($E)
										{
											echo "<li><span class='profile-stat-count'>" . $E ."</span> events created</li>";
										}
										else
										{
											echo "<li><span class='profile-stat-count'>0</span> events created</li>";
										}
									}
									

									$queryF = "SELECT * FROM tbfriends WHERE (friend1_id = '$user_id' OR friend2_id = '$user_id') AND friend_status = 'friends'";
									$resF= $mysqli->query($queryF);
									
									if($resF)
									{	
										$F = mysqli_num_rows($resF);
										if($F)
										{
											echo "<li><span class='profile-stat-count'>" . $F ."</span> friends</li>";
										}
										else
										{
											echo "<li><span class='profile-stat-count'>0</span> friends</li>";
										}
									}

									$queryF = "SELECT * FROM tbreviews WHERE user_id = '$user_id'";
									$resF= $mysqli->query($queryF);
									
									if($resF)
									{	
										$F = mysqli_num_rows($resF);
										if($F)
										{
											echo "<li><span class='profile-stat-count'>" . $F ."</span> events attended</li>";
										}
										else
										{
											echo "<li><span class='profile-stat-count'>0</span> events attended</li>";
										}
									}
								}
									
									
								?>
								
							</ul>
						</div>
						<div class="profile-bio">
							<?php 
							echo "<p><b>Birthday: </b>". $birthday ."</p>";
							if($relationship)
							{
								echo "<p><b>Relationship Status: </b>". $relationship ."</p>";
							}
							if($work)
							{
								echo "<p><b>Job: </b>". $work ."</p>";
							}
							if($bio)
							{
								echo "<p>". $bio ."</p>";
							}
							else
							{
								echo "<p>I'm new to EventScape!</p>";
							}
							?>
						</div>
					</div>
                </div>
			</div>
			<div class="col-lg-3">
                <div class="card border-light shadow mb-5 rounded" style="height: 18rem">
                    
					<div class='card-body'>
						<?php 
							if($notme)
							{
								if($friends)
								{
									echo "<h5 class='card-title'>". $name ."'s Friends</h5>
										<ul class='list-group list-group-flush scroll'>";
										$friendsfriendQuery = "SELECT * FROM tbfriends WHERE (friend2_id = '$userPage_id' OR friend1_id = '$userPage_id') AND friend_status = 'friends'";
										$friendsfriendRes= $mysqli->query($friendsfriendQuery);
										while($ff = mysqli_fetch_array($friendsfriendRes))
										{
											if($ff['friend1_id'] != $userPage_id)
											{
												$friendOfaFriend = $ff['friend1_id'];
											}
											else
											{
												$friendOfaFriend = $ff['friend2_id'];
											}
											$ffQ = "SELECT * FROM tbusers WHERE user_id = '$friendOfaFriend'";
											$ffR= $mysqli->query($ffQ);
											if($foaf = mysqli_fetch_array($ffR))
											{
												$foaf_id = $foaf['user_id'];
												$ifquery = "SELECT * FROM tbusergallery WHERE user_id = '$foaf_id'";
												$ifres= $mysqli->query($ifquery);
												if($if = mysqli_fetch_array($ifres))
												{
													
													if($if['image_name'] != null)
													{
														$ifimage = $if['image_name'];
														
													}
												}else{
													$ifimage = "chilldog.jpg";
												}
												echo "<li class='list-group-item'><a href='profile.php?user_id=". $foaf_id ."'><i class='fa-solid fa-user'></i> ". $foaf['name']." " . $foaf['surname']."</a></li>";
											}
										}
								}
								else{
									echo "<p>Only ". $name ."'s friends can see their friend list</p>";
								}
							}
							else
							{
								echo "<h5 class='card-title'>Friend Requests</h5>
						<ul class='list-group list-group-flush scroll'>";
						 
							$qF = "SELECT * FROM tbfriends WHERE friend2_id = '$user_id' AND friend_status = 'pending'";
							$rF= $mysqli->query($qF);
							if($rF)
							{
								$friendRequests = mysqli_num_rows($rF);
								if($friendRequests)
								{
									while($requests = mysqli_fetch_array($rF))
									{
										$friend_id = $requests['friend1_id'];
										$friendQuery = "SELECT * FROM tbusers WHERE user_id = '$friend_id'";
										$friendResults= $mysqli->query($friendQuery);
										if($friend = mysqli_fetch_array($friendResults))
										{
											echo "<li class='list-group-item'><a href='profile.php?user_id=". $friend_id ."'>". $friend['name']."</a> wants to be your friend</li>";
										}
										
									}
								}
								else
								{
									echo "<p>No new friend requests</p>";
								}
							}
							
							
                        echo "</ul>";
							}
						?>
						
					</div>
                        
                
                       
                </div>
            </div>
        </div>  


<!--  ---------------------------------EVENTS GALLERY BELOW --------------------------------------------------------------------------------->
        
		<div class="row " style="height: 40rem">
			<div class="col-lg-6 col-sm-12">
				<?php if($notme)
				{
					echo "<p class='lead'>". $name ."'s Events</p>
					<div class='row eventsGallery scroll' >";
						
							$myEventQuery = "SELECT * FROM tbevents WHERE user_id = '$userPage_id' ORDER BY date DESC";
							$myEventResults= $mysqli->query($myEventQuery);
							while($myEvents = mysqli_fetch_array($myEventResults))
							{
								$myEventImageQuery = "SELECT image_name FROM tbgallery WHERE event_id ='$myEvents[event_id]'";
									$myEventImageResult = $mysqli->query($myEventImageQuery);
									if($myEventImage = mysqli_fetch_array($myEventImageResult))
									{
										$image = $myEventImage['image_name'];
										echo	"
										<div class='col-6'>
											
											<div class='card border-light shadow mb-5 rounded' id='privateEvents'>
											<a id='cardLink' href='event.php?event_id=".$myEvents['event_id']."' title='Go to ".$myEvents['name']." event page'>
											<img class='card-img-top' src='gallery/". $image ."' alt='Card image not found'>
											</a>
												<div class='card-body'>
													<h5 class='card-title'>". $myEvents['name']."</h5>
													<p class='card-text'>". $myEvents['description']  ."</p>
												</div>
												<ul class='list-group list-group-flush'>
													<li class='list-group-item' id='when'>When: ". $myEvents['date']."</li>
													<li class='list-group-item'id='where'>Where: ". $myEvents['location']."</li>
													<li class='list-group-item'id='hash' >". $myEvents['hashtags']."</li>
												</ul>
											</div>
											
										</div>";
	
									}
							}
				}
				else
				{
					echo "<p class='lead'>Your Events</p>
				<div class='row eventsGallery scroll' >";
					
						$myEventQuery = "SELECT * FROM tbevents WHERE user_id = '$user_id' ORDER BY date DESC";
						$myEventResults= $mysqli->query($myEventQuery);
						while($myEvents = mysqli_fetch_array($myEventResults))
						{
							$myEventImageQuery = "SELECT image_name FROM tbgallery WHERE event_id ='$myEvents[event_id]'";
								$myEventImageResult = $mysqli->query($myEventImageQuery);
								if($myEventImage = mysqli_fetch_array($myEventImageResult))
								{
									$image = $myEventImage['image_name'];
									echo	"
									<div class='col-6'>
										
										<div class='card border-light shadow mb-5 rounded' id='privateEvents'>
										<a id='cardLink' href='event.php?event_id=".$myEvents['event_id']."' title='Go to ".$myEvents['name']." event page'>
										<img class='card-img-top' src='gallery/". $image ."' alt='Card image not found'>
										</a>
											<div class='card-body'>
												<h5 class='card-title'>". $myEvents['name']."</h5>
												<p class='card-text'>". $myEvents['description']  ."</p>
											</div>
											<ul class='list-group list-group-flush'>
												<li class='list-group-item' id='when'>When: ". $myEvents['date']."</li>
												<li class='list-group-item'id='where'>Where: ". $myEvents['location']."</li>
												<li class='list-group-item'id='hash' >". $myEvents['hashtags']."</li>
											</ul>
										</div>
										
									</div>";

								}
						}
					}
						?>
				</div>
			</div>
			<div class="col-lg-6 col-sm-12">
				<?php if($notme)
					{
						echo "<p class='lead'>Events ". $name ." has gone to</p>
					<div class='row eventsGallery scroll' >";
					
							$myEventAQuery = "SELECT * FROM tbreviews WHERE user_id = '$userPage_id'";
							$myEventAResults= $mysqli->query($myEventAQuery);
							while($myAEvents = mysqli_fetch_array($myEventAResults))
							{
								$attendedEventQuery = "SELECT * FROM tbevents WHERE event_id = '$myAEvents[event_id]'";
								$attendeEventResults= $mysqli->query($attendedEventQuery);
								while($attendedEvents = mysqli_fetch_array($attendeEventResults))
								{
									$myEventAImageQuery = "SELECT image_name FROM tbgallery WHERE event_id ='$attendedEvents[event_id]'";
									$myEventAImageResult = $mysqli->query($myEventAImageQuery);
									if($myEventAImage = mysqli_fetch_array($myEventAImageResult))
									{
										$image = $myEventAImage['image_name'];
										echo	"
										<div class='col-6'>
											
											<div class='card border-light shadow mb-5 rounded' id='publicEvents'>
											<a id='cardLink' href='event.php?event_id=".$attendedEvents['event_id']."' title='Go to ".$attendedEvents['name']." event page'>
											<img class='card-img-top' src='gallery/". $image ."' alt='Card image not found'>
											</a>
												<div class='card-body'>
													<h5 class='card-title'>". $attendedEvents['name']."</h5>
													<p class='card-text'>". $attendedEvents['description']  ."</p>
												</div>
												<ul class='list-group list-group-flush'>
													<li class='list-group-item' id='when'>When they went: ". $myAEvents['review_date']."</li>
													<li class='list-group-item'id='where'>Stars: ";
													for($i = 0; $i < $myAEvents['stars']; $i++)
													{
														echo "★";
													}
													echo "</li>
													<li class='list-group-item'id='hash' >Their Review: ". $myAEvents['comment']."</li>
												</ul>
											</div>
											
										</div>";

									}
								}
								
							}

							
					echo "</div>";
					}
					else
					{
						echo "<p class='lead'>Events You've Gone to</p>
					<div class='row eventsGallery scroll' >";
					
							$myEventAQuery = "SELECT * FROM tbreviews WHERE user_id = '$user_id'";
							$myEventAResults= $mysqli->query($myEventAQuery);
							while($myAEvents = mysqli_fetch_array($myEventAResults))
							{
								$attendedEventQuery = "SELECT * FROM tbevents WHERE event_id = '$myAEvents[event_id]'";
								$attendeEventResults= $mysqli->query($attendedEventQuery);
								while($attendedEvents = mysqli_fetch_array($attendeEventResults))
								{
									$myEventAImageQuery = "SELECT image_name FROM tbgallery WHERE event_id ='$attendedEvents[event_id]'";
									$myEventAImageResult = $mysqli->query($myEventAImageQuery);
									if($myEventAImage = mysqli_fetch_array($myEventAImageResult))
									{
										$image = $myEventAImage['image_name'];
										echo	"
										<div class='col-6'>
											
											<div class='card border-light shadow mb-5 rounded' id='publicEvents'>
											<a id='cardLink' href='event.php?event_id=".$attendedEvents['event_id']."' title='Go to ".$attendedEvents['name']." event page'>
											<img class='card-img-top' src='gallery/". $image ."' alt='Card image not found'>
											</a>
												<div class='card-body'>
													<h5 class='card-title'>". $attendedEvents['name']."</h5>
													<p class='card-text'>". $attendedEvents['description']  ."</p>
												</div>
												<ul class='list-group list-group-flush'>
													<li class='list-group-item' id='when'>When you went: ". $myAEvents['review_date']."</li>
													<li class='list-group-item'id='where'>Stars: ";
													for($i = 0; $i < $myAEvents['stars']; $i++)
													{
														echo "★";
													}
													echo "</li>
													<li class='list-group-item'id='hash' >Your Review: ". $myAEvents['comment']."</li>
												</ul>
											</div>
											
										</div>";

									}
								}
								
							}

							
					echo "</div>";
					}?>
				
			</div>
        </div>
       
		
	</div>
</body>
<script>
	<?php echo "let userid = '$user_id';
	let userPageid = '$userPage_id';"; ?>
	$('button#add').on('click', function() {
    $.ajax({
        url:'friendmanage.php',
        type: 'POST',
        data : {user_id: <?php echo "'$user_id'"; ?>, friend : <?php echo "'$userPage_id'"; ?>, status : 'add'}
    })
    .done(data =>{
		if(data){
		document.getElementById('add').innerHTML = 'Pending';
		document.getElementById('add').id = 'pending';
        
    }
	
});

});

$('button#accept').on('click', function() {
    $.ajax({
        url:'friendmanage.php',
        type: 'POST',
        data : {user_id: <?php echo "'$user_id'"; ?>, friend : <?php echo "'$userPage_id'"; ?>, status : 'accept'}
    })
    .done(data =>{
		if(data){

		document.getElementById('accept').innerHTML = 'Remove Friend';
		document.getElementById('accept').id = 'remove';
        
    }
});

});

$('button#remove').on('click', function() {
    $.ajax({
        url:'friendmanage.php',
        type: 'POST',
        data : {user_id: <?php echo "'$user_id'"; ?>, friend : <?php echo "'$userPage_id'"; ?>, status : 'remove'}
    })
    .done(data =>{
		if(data){

		document.getElementById('remove').innerHTML = 'Add Friend';
		document.getElementById('remove').id = 'add';
        
    }
});

});
	
</script>
</html>