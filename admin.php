<?php
	require "database.php";
	require "nav.html";
	
	session_start();
    $user_id = $_SESSION['user'];
    $user_type = $_SESSION['user_type'];

    $newCat = isset($_POST["category"]) ? $_POST["category"] : null;

    if($newCat)
    {
        $query = "INSERT INTO tbcategory (category) VALUES ('$newCat');";
		$res = mysqli_query($mysqli, $query) == TRUE;
        echo "<div class='alert alert-success ' role='alert'>
                                    Category Added Successfully
                                    
                                </div>";
    }

    $newNormie = isset($_GET["normie"]) ? $_GET["normie"] : null;
    $newAdmin = isset($_GET["admin"]) ? $_GET["admin"] : null;
    $deleteCat = isset($_GET["deleteCat"]) ? $_GET["deleteCat"] : null;

    if($newNormie)
    {
        $updateQuery = "UPDATE tbusers SET user_type = 'normie' WHERE user_id = '$newNormie'";
        $updateResult= $mysqli->query($updateQuery) == TRUE;
        echo "<div class='alert alert-success ' role='alert'>
                                    User Role Changed to Normie Successfully
                                    
                                </div>";
    }
    
    if($newAdmin)
    {
        $updateQuery = "UPDATE tbusers SET user_type = 'admin' WHERE user_id = '$newAdmin'";
        $updateResult= $mysqli->query($updateQuery) == TRUE;
        echo "<div class='alert alert-success ' role='alert'>
        User Role Changed to Admin Successfully
                                    
                                </div>";
    }

    if($deleteCat)
    {
        $bail = "DELETE FROM tbcategory WHERE category = '$deleteCat'";
		$bailed = mysqli_query($mysqli, $bail) == TRUE;
        echo "<div class='alert alert-success ' role='alert'>
                                    Category Deleted Successfully
                                    
                                </div>";
    }

    ?>

<!DOCTYPE html>
<html>
<head>
	<title>EventScape Delete Profile</title>
	<meta charset="utf-8" />
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/css/bootstrap.min.css" integrity="sha384-KyZXEAg3QhqLMpG8r+8fhAXLRk2vvoC2f3B09zVXn8CA5QIVfZOJ3BCsw2P0p/We" crossorigin="anonymous">
	<link rel="stylesheet" type="text/css" href="style.css" />
	<meta charset="utf-8" />
	<meta name="author" content="Morgan Else">
    <script src="https://kit.fontawesome.com/d183f81595.js" crossorigin="anonymous"></script>
	<script src="https://code.jquery.com/jquery-3.6.1.js" integrity="sha256-3zlB5s2uwoUzrXK3BT7AX3FyvojsraNFxCc2vC/7pNI=" crossorigin="anonymous"></script>
	<?php require "favicon.html"; ?>
