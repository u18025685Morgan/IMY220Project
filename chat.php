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
	<title>EventScape Lists</title>
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

        <div class="messages row">
            

        </div>
        <div class="row">

			<div class="col">
				<label for="message">Type a message and hit send</label>
				<textarea class="form-control" id="message" name = "message" rows="3"></textarea>
				<button type="submit" class="btn btn-dark submit">Send</button>
			</div>
		</div>
    </div>
</body>
</html>