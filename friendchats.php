<?php
require "database.php";

$user_id = $_POST['user_id'];
$friend_id = $_POST['friend'];

$queryConvo = "SELECT * FROM tbconvos WHERE (friend1_id = '$user_id' AND friend2_id = '$friend_id') OR (friend1_id = '$friend_id' AND friend2_id = '$user_id')";
$resConvo= $mysqli->query($queryConvo);
if($convos = mysqli_fetch_array($resConvo)){

    $convo_id = $convos['convo_id'];
    $queryChats = "SELECT * FROM tbmessages WHERE convo_id ='$convo_id' ORDER BY message_date DESC";
    $resChats= $mysqli->query($queryChats);
    while($chats = mysqli_fetch_array($resChats))
    {
        if($chats['message_sender'] == $friend_id)
        {
            echo "<div class='col-4' id='friendmessage'>" . $chats['message'] ."</div>";
        }
        else
        {
            echo "<div class='col-4' id='mymessage'>" . $chats['message'] ."</div>";
        }
    }
}
else
{
    $queryR = "INSERT INTO tbreviews (event_id, user_id, stars, comment) VALUES ('$event_id', '$reviewUser_id', '$rate', '$eventAttendReview');";
	$resR = mysqli_query($mysqli, $queryR) == TRUE;
}


?>