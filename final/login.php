<?php
	session_start();

  if(!isset($_SESSION['user_id'])){//No session
    if( isset($_POST['uname'])) {
   	    $username = ($_POST['uname']);
   	}

   	if( isset($_POST['psw'])) {
	   	$password = ($_POST['psw']);
   	}
	$dbhost = 'localhost';
	$dbuser = 'id6943004_group2';
	$dbpass = 'group2';
	$dbname = 'id6943004_advwebproject';
	$conn = mysqli_connect($dbhost,$dbuser,$dbpass,$dbname);

	if(! $conn ) {
		die('Could not connect: ' . mysqli_error());
	}

	$sql = "SELECT userName, password,userID FROM Users WHERE userName = '" .$username."'";
	$result = mysqli_query($conn, $sql);

	if (mysqli_num_rows($result) > 0) {
	    // output data of each row
	    while($row = mysqli_fetch_assoc($result)) {
            if ($username==$row["userName"] && $password==$row["password"])
            {
				$_SESSION['user_id']=$row['userID'];
                $_SESSION['username']=$row['userName'];
				if (isset ($_SESSION['url'])){
					$url = $_SESSION['url'];
				} else{
				$url = "storefront.html";
				}
                header('Location: '.$url);
            }
            else
            {
                echo "login not successful. retry";
            }
	    }
	} else {
	    echo "Register please!<br><br>";
		echo '<a href="cart.php"> Back to cart page('.$_SESSION['username'].')</a>';
	}
	mysqli_close($conn);
  }
  else{ //logged in, have the session
	  echo "You are already Logged as " .$_SESSION['username']."<br><br>";
	}
?>