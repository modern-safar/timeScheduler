<?php 
include('conn.php');

if(isset($_REQUEST['uuname']) and isset($_REQUEST['upassword'])){
    $result = $conn->query("SELECT * FROM userDetails WHERE userName = '$_REQUEST[uuname]' and password = '$_REQUEST[upassword]' ");
	if($result -> num_rows > 0)
	{
		while($row = $result->fetch_assoc())
		{
            if($row['status'] === 'inActive'){
                echo "3";
                exit();
            }

			if($row['userName'] == $_REQUEST['uuname'] and $row['password'] == $_REQUEST['upassword'])
			{
				session_start();
				$_SESSION['user'] = $row['userId'];
				echo "1";
				exit();
			}
		}
	}
	else
	{
		echo "2";
	}
}

elseif(isset($_REQUEST['auname']) and isset($_REQUEST['apassword'])){
    $result = $conn->query("SELECT * FROM adminDetails WHERE username = '$_REQUEST[auname]' and password = '$_REQUEST[apassword]' ");
	if($result -> num_rows > 0)
	{
		while($row = $result->fetch_assoc())
		{
			session_start();
			$_SESSION['admin'] = $row['adminId'];
			echo "1";
			exit();
			

		}
	}
	else
	{
		echo "2";
	}
}

elseif(isset($_REQUEST['ulogout'])){
    session_start();
    unset($_SESSION['user']);
	echo "1";
}

elseif(isset($_REQUEST['alogout'])){
    session_start();
    unset($_SESSION['admin']);
	echo "1";
}

elseif(isset($_REQUEST['aoldP']) and isset($_REQUEST['anewP'])){
    session_start();
	$result = $conn->query("SELECT * FROM adminDetails WHERE adminId = '$_SESSION[admin]' ");
	if($result -> num_rows > 0){
		while($row = $result->fetch_assoc()){
			if($row['password'] == $_REQUEST['aoldP']){
				$sql = "UPDATE adminDetails SET password = '$_REQUEST[anewP]' WHERE adminId = '$_SESSION[admin]' ";
				if($conn->query($sql)){
					echo "1";
				}else{
					echo "2";
				}
			}else{
				echo "3";
			}
		}
	}else{
		echo "4";
	}
}

elseif(isset($_REQUEST['uoldP']) and isset($_REQUEST['unewP'])){
    session_start();
	$result = $conn->query("SELECT * FROM userDetails WHERE userId = '$_SESSION[user]' ");
	if($result -> num_rows > 0){
		while($row = $result->fetch_assoc()){
			if($row['password'] == $_REQUEST['uoldP']){
				$sql = "UPDATE userDetails SET password = '$_REQUEST[unewP]' WHERE userId = '$_SESSION[user]' ";
				if($conn->query($sql)){
					echo "1";
				}else{
					echo "2";
				}
			}else{
				echo "3";
			}
		}
	}else{
		echo "4";
	}
}

elseif(isset($_REQUEST['blockUser'])){
    $result = $conn->query("SELECT * FROM userDetails WHERE userId = '$_REQUEST[blockUser]' ");
	if($result -> num_rows > 0){
		while($row = $result->fetch_assoc()){
            $status = "";
            if($row['status'] === 'active'){
                $status = "inActive";
            }else{
                $status = "active";
            }
			$sql = "UPDATE userDetails SET status = '$status' WHERE userId = '$_REQUEST[blockUser]' ";
            if($conn->query($sql)){
                echo "1";
            }else{
                echo "2";
            }
		}
	}else{
		echo "4";
    }
}

elseif(isset($_REQUEST['etitle']) and isset($_REQUEST['edesc']) and isset($_REQUEST['edateAndTime']) and isset($_REQUEST['eredirectLink'])){
    session_start();
    $characters = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz';
    $charactersLength = strlen($characters);
    $nid = '';
    for($i = 0; $i < 15; $i++){
        $nid .= $characters[rand(0, $charactersLength - 1)];
    }
    $title = $_REQUEST['etitle'];
    $desc = $_REQUEST['edesc'];
    $date = $_REQUEST['edateAndTime'];
    $uid = $_SESSION['user'];
    $eventLink = $_REQUEST['eredirectLink'];

    $sql = "INSERT INTO notificationDetails(notifyId,notifyTitle,notifyMessage,userId,notifyTime,eventLink) VALUES('$nid','$title','$desc','$uid','$date','$eventLink')";
    if($conn->query($sql)){
        echo "1";
        exit();
    }else{
        echo "2".mysqli_error($conn);
        exit();
    }
}

elseif(isset($_REQUEST['updateEvent'])){
    session_start();
    $_SESSION['eventId'] = $_REQUEST['updateEvent'];
    echo "1";
}

elseif(isset($_REQUEST['deleteEvent'])){
    session_start();
    $delId = $_REQUEST['deleteEvent'];
    $sql = "DELETE FROM notificationDetails WHERE notifyId = '$delId' ";
    if($conn->query($sql)){
        echo "1";
        exit();
    }else{
        echo "2";
        exit();
    }
}

elseif(isset($_REQUEST['uetitle']) and isset($_REQUEST['uedesc']) and isset($_REQUEST['uedateAndTime']) and isset($_REQUEST['ueredirectLink'])){
    session_start();
    $sql = "UPDATE notificationDetails SET notifyTitle = '$_REQUEST[uetitle]' , notifyMessage = '$_REQUEST[uedesc]' , notifyTime = '$_REQUEST[uedateAndTime]', eventLink = '$_REQUEST[ueredirectLink]' WHERE notifyId = '$_SESSION[eventId]' ";
    if($conn->query($sql)){
        echo "1";
    }else{
        echo "2";
    }
}

elseif(isset($_REQUEST['getAllNotification'])){
    $json = array();
    $result = $conn->query("SELECT * FROM notificationDetails ");
	if($result -> num_rows > 0){
		while($row = $result->fetch_assoc()){
            $item = array();
            $item['dateAndTime'] = $row['notifyTime'];
            $item['notifyId'] = $row['notifyId'];
            $json[] = $item;
		}
        print json_encode($json);
        
	}else{
		echo "2";
	}
}

elseif(isset($_REQUEST['getData'])){
    $json = array();
    $result = $conn->query("SELECT * FROM notificationDetails WHERE notifyId = '$_REQUEST[getData]' ");
	if($result -> num_rows > 0){
		while($row = $result->fetch_assoc()){
            $item = array();
            $item['title'] = $row['notifyTitle'];
            $item['desc'] = $row['notifyMessage'];
            $item['eventLink'] = $row['eventLink'];
            $json[] = $item;
		}
        print json_encode($json);
        
	}else{
		echo "2";
	}
}
?>