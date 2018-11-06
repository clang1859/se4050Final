<?php

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

	echo 'Connected successfully'."<br>";

	$sql = "SELECT userName, password FROM Users WHERE userName = \"$username\"";
	$result = mysqli_query($conn, $sql);



	if (mysqli_num_rows($result) > 0) {


	    // output data of each row
	    while($row = mysqli_fetch_assoc($result)) {
            if ($username==$row["userName"] && $password==$row["password"])
            {
                echo "logged in successful yay";
            }
            else
            {
                echo "login not successful. retry";
            }
	    }
	} else {
	    echo "0 results";
	}

	mysqli_close($conn);
?>