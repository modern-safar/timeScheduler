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
    <body>
        <div w3-include-html="navbar.html"></div>
        <div class="container my-3 pt-5">
            <div class="row">
                <div class="col-sm-12 col-md-12 col-lg-3 col-xl-3"></div>
                <div class="col-sm-12 col-md-12 col-lg-6 col-xl-6 p-5 shadow-lg p-3 mb-5 bg-white rounded">
                    <h3 class="text-primary text-center">ADMIN LOGIN</h3>
                    <br>
                    <label><span class="text-danger">*</span> Username</label><br>
                    <input type="text" class="form-control" placeholder="Enter Username" id="username" /><br>
                    <label><span class="text-danger">*</span> Password</label><br>
                    <input type="text" class="form-control" placeholder="Enter Password" id="password" /><br>
                    <div class="text-center">
                        <button class="btn btn-outline-primary" onclick="login()">LOGIN</button><br><br>
                        <h6>Don't you have an account? <a href="register.php">Register here</a></h6>
                    </div>
                </div>
                <div class="col-sm-12 col-md-12 col-lg-3 col-xl-3"></div>
            </div>
        </div>
    </body>

    <script>
        w3.includeHTML()

        function login(){
            let name = document.getElementById("username").value
            let password = document.getElementById("password").value

            if(name === '' || password === ''){
                alert("Please provide requird credentials")
            }else{
                var obj = new XMLHttpRequest();
				obj.onreadystatechange = function()
				{
					if(this.readyState == 4 && this.status == 200)
					{
						var response = this.responseText;
						if(response == '1'){
							window.location = "adminHome.php";
						}else if(response == '2'){
							alert("Incorrect Username or Password !!!");
						}
					}
				};
				obj.open("POST","./ajax.php");
				obj.setRequestHeader("Content-type","application/x-www-form-urlencoded");
				obj.send("auname="+name+"&apassword="+password);
            }
        }
    </script>
</html>