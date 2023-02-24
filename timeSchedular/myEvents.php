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

            function updateEvent(id){
                let value = document.getElementById(id).value
                var obj = new XMLHttpRequest();
				obj.onreadystatechange = function()
				{
					if(this.readyState == 4 && this.status == 200)
					{
						var response = this.responseText;
						if(response == '1'){
							window.location = "updateEvent.php";
						}
					}
				};
				obj.open("POST","./ajax.php");
				obj.setRequestHeader("Content-type","application/x-www-form-urlencoded");
				obj.send("updateEvent="+value);
            }

            function deleteEvent(id){
                let res = confirm("Are you sure, want to Delete Event?")
                if(!res) return
                let value = document.getElementById(id).value
                var obj = new XMLHttpRequest();
				obj.onreadystatechange = function()
				{
					if(this.readyState == 4 && this.status == 200)
					{
						var response = this.responseText;
						if(response == '1'){
							alert("Event deleted successfully")
                            window.location = 'myEvents.php'
						}else alert("Failed to delete event")
					}
				};
				obj.open("POST","./ajax.php");
				obj.setRequestHeader("Content-type","application/x-www-form-urlencoded");
				obj.send("deleteEvent="+value);
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

        <div class="container my-4 p-3">
            <?php
                
                $result = $conn->query("SELECT * FROM notificationDetails WHERE userId = '$_SESSION[user]' ");
                if($result -> num_rows > 0){
                    echo "<table class='table table-hover text-center'><th>Title</th><th>Description</th><th>Scheduled Time</th><th>Redirect Link</th><th>Action</th>";
                    $i = 1;
                    while($row = $result->fetch_assoc()){
                        echo "<tr class='text-center'>
                            <td>".$row['notifyTitle']."</td>
                            <td>".$row['notifyMessage']."</td>
                            <td>".$row['notifyTime']."</td>
                            <td>".$row['eventLink']."</td>
                            <td>
                                <button class='btn btn-outline-primary' value=".$row['notifyId']." id=".$i." onclick='updateEvent(".$i.")'>Update</button>
                                <button class='btn btn-outline-primary' value=".$row['notifyId']." id=".$i." onclick='deleteEvent(".$i.")'>Delete</button>
                            </td>
                        </tr>";
                        $i += 1;
                    }
                    echo "</table>";
                }else{
                    echo "<div class='text-center'><h3>No Events Found!!!!</h3></div>";
                }
                
            ?>
        </div>
    </body>
</html>