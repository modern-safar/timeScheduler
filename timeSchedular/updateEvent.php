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

            function updateEvent(){
                let title = document.getElementById("title").value
                let desc = document.getElementById("desc").value
                let dateAndTime = document.getElementById("edateandtime").value
                let redirectLink = document.getElementById("redirectLink").value

                if(title === '' || dateAndTime === '')
                    alert("Please fill required fields")
                else{
                    var obj = new XMLHttpRequest();
                    obj.onreadystatechange = function()
                    {
                        if(this.readyState == 4 && this.status == 200)
                        {
                            var response = this.responseText;
                            if(response == '1')
                                alert("Event Updated successfully")
                            else alert("Failed to Update event!!!")

                            window.location = "myEvents.php"
                        }
                    };
                    obj.open("POST","./ajax.php");
                    obj.setRequestHeader("Content-type","application/x-www-form-urlencoded");
                    obj.send("uetitle="+title+"&uedesc="+desc+"&uedateAndTime="+dateAndTime+'&ueredirectLink='+redirectLink);
                }
            }

            $(function(){
                let dtToday = new Date();
                let month = dtToday.getMonth() + 1;
                let day = dtToday.getDate();
                let year = dtToday.getFullYear();
                if(month < 10) month = '0' + month.toString()
                if(day < 10) day = '0' + day.toString()
                
                let minDate = year + '-' + month + '-' + day + 'T12:00'
                $('#edateandtime').attr('min', minDate);
            }); 
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

        <?php
            $title = "";
            $desc = "";
            $dateAndTime = "";
            $redirectLink = "";

            $result = $conn->query("SELECT * FROM notificationDetails WHERE userId = '$_SESSION[user]' and notifyId = '$_SESSION[eventId]' ");
			if($result -> num_rows > 0){
				while($row = $result->fetch_assoc()){
					$title = $row['notifyTitle'];
					$desc = $row['notifyMessage'];
                    $redirectLink = $row['eventLink'];
					$dateAndTime = $row['notifyTime'];
                    $dateAndTime = str_replace(" ", "T", $dateAndTime);
				}
			}
        ?>

        <div class="container my-4 p-4">
            <div class="row">
                <div class="col-sm-12 col-md-12 col-lg-2 col-xl-2"></div>
                <div class="col-sm-12 col-md-12 col-lg-8 col-xl-8 p-5 shadow-lg p-3 mb-5 bg-white rounded">
                    <h3 class="text-primary text-center">Update Event</h3>
                    <br>
                    <div class="row">
                        <div class="col-sm-12 col-md-12 col-lg-6 col-xl-6">
                            <label><span class="text-danger">*</span> Event Title</label><br>
                            <input type="text" class="form-control" placeholder="Enter event title" id="title" value=<?php echo $title ?>  />
                        </div>
                        <div class="col-sm-12 col-md-12 col-lg-6 col-xl-6">
                            <label><span class="text-danger">*</span> Event Date and Time</label><br>
                            <input type="datetime-local" class="form-control" name="edateandtime" id="edateandtime" value=<?php echo $dateAndTime ?> />
                        </div>
                    </div>
                    <div class="row pt-3">
                        <div class="col-sm-12 col-md-12 col-lg-12 col-xl-12">
                            <label>Event Description</label><br>
                            <textarea class="form-control" rows="5" placeholder="Enet description here..." id="desc"><?php echo $desc ?></textarea>
                        </div>
                    </div>
                    <div class="row pt-3">
                        <div class="col-sm-12 col-md-12 col-lg-12 col-xl-12">
                            <label>Event Redirection Link</label><br>
                            <input id="redirectLink" class='form-control' placeholder='Redirection Link' value=<?php echo $redirectLink ?>></input>
                        </div>
                    </div>
                    <div class="text-center pt-4">
                        <button class="btn btn-outline-primary" onclick="updateEvent()">Update Event</button>
                    </div>
                </div>
                <div class="col-sm-12 col-md-12 col-lg-2 col-xl-2"></div>
            </div>
        </div>
    </body>
</html>