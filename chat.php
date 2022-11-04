<?php
	require "database.php";
	require "nav.html";
    session_start(); 
    $user_id = $_SESSION['user'];

    $friend_id = $_GET["friend_id"];

    $queryfriend = "SELECT * FROM tbusers WHERE user_id = '$friend_id'";
	$resfriend= $mysqli->query($queryfriend);
	if($friend = mysqli_fetch_array($resfriend))
    {
        $friendname = $friend['name'];

    }

    ?>
<!DOCTYPE html>
<html>
<head>
	<title>EventScape Chat</title>
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
        <?php echo "<p class='lead' style='text-align:center'>Your chat with ". $friendname ."</p>"; ?>
        <div class="row">
            <div class="col-lg-3 col-sm-6">
            <?php $friendQuery = "SELECT * FROM tbusers WHERE user_id = '$friend_id'";
                $friendResult= $mysqli->query($friendQuery);
                if($friend = mysqli_fetch_array($friendResult))
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
                }?>
                    <div class="card border-light shadow mb-5 rounded-circle" style="height: 18rem, border-radius: 50%">
                        
                            
                            <?php echo "<a id='cardLink' href='profile.php?user_id=".$friend_id."' >
                             <img class='card-img-top' src='usergallery/". $friendImagei ."' alt='Card image cap' style='border-radius: 50%'>
                            </a>"; ?>
                            
                        
                    </div>
            </div>
            
            <div class="col-9">
                <div class="messages row scroll">
                    <?php
                        $queryconvo = "SELECT * FROM tbconvos WHERE (friend1_id = '$friend_id' AND friend2_id = '$user_id') OR (friend1_id = '$user_id' AND friend2_id='$friend_id')"; 
                        $resconvo= $mysqli->query($queryconvo);
                        if($convo = mysqli_fetch_array($resconvo))
                        {
                            $convo_id = $convo['convo_id'];
                            $querymsg = "SELECT * FROM tbmessages WHERE convo_id = '$convo_id' "; 
                            $resmsg= $mysqli->query($querymsg);
                            $count = 0;
                            while($msg = mysqli_fetch_array($resmsg))
                            {
                                $sender_id = $msg['sender_id'];
                                if($sender_id == $user_id)
                                {
                                    echo "<div class='col-4 offset-5' id='mymessage'>".$msg['message']."</div>";
                                }
                                else
                                {
                                    
                                        echo "<div class='col-4 offset-1' id='friendmessage'>".$msg['message']."</div>";
                                    
                                    
                                }
                                $count++;
                            }
                        }
                    ?>

                </div>
            </div>
        </div>
        <div class="row" >

			<div class="col-7 offset-3">
				<label for="message">Type a message and hit send</label>
				<textarea class="form-control" id="message" name = "message" rows="1"></textarea>
				<button type="submit" id ="sendmsg" class="btn btn-dark submit">Send</button>
			</div>
		</div>
    </div>
</body>

<script>

$("button#sendmsg").on('click', function(){
        let str = $("#message").val();

        $.ajax({
        url:'sendmsg.php',
        type: 'POST',
        data : {convo_id:  <?php echo "'$convo_id'"; ?>, sender_id : <?php echo "'$user_id'"; ?>, message :  str }
    })
    .done(data =>{
        $('div.messages').append(data);

        
    });

});
</script>
</html>