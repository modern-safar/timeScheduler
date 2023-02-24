<?php
	session_start();
	include('conn.php');
	if(!isset($_SESSION['admin']))
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
        <script src="./notify.js"></script>
        <style type="text/css">
            ul li a{
                font-size: 18px;
            }
            .links2{
                margin-left: 45%;
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
				obj.send("alogout=1");
            }

            function changePassword(){
                let oldP = document.getElementById('old').value
                let newP = document.getElementById('new').value
                let confirmP = document.getElementById('confirm').value

                if(oldP === '' || newP === '' || confirmP == '')
                    alert("Please fill all the required fields")
                else if(newP !== confirmP)
                    alert("Confirm password not matching")
                else{
                    var obj = new XMLHttpRequest();
                    obj.onreadystatechange = function()
                    {
                        if(this.readyState == 4 && this.status == 200)
                        {
                            var response = this.responseText;
                            if(response == '1')
                            {
                                alert("Password Changed Successfully !!!");
                                document.getElementById("old").value = ''
                                document.getElementById("new").value = ''
                                document.getElementById("confirm").value = ''
                            }
                            else if(response == '2')
                            {
                                alert("Updation Error !!!");
                            }
                            else if(response == '3')
                            {
                                alert("Incorect Old Password !!!");
                            }
                            else if(response == '4')
                            {
                                alert("No User Found !!!");
                            }
                        }
                    };
                    obj.open("POST","./ajax.php");
                    obj.setRequestHeader("Content-type","application/x-www-form-urlencoded");
                    obj.send("aoldP="+oldP+"&anewP="+newP);
                }
            }
        </script>
    </head>
    <body>
        <nav class="navbar navbar-expand-lg bg-primary">
            <img src="titlelcon.png" alt="title" style="width:3%; height: 3%; margin-left: 3%" /> 
            <h3 class="text-white">&nbsp;&nbsp;Time Schedular</h3>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse links2" id="navbarNav">
                <ul class="navbar-nav ">
                    <li class="nav-item ">
                        <a class="nav-link font-weight-bold text-white" href="adminHome.php">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link font-weight-bold text-white" href="usersList.php">Users</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link font-weight-bold text-white" href="adminChangePassword.php">Change Password</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link font-weight-bold text-white" href="#" onclick="logout()">Logout</a>
                    </li>
                </ul>
            </div>
        </nav>

        <div class="container my-3 pt-5">
            <div class="row">
                <div class="col-sm-12 col-md-12 col-lg-3 col-xl-3"></div>
                <div class="col-sm-12 col-md-12 col-lg-6 col-xl-6 p-5 shadow-lg p-3 mb-5 bg-white rounded">
                    <h4 class="text-center text-primary">Change Password</h4><br>
                    <label><span class="text-danger">*</span> Old Password</label><br>
                    <input type="text" class="form-control" placeholder="Enter Old Username" id="old" /><br>
                    <label><span class="text-danger">*</span> New Password</label><br>
                    <input type="password" class="form-control" placeholder="Enter New Password" id="new" /><br>
                    <label><span class="text-danger">*</span> Confirm Password</label><br>
                    <input type="passwprd" class="form-control" placeholder="ReEnter New Password" id="confirm" /><br>
                    <div class="text-center">
                        <button class="btn btn-outline-primary" onclick="changePassword()">Change Password</button><br><br>
                    </div>
                </div>
                <div class="col-sm-12 col-md-12 col-lg-3 col-xl-3"></div>
            </div>
        </div>
    </body>
</html>