</head>
<body>

	<div class="container">
        <div class="row">
            <div class='col-lg-6 col-md-12'>
                <div class="row">
                <div class='col-lg-12 col-md-12'>
                        <div class='card border-light shadow mb-5 rounded' id='privateEvents'>
                            <div class='card-body'>
                                <p  class='lead'>Welcome to the Admin Dashboard! Here you can see all the users, events and categories on EventScape and manage them however you like! Be careful though, with great power...</p>
                                
                            </div>
                        </div>
                    </div>
                    <div class='col-lg-12 col-md-12'>
                        <div class='card border-light shadow mb-5 rounded'>
                            <div class='card-body'>
                                <p class='lead'>Users:</p>
                                <div  class='list-group scroll'>
                                <?php 
                                    $query = "SELECT * FROM tbusers WHERE user_id != '$user_id'";
                                    $res= $mysqli->query($query);
                                    while($row = mysqli_fetch_array($res))
                                    {
                                        echo "
                                        
                                        <a  href='profile.php?user_id=". $row['user_id'] ."' class='list-group-item list-group-item-action' aria-current='true'>
                                            <div class='d-flex w-100 justify-content-between'>
                                            <h5 class='mb-1'>". $row['name'] ." ". $row['surname'] ."</h5>
                                            <small>". $row['user_type'] ."</small>
                                            </div>
                                        </a>
                                        
                                        
                                        ";
                                    }
                                ?>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class='col-lg-12 col-md-12'>
                        <div class='card border-light shadow mb-5 rounded' id='publicEvents'>
                            <div class='card-body'>
                            <div class='d-flex w-100 justify-content-between'>
                                <p class='lead'>Categories: </p>
                                <p id="addCat" >Add a Category <i class='fa-solid fa-plus'></i></p>
                            </div>
                                <ul id='catlist' class='list-group scroll'>
                                <?php 
                                    $query = "SELECT * FROM tbcategory";
                                    $res= $mysqli->query($query);
                                    while($row = mysqli_fetch_array($res))
                                    {
                                        echo "
                                        <li id='adminlist' class='list-group-item'>
                                            <div  class='d-flex w-100 justify-content-between'>
                                                <h5>" . $row['category'] ."</h5>
                                                <a class='btn btn-dark normie' id='adminButton' style='right: 0;' href='admin.php?deleteCat=". $row['category'] ."'><i class='fa-solid fa-trash'></i></a>
                                            </div>
                                        </li>
                                        ";
                                    }
                                ?>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div> 
            <div class='col-lg-6 col-md-12'>
                <div class='row'>
                    <div class='col-lg-12 col-md-12'>
                        <div class='card border-light shadow mb-5 rounded' >
                            <div class='card-body'>
                                <p class='lead'>Events:</p>
                                <div  class='list-group scroll'>
                                    <?php 
                                        $query = "SELECT * FROM tbevents ORDER BY date DESC";
                                        $res= $mysqli->query($query);
                                        while($row = mysqli_fetch_array($res))
                                        {
                                            echo "
                                            <a  href='event.php?event_id=". $row['event_id'] ."' class='list-group-item list-group-item-action' aria-current='true'>
                                                <div class='d-flex w-100 justify-content-between'>
                                                <h5 class='mb-1'>". $row['name'] ."</h5>
                                                <small>". $row['date'] ."</small>
                                                </div>
                                            </a>";
                                        }
                                    ?>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class='col-lg-12 col-md-12'>
                        <div class='card border-light shadow mb-5 rounded' id='newEvent'>
                            <div class='card-body'>
                                <p class='lead'>Manage User Roles:</p>
                                <ul  class='list-group scroll'>
                                    <?php 
                                        $query = "SELECT * FROM tbusers WHERE user_id != '$user_id'";
                                        $res= $mysqli->query($query);
                                        while($row = mysqli_fetch_array($res))
                                        {
                                            
                                            if($row['user_type'] == "admin")
                                            {
                                                echo "
                                                <li class='list-group-item'>
                                                <div id='adminlist' class='d-flex w-100 justify-content-between'>
                                                    <h5>" . $row['name'] ." " . $row['surname'] ."</h5>
                                                    <a class='btn btn-dark normie' id='adminButton' style='right: 0;' href='admin.php?normie=". $row['user_id'] ."'>Make Normie <i class='fa-solid fa-user'></i></a>
                                                    </div>
                                                </li>";
                                            }
                                            else
                                            {
                                                echo "
                                                <li class='list-group-item'>
                                                <div id='adminlist' class='d-flex w-100 justify-content-between'>
                                                    <h5>" . $row['name'] ." " . $row['surname'] ."</h5>
                                                    <a class='btn btn-dark normie' id='adminButton' style='right: 0;' href='admin.php?admin=". $row['user_id'] ."'>Make Admin <i class='fa-solid fa-crown'></i></a>
                                                    </div>
                                                </li>";
                                                
                                            }
                                        }
                                    ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div> 
            </div>
        </div>

        
		
    </div>
</body>
<script>
    $('p#addCat').on('click', function() {

        let catForm = `<form class='row row-cols-lg-auto  align-items-center' action='admin.php' method='POST' enctype='multipart/form-data'>
                            <div class="col-6">
								<label for='category'>New Category:</label><br>
								<input type='text' class='form-control' name='category' /><br>
                            </div>
                            <div class="col-6">
                                <input type='submit' class='btn btn-dark' id='adminButton' value='Add Category' name='submit' />
                            </div>
                        </form>`;
        $('#catlist').append(catForm);
    });

</script>
</html>