<?php
require "database.php";

$user_id = $_POST['user_id'];
$friend_id = $_POST['friend'];
$status = $_POST['status'];

if($status == 'add')
{
    $query = "INSERT INTO tbfriends (friend1_id, friend2_id, friend_status) VALUES ('$user_id', '$friend_id', 'pending');";
    $res = mysqli_query($mysqli, $query) == TRUE;
    
    
}
else if($status == 'accept')
{
    $updateQuery = "UPDATE tbfriends SET friend_status = 'friends' WHERE friend1_id = '$friend_id' AND friend2_id = '$user_id'";
    $updateResult= $mysqli->query($updateQuery) == TRUE;

    $query = "INSERT INTO tbconvos (friend1_id, friend2_id) VALUES ('$user_id', '$friend_id');";
    $res = mysqli_query($mysqli, $query) == TRUE;
    

    // $friendsquery = "SELECT * FROM tbfriends WHERE user_id = '$friend_id'";
	// $friendsres= $mysqli->query($friendsquery);
    // while($friends = mysqli_fetch_array($friendsres))
    // {
    //     $fruser_id = $friends['user_id'];
    //     $friendsuquery = "SELECT * FROM tbusers WHERE user_id = '$fruser_id'";
	//     $friendsures= $mysqli->query($friendsuquery);
    //     if($fu = mysqli_fetch_array($friendsures))
    //     {
    //         echo "<li class='list-group-item'><a href='profile.php?user_id=". $fruser_id ."'> ". $fu['name']." " . $fu['surname']."</a></li>"
    //     }
        
    // }
    
   
    
}
else
{
    $bail = "DELETE FROM tbfriends WHERE (friend1_id = '$friend_id' AND friend2_id = '$user_id') OR (friend1_id = '$user_id' AND friend2_id = '$friend_id')";
    $bailed = mysqli_query($mysqli, $bail) == TRUE;
}


?>