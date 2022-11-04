<?php
require "database.php";

$convo_id = $_POST['convo_id'];
$sender_id = $_POST['sender_id'];
$message = $_POST['message'];

if($message != null)
{
    $query = "INSERT INTO tbmessages (convo_id, sender_id, message) VALUES ('$convo_id', '$sender_id', '$message');";
    $res = mysqli_query($mysqli, $query) == TRUE;

    echo "<div class='col-3 offset-6' id='mymessage'>".$message."</div>";
}

?>