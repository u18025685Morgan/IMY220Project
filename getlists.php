<?php
require "database.php";

$user_id = $_POST['user'];
$event_id = $_POST['event'];

$query = "SELECT * FROM tblists WHERE user_id = '$user_id'";
	$res= $mysqli->query($query);
    if($row = mysqli_fetch_array($res))
    {
        $list_id = $row['list_id'];

        $Equery = "SELECT * FROM tblists WHERE user_id = '$user_id'";
	    $Eres= $mysqli->query($Equery);
        while($Erow = mysqli_fetch_array($Eres))
        {
            $list_id = $Erow['list_id'];
            echo "<li class='list-group-item'>". $Erow['list_name']."<a class='btn add-to-list-btn' href='lists.php?list_id=". $list_id ."&event_id=". $event_id ."'><i class='fa-solid fa-plus'></i></a></li>";
        }
        echo "<p>Make a new list <a href='newlist.php' class='badge badge-light'>here</a></p> ";
    }
    else
    {
        echo "<p>Make a new list <a href='newlist.php' class='badge badge-light'>here</a></p> ";
    }


    ?>