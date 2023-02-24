<?php
	session_start();
	include('conn.php');
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
    </head>
    <form method="POST" action="register.php" enctype="multipart/form-data">
    <body>
        <div w3-include-html="navbar.html"></div>
        <div class="container my-3 pt-4">
            <div class="row">
                <div class="col-sm-12 col-md-12 col-lg-2 col-xl-2"></div>
                <div class="col-sm-12 col-md-12 col-lg-8 col-xl-8 p-5 shadow-lg p-3 mb-5 bg-white rounded">
                    <h3 class="text-primary text-center">REGISTRATION </h3>
                    <br>
                    <div class="row">
                        <div class="col-sm-12 col-md-12 col-lg-6 col-xl-6">
                            <label><span class="text-danger">*</span> First Name</label><br>
                            <input type="text" class="form-control" placeholder="Enter First Name" name="firstName" required />
                        </div>
                        <div class="col-sm-12 col-md-12 col-lg-6 col-xl-6">
                            <label><span class="text-danger">*</span> Last Name</label><br>
                            <input type="text" class="form-control" placeholder="Enter Last Name" name="lastName" />
                        </div>
                    </div>
                    <div class="row pt-3">
                        <div class="col-sm-12 col-md-12 col-lg-6 col-xl-6">
                            <label><span class="text-danger">*</span> Username</label><br>
                            <input type="text" class="form-control" placeholder="Enter Username" name="username"  />
                        </div>
                        <div class="col-sm-12 col-md-12 col-lg-6 col-xl-6">
                            <label><span class="text-danger">*</span> Password</label><br>
                            <input type="password" class="form-control" placeholder="Enter Password" name="password" />
                        </div>
                    </div>
                    <div class="row pt-3">
                        <div class="col-sm-12 col-md-12 col-lg-6 col-xl-6">
                            <label>Email Address</label><br>
                            <input type="email" class="form-control" placeholder="Email Address" name="email" />
                        </div>
                        <div class="col-sm-12 col-md-12 col-lg-6 col-xl-6">
                            <label>Contact Number</label><br>
                            <input type="number" class="form-control" placeholder="Enter Contact Number" name="phno" />
                        </div>
                    </div>
                    <div class="row pt-3">
                        <div class="col-sm-12 col-md-12 col-lg-6 col-xl-6">
                            <div class="form-group">
                                <label><span class="text-danger">*</span> Gender</label>
                                <input  type="radio" name="gender" value="Male" /> Male
                                <input type="radio" name="gender" value="Female" /> Female
                            </div>
                        </div>
                        <div class="col-sm-12 col-md-12 col-lg-6 col-xl-6">
                            <div class="form-group">
                                <label for="exampleFormControlFile1">Profile Picture</label>
                                <input type="file" class="form-control-file" accept="image/*" name="userImage" />
                            </div>
                        </div>
                    </div>
                    <div class="text-center pt-4">
                        <button class="btn btn-outline-primary" name="register">REGISTER</button><br><br>
                        <h6>Already have an account? <a href="userLogin.php">Login here</a></h6>
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
                $password = $_POST['password'];
                $email = $_POST['email'];
                $phno = $_POST['phno'];
                $gender = $_POST['gender'];
                $imgPath = "";

                $characters = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz';
                $charactersLength = strlen($characters);
                $uid = '';
                for($i = 0; $i < 15; $i++){
                    $uid .= $characters[rand(0, $charactersLength - 1)];
                }

                if($fname == '' || $lname == '' || $username == '' || $password == '' || $gender == ''){
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

                    $sql = "INSERT INTO userDetails(userId,firstName,lastName,username,password,email,phno,gender,image) VALUES('$uid','$fname','$lname','$username','$password','$email','$phno','$gender','$imgPath')";
                    if($conn->query($sql)){
                        echo "<script type='text/javascript'>alert('Registered Successfully'); window.location = 'userLogin.php'</script>";
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

    <script>
        w3.includeHTML()
    </script>
</html>