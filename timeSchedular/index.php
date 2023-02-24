<?php
	session_start();
	include('conn.php');
?>
<html>
    <head>
        <title>Time Schedular</title>
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
            .links{
                margin-left: 55%;
            }.banner {
		  	position: relative; /* Maximum width */
		  	margin: 0 auto; /* Center it */
            }
            .banner .content {
                position: absolute; /* Position the background text */
                top: 0; /* At the bottom. Use top:0 to append it to the top */
                background: rgb(0, 0, 0); /* Fallback color */
                background: rgba(0, 0, 0, 0.5); /* Black background with 0.5 opacity */
                color: #f1f1f1; /* Grey text */
                width: 100%; /* Full width */
                padding: 180px; /* Some padding */
                height: 100%;
            }
        </style>
    </head>
    <body>
        <div w3-include-html="navbar.html"></div>
        <div class="banner">
            <img src="bmg.jpg" alt="Notebook" style="width:100%; height: 100%">
            <div class="content">
                <h1>Welcome!!!</h1>
                <h5>"Schedule your events, and get a notifications." - Don't miss out<br>
                Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, 
                when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap 
                into electronic typesetting, remaining essentially unchanged.</h5>
            </div>
        </div>
    </body>
    <script>
        w3.includeHTML()
    </script>
</html>