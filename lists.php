<?php
	require "database.php";
	require "nav.html";
    session_start(); 
    $user_id = $_SESSION['user'];

    $addlist_id = isset($_GET["list_id"]) ? $_GET["list_id"] : null;
    $addevent_id= isset($_GET["event_id"]) ? $_GET["event_id"] : null;

    if($addlist_id != null && $addevent_id != null)
    {
        $inlist = false;
        $listDuplicatesQuery = "SELECT * FROM tblistevents WHERE list_id = '$addlist_id'";
	    $listDuplicatesResult= $mysqli->query($listDuplicatesQuery);
        while($listDuplicates = mysqli_fetch_array($listDuplicatesResult))
        {
            if($listDuplicates['event_id'] == $addevent_id)
            {
                $inlist = true;
                break;
            }

        }

        if($inlist)
        {
            echo "<div class='alert alert-danger ' role='alert'>
                    That event is already in that list
                    
                </div>";
        }
        else
        {
            $addToListQ = "INSERT INTO tblistevents (list_id, event_id) VALUES ('$addlist_id', '$addevent_id');";
            $addToListR = mysqli_query($mysqli, $addToListQ) == TRUE;
            echo "<div class='alert alert-success ' role='alert'>
                    Event successfully added to the list
                    
                </div>";
        }
    }


    
    $listName = isset($_POST["listName"]) ? $_POST["listName"] : null;
    $listDescription = isset($_POST["listDescription"]) ? $_POST["listDescription"] : null;
    $events = isset($_POST["events"]) ? $_POST["events"] : null;

    if($listName != null && $listDescription != null && $events != null)
    {
        $newListQ = "INSERT INTO tblists (user_id, list_name, list_description) VALUES ('$user_id', '$listName', '$listDescription');";
	    $newListR = mysqli_query($mysqli, $newListQ) == TRUE;

        $listIDQ = "SELECT * FROM tblists WHERE user_id = '$user_id' AND list_name = '$listName'";
	    $listIDR= $mysqli->query($listIDQ);
        if($listID = mysqli_fetch_array($listIDR))
        {
            $list = $listID['list_id'];
            foreach($events as $e)
            {
                $addEventtoListQ = "INSERT INTO tblistevents (list_id, event_id) VALUES ('$list', '$e');";
                $addEventtoListR = mysqli_query($mysqli, $addEventtoListQ) == TRUE;
            }
        }

        echo "<div class='alert alert-success ' role='alert'>
        <strong>Good Stuff! </strong>List Added!
        
      </div>";
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

            if($list_id != null)
            {
                echo "<p class='lead'>Here are the lists you've made: <a class='btn profile-edit-btn' href='newlist.php'>New List</a></p>

                <div class='row'>";
                    $cardColours = array("listheader1", "listheader2", "listheader3");
                    $count = 0;
                    $query = "SELECT * FROM tblists WHERE user_id = '$user_id'";
                    $res= $mysqli->query($query);
                    while($row = mysqli_fetch_array($res))
                    {
                        if($count == 3)
                        {
                            $count = 0;
                        }
                        $list_id = $row['list_id'];
                        $name = $row['list_name'];
                        $description = $row['list_description'];

                        echo "<div class='col-4'>
                        <div class='card border-light shadow mb-5 rounded' id='". $cardColours[$count]."'>
                            <div class='card-body'>
                                <p><strong>". $name ." </strong></p>
                                <p>". $description."</p>
                                <div  class='list-group scroll'>";

                                $queryEv = "SELECT * FROM tblistevents WHERE list_id = '$list_id'";
                                $resEv= $mysqli->query($queryEv);
                                while($Ev = mysqli_fetch_array($resEv))
                                {
                                    $Ev_id = $Ev['event_id'];
                                    $qEv = "SELECT * FROM tbevents WHERE event_id = '$Ev_id'";
                                    $rEv= $mysqli->query($qEv);
                                    while($Event = mysqli_fetch_array($rEv))
                                    {
                                        echo "<a href='event.php?event_id=". $Ev_id ."' class='list-group-item list-group-item-action flex-column align-items-start'>
                                            <div  class='d-flex w-100 justify-content-between'>
                                            <h5 class='mb-1'>". $Event['name'] ."</h5>
                                            <small>". $Event['date'] ."</small>
                                            </div>
                                            <p class='mb-1'>". $Event['description'] ."</p>
                                            <small>". $Event['location'] ."</small>
                                        </a>";
                                    }
                                }

                        
                        echo "
                        </div>
                        </div>
                        </div>
                        </div>";  
                        $count++;
                    }
                    
                    
                echo "</div>";
            }
            else
            {
                echo "<p class='lead'>Looks like you have no lists of events yet! <a class='btn profile-edit-btn' href='newlist.php'>New List</a></p>";
            }
        ?>
    
    </div>
</body>
</html>