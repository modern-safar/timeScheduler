<?php
	session_start();
	include('conn.php');
	if(!isset($_SESSION['user']))
	{
		header('Location:index.php');
		exit();
	}
?>
<html>
    <title>Time Schedular</title>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
        <script src="https://www.w3schools.com/lib/w3.js"></script>
        <script src="./notify.js"></script>
        <style type="text/css">
            ul li a{
                font-size: 18px;
            }
            .links1{
                margin-left: 40%;
            }
        </style>
        <script>
            function logout(){
                let res = confirm("Are you sure, want to logout?")
                if(!res) return
                var obj = new XMLHttpRequest();
				obj.onreadystatechange = function()
				{
					if(this.readyState == 4 && this.status == 200)
					{
						var response = this.responseText;
						if(response == '1'){
							window.location = "index.php";
						}
					}
				};
				obj.open("POST","./ajax.php");
				obj.setRequestHeader("Content-type","application/x-www-form-urlencoded");
				obj.send("ulogout=1");
            }
        </script>
    </head>
    <form method="POST" action="profile.php" enctype="multipart/form-data">
    <body>
        <nav class="navbar navbar-expand-lg bg-primary">
            <img src="titlecon.png" alt="title" style="width:3%; height: 3%; margin-left: 3%" /> 
            <h3 class="text-white">&nbsp;&nbsp;Time Schedular</h3>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse links1" id="navbarNav">
                <ul class="navbar-nav ">
                    <li class="nav-item active">
                        <a class="nav-link font-weight-bold text-white" href="userHome.php">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link font-weight-bold text-white" href="myEvents.php">My Events</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link font-weight-bold text-white" href="profile.php">Profile</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link font-weight-bold text-white" href="userChangePassword.php">Change Password</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link font-weight-bold text-white" href="" onclick="logout()">Logout</a>
                    </li>
                </ul>
            </div>
        </nav>

        <?php
            $name = "";
            $email = "";
            $phno = "";
            $fname = "";
            $lname = "";
            $image = "";

            $result = $conn->query("SELECT * FROM userDetails WHERE userId = '$_SESSION[user]' ");
			if($result -> num_rows > 0){
				while($row = $result->fetch_assoc()){
					$fname = $row['firstName'];
					$lname = $row['lastName'];
					$name = $row['userName'];
					$email = $row['email'];
					$phno = $row['phno'];
					$image = $row['image'];
				}
			}
        ?>

        <div class="container my-3 pt-4">
            <div class="row">
                <div class="col-sm-12 col-md-12 col-lg-2 col-xl-2"></div>
                <div class="col-sm-12 col-md-12 col-lg-8 col-xl-8 p-5 shadow-lg p-3 mb-5 bg-white rounded">
                    <img src="<?php echo $image ?>" alt="userImage" class="rounded-circle mx-auto d-block" style="height: 150px; width: 150px;" />
                    <br>
                    <div class="row">
                        <div class="col-sm-12 col-md-12 col-lg-6 col-xl-6">
                            <label><span class="text-danger">*</span> First Name</label><br>
                            <input type="text" class="form-control" placeholder="Enter First Name" name="firstName" value=<?php echo $fname ?> />
                        </div>
                        <div class="col-sm-12 col-md-12 col-lg-6 col-xl-6">
                            <label><span class="text-danger">*</span> Last Name</label><br>
                            <input type="text" class="form-control" placeholder="Enter Last Name" name="lastName" value=<?php echo $lname ?> />
                        </div>
                    </div>
                    <div class="row pt-3">
                        <div class="col-sm-12 col-md-12 col-lg-6 col-xl-6">
                            <label><span class="text-danger">*</span> Username</label><br>
                            <input type="text" class="form-control" placeholder="Enter Username" name="username" value=<?php echo $name ?> />
                        </div>
                        <div class="col-sm-12 col-md-12 col-lg-6 col-xl-6">
                            <div class="form-group">
                                <label for="exampleFormControlFile1">Profile Picture</label>
                                <input type="file" class="form-control-file" accept="image/*" name="userImage" />
                            </div>
                        </div>
                    </div>
                    <div class="row pt-3">
                        <div class="col-sm-12 col-md-12 col-lg-6 col-xl-6">
                            <label>Email Address</label><br>
                            <input type="text" class="form-control" placeholder="Email Address" name="email" value=<?php echo $email ?> />
                        </div>
                        <div class="col-sm-12 col-md-12 col-lg-6 col-xl-6">
                            <label>Contact Number</label><br>
                            <input type="number" class="form-control" placeholder="Enter Contact Number" name="phno" value=<?php echo $phno ?> />
                        </div>
                    </div>
                    <div class="text-center pt-4">
                        <button class="btn btn-outline-primary" name="register">Update Profile</button><br>
                    </div>
                </div>
                <div class="col-sm-12 col-md-12 col-lg-2 col-xl-2"></div>
            </div>
        </div>

        <?php 
            if(isset($_POST['register'])){
                $formats = array("jpg","jpeg","png","PNG","svg");
                $fname = $_POST['firstName'];
                $lname = $_POST['lastName'];
                $username = $_POST['username'];
                $email = $_POST['email'];
                $phno = $_POST['phno'];
                $imgPath = $image;

                if($fname == '' || $lname == '' || $username == ''){
                    echo "<script>alert('Please do fill all the fields !!!!')</script>";
				    exit();
                }else{
                    if($phno !== ''){
                        if(strlen($phno) > 10 || strlen($phno) < 10){
                            echo "<script>alert('Invaid Phone Number')</script>";
                            exit();
                        }elseif(!is_numeric($phno)){
                            echo "<script>alert('Phone Number Should be in Numbers')</script>";
                            exit();
                        }
                    }
                    // if($email !== ''){
                    //     if(filter_var($email, FILTER_VALIDATE_EMAIL) && preg_match('/@.+\./', $email)){
                    //         echo "<script>alert('Invalid Email Address')</script>";
                    //         exit();
                    //     }
                    // }

                    if(!empty($_FILES["userImage"]["name"])){
                        $extension = pathinfo($_FILES["userImage"]["name"], PATHINFO_EXTENSION);
                        if(!in_array($extension, $formats)){
                            echo "<script type='text/javascript'>alert('User Image Not Supported! Suppoted File Formates are .jpg or .jpeg or .png or .PNG or .svg');</script>";
                            exit();
					    }

                        $imgid = uniqid();
                        $image = $imgid.".".$extension;
                        $imgPath = "assets/".$image;

                        if(!move_uploaded_file($_FILES['userImage']['tmp_name'], $imgPath)){
                            echo "<script type='text/javascript'>alert('Failed to Upload User Image ');</script>";
                            exit();
                        }
                    }

                    $sql = "UPDATE userDetails SET firstName = '$fname' , lastName = '$lname' , username = '$username' , email = '$email' , phno = '$phno' , image = '$imgPath' WHERE userId = '$_SESSION[user]' ";
                    if($conn->query($sql)){
                        echo "<script type='text/javascript'>alert('Profile Updated Successfully'); window.location = 'profile.php'</script>";
                        exit();
                    }
                    else{
                        echo "<script type='text/javascript'>alert('Unable to Insert A Record '".mysqli_error($conn).");</script>";
                        exit();
                    }
                }    
            }
        ?>
    </body>
    </form>
</html>