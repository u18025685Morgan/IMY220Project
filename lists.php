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
        <?php  
            if($list_id != null)
            {
                echo "<p class='lead'>Here are your lists you've made: <a class='btn profile-edit-btn' href='newlist.php'>New List</a></p>";
            }
            else
            {
                echo "<p class='lead'>Looks like you have no lists of events yet! <a class='btn profile-edit-btn' href='newlist.php'>New List</a></p>";
            }
        ?>
    
    </div>
</body>
</html>