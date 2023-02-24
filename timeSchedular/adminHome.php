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
        </script>
    </head>
    <body>
        <nav class="navbar navbar-expand-lg bg-primary">
            <img src="titlecon.png" alt="title" style="width:3%; height: 3%; margin-left: 3%" /> 
            <h3 class="text-white">&nbsp;&nbsp;Time Schedular</h3>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse links2" id="navbarNav">
                <ul class="navbar-nav ">
                    <li class="nav-item active">
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

        <div class="container my-4 p-3">
            <?php
                echo "<table class='table table-hover text-center'><th>UserId</th><th>Title</th><th>Description</th><th>Scheduled Time</th><th>Status</th>";
                $result = $conn->query("SELECT * FROM notificationDetails ");
                if($result -> num_rows > 0){
                    $i = 1;
                    while($row = $result->fetch_assoc()){
                        echo "<tr class='text-center'>
                            <td>".$row['userId']."</td>
                            <td>".$row['notifyTitle']."</td>
                            <td>".$row['notifyMessage']."</td>
                            <td>".$row['notifyTime']."</td>
                            <td>".$row['status']."</td>
                        </tr>";
                        $i += 1;
                    }
                }
                echo "</table>";
            ?>
        </div>
    </body>
</html>