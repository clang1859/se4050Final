<?php
	if( isset($_POST['fName'])) {
   	    $username = ($_POST['fName']);
   	}

	if( isset($_POST['lName'])) {
   	    $username = ($_POST['lName']);
   	}

    if( isset($_POST['uname'])) {
   	    $username = ($_POST['uname']);
   	}
	
	if( isset($_POST['email'])) {
   	    $username = ($_POST['email']);
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

	$sql = "INSERT INTO Users (fName, lName, password, email, userName) VALUES (\"$fName\", \"$lName\", \"$uname\", \"$email\", \"$psw\")";
	$result = mysqli_query($conn, $sql);

	echo 'Registered successfully';

	mysqli_close($conn);
?>