<?php
	require "database.php";
	require "nav.html";
    session_start(); 

    
    
    $user_id = $_SESSION['user'];

    $query = "SELECT * FROM tbusers WHERE user_id = '$user_id'";
		$res= $mysqli->query($query);
		if($row = mysqli_fetch_array($res))
		{
			$userFullName = $row['name'] . " " . $row['surname'];
            $name = $row['name'];
            $surname = $row['surname'];
			$email = $row['email'];
			$password = $row['password'];
			$birthday = $row['birthday'];
			$relationship = $row['relationship_status'];
			$work = $row['work'];
			$bio = $row['bio'];
            $pronouns = $row['pronouns'];
            $image = "chilldog.jpg";

            $PPquery = "SELECT * FROM tbusergallery WHERE user_id = '$user_id'";
		    $PPres= $mysqli->query($PPquery);
            if($PP = mysqli_fetch_array($PPres))
            {
                $image = $PP['image_name'];
            }

            

		}

    $uname = isset($_POST["fname"]) ? $_POST["fname"] : $name;
	$usurname = isset($_POST["lname"]) ? $_POST["lname"] : $surname;
	$uemail = isset($_POST["email"]) ? $_POST["email"] : $email;
	$ubirthday = isset($_POST["date"]) ? $_POST["date"] : $birthday;
	$urelationship = isset($_POST["relationship"]) ? $_POST["relationship"] : $relationship;
	$uwork = isset($_POST["work"]) ? $_POST["work"] : $work;
    $profilePic = isset($_FILES["profilePic"]) ? $_FILES["profilePic"] : null;
	$ubio = isset($_POST["bio"]) ? $_POST["bio"] : $bio;
    $upronouns = isset($_POST["pronouns"]) ? $_POST["pronouns"] : $pronouns;
    
    $updateQuery = "UPDATE tbusers SET name = '$uname', surname = '$usurname', email = '$uemail', birthday = '$ubirthday', relationship_status = '$urelationship', work = '$uwork', bio = '$ubio', pronouns = '$upronouns' WHERE user_id = '$user_id'";
    $updateResult= $mysqli->query($updateQuery) == TRUE;
    

    if($profilePic != null)
    {
        
        $target_dir = "usergallery/";
		$target_file = $target_dir . basename($_FILES["profilePic"]["name"]);
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

		$allowed = array('jpeg', 'pjpeg', 'jpg', 'png');
		$filename = $_FILES["profilePic"]["name"];

        
            $doubleQuery = "SELECT * FROM tbusergallery WHERE user_id = '$user_id'";
            $doubleRes= $mysqli->query($doubleQuery);
            if($double = mysqli_fetch_array($doubleRes))
            {
                if($filename != $double['image_name'])
                {
                    $bailImg = "DELETE FROM tbusergallery WHERE user_id = '$user_id'";
                    $bailed = mysqli_query($mysqli, $bailImg) == TRUE;
    
                    if(in_array($imageFileType, $allowed) && $profilePic["size"] < 1048576 ){ 
                        if($profilePic["error"] > 0 ){
                            echo "Error: " . $profilePic["error"] . "<br/>";
                        }
                        else
                        {
                            
                                move_uploaded_file($profilePic["tmp_name"], "usergallery/" . $profilePic["name"]);
                                
    
                                $query = "INSERT INTO tbusergallery (user_id, image_name) VALUES ('$user_id', '$filename');";
                                $res = mysqli_query($mysqli, $query) == TRUE;

                                echo "<div class='alert alert-success ' role='alert'>
                                    Profile updated successfuly!
                                    
                                </div>";
                            
                        }
                    }
                }
            
            }
            else
            {
                if(in_array($imageFileType, $allowed) && $profilePic["size"] < 1048576 ){ 
                    if($profilePic["error"] > 0 ){
                        echo "Error: " . $profilePic["error"] . "<br/>";
                    }
                    else
                    {
                        
                            move_uploaded_file($profilePic["tmp_name"], "usergallery/" . $profilePic["name"]);
                            

                            $query = "INSERT INTO tbusergallery (user_id, image_name) VALUES ('$user_id', '$filename');";
                            $res = mysqli_query($mysqli, $query) == TRUE;

                            echo "<div class='alert alert-success ' role='alert'>
                                    Profile updated successfuly!
                                    
                                </div>";

                        
                    }
                }
            }
        
       
    }
        
   
    

    ?>

<!DOCTYPE html>
<html>
<head>
	<title>EventScape Edit Profile</title>
	<meta charset="utf-8" />
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/css/bootstrap.min.css" integrity="sha384-KyZXEAg3QhqLMpG8r+8fhAXLRk2vvoC2f3B09zVXn8CA5QIVfZOJ3BCsw2P0p/We" crossorigin="anonymous">
	<link rel="stylesheet" type="text/css" href="style.css" />
	<meta charset="utf-8" />
	<meta name="author" content="Morgan Else">
	<?php require "favicon.html"; ?>
</head>
<body>

	<div class="container">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="profile.php">Profile</a></li>
            <li class="breadcrumb-item active" aria-current="page">Edit Profile</li>
        </ol>
    </nav>
        <div class='card border-light shadow mb-5 rounded' id='newEvent'>
            <div class='card-body'>
            <h5 class='card-title'>Update Profile</h5>
            <?php echo "<form action='editprofile.php' method='POST' enctype='multipart/form-data'>
                    <div class='form-group'>
                        <div class='row'>
                            <div class='col-6 col-lg-4'>
                                <label for='regName'>First Name:</label>
                                <input type='text' id='regName' class='form-control' value='". $uname."'  name='fname' required>
                            </div>
                            <div class='col-6 col-lg-4'>
                                <label for='regSurname'>Last Name:</label>
                                <input type='text' id='regSurname' class='form-control' value='". $usurname ."' name='lname' required>
                            </div>
                            <div class='col-6 col-lg-4'>
                                <label for='regEmail'>Email Address:</label>
                                <input type='email' id='regEmail' class='form-control' value='". $uemail."' name='email' required>
                            </div>
                        </div>
                        <div class='row mt-3'>
                            <div class='col-6 col-lg-4'>
                                <label for='regBirthDate'>Date of Birth:</label>
                                <input type='date' id='regBirthDate' value='". $ubirthday ."' class='form-control' name='date' required>
                            </div>
                            <div class='col-6 col-lg-4'>
                                <label for='regRel'>Relationship Status:</label>
                                <input type='text' id='regRel' class='form-control' value='". $urelationship ."' name='relationship'>
                            </div>
                            <div class='col-6 col-lg-4'>
                                <label for='regWork'>Work:</label>
                                <input type='text' id='regWork' class='form-control' value='". $uwork ."' name='work'>
                            </div>
                        </div>
                        <div class='row mt-3'>
                            <div class='col-6 col-lg-4'>
                                <label for='profilePic'>New Profile Pic:</label>
                                <input type='file' class='form-control'  name='profilePic' id='profilePic' />
                            </div>
                            <div class='col-6 col-lg-4'>
                                <label for='regBio'>Bio:</label>
                                <input type='text' class='form-control' name='bio' id='regBio' value='". $ubio ."'>
                            </div>
                            <div class='col-6 col-lg-4'>
                                <label for='regPro'>Pronouns</label>
                                <input type='text' id='regPro' class='form-control' value='". $upronouns ."' name='pronouns'>
                            </div>
                        </div>"; ?>
                        <div class="row mt-3">
                            <div class="col-12">
                                <button type="submit" class="btn btn-dark">Update Info</i></button>
                            </div>
                        </div>
                    </div>
				</form>
			</div>
		</div>
    </div>
</body>
</html>