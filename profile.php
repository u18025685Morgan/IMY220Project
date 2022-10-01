<?php
	require "database.php";
	require "nav.html";
    session_start(); 

    
    $userPage_id = isset($_GET["user_id"]) ? $_GET["user_id"] : null;
    $user_id = $_SESSION['user'];

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
    <script src="script.js"></script>
	<?php require "favicon.html"; ?>
</head>
<body>

	<div class="container">

</div>
</body>
</html>