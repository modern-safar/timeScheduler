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

            function block(id){
                let userId = document.getElementById(id).value
                let res = confirm("Are you sure, want to Block this user?")
                if(!res) return
                var obj = new XMLHttpRequest();
				obj.onreadystatechange = function()
				{
					if(this.readyState == 4 && this.status == 200)
					{
						var response = this.responseText;
						if(response == '1'){
							window.location = "usersList.php";
						}else{
                            alert("Failed to update user status")
                        }
					}
				};
				obj.open("POST","./ajax.php");
				obj.setRequestHeader("Content-type","application/x-www-form-urlencoded");
				obj.send("blockUser="+userId);
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
                echo "<table class='table table-hover text-center'><th>Image</th><th>First Name</th><th>Last Name</th><th>Gender</th><th>Email</th><th>Contact No</th><th>Status</th><th>Action</th>";
                $result = $conn->query("SELECT * FROM userDetails ");
                if($result -> num_rows > 0){
                    $i = 1;
                    while($row = $result->fetch_assoc()){
                        $status = "";
                        if($row['status'] === 'active'){
                            $status = "Block";
                        }else{
                            $status = "UnBlock";
                        }
                        echo "<tr class='text-center'>
                            <td><img src=".$row['image']." style='height: 90px; width: 90px;' class='rounded-circle mx-auto d-block' /></td>
                            <td>".$row['firstName']."</td>
                            <td>".$row['lastName']."</td>
                            <td>".$row['gender']."</td>
                            <td>".$row['email']."</td>
                            <td>".$row['phno']."</td>";
                            if($row['status'] === 'active'){
                                echo "<td class='text-success'>".$row['status']."</td>";
                            }else{
                                echo "<td class='text-danger'>".$row['status']."</td>";
                            }
                            echo "<td><button class='btn btn-outline-primary' value=".$row['userId']." id=".$i." onclick='block(".$i.")'>
                                ".$status."</button>
                            </td>
                        </tr>";
                        $i += 1;
                    }
                }
                echo "</table>";
            ?>
        </div>
    </body>
</html>