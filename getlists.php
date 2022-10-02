<?php
require "database.php";

$user_id = $_POST['user'];

$query = "SELECT * FROM tblists WHERE user_id = '$user_id'";
	$res= $mysqli->query($query);
    while($row = mysqli_fetch_array($res))
    {
        $list_id = $row['list_id'];

        $Equery = "SELECT * FROM tblists WHERE user_id = '$user_id'";
	    $Eres= $mysqli->query($Equery);
        while($Erow = mysqli_fetch_array($Eres))
        {
            echo "<li class='list-group-item'>". $Erow['list_name']."</li>";
        }

    }

    if($row = mysqli_fetch_array($res) == null)
    {
        echo "<p>You have no lists, make a new list <a href='lists.php' class='badge badge-light'>here</a></p> ";
    }

    ?>