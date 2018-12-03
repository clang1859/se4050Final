<?php
session_start();
	$dbhost = 'localhost';
	$dbuser = 'id6943004_group2';
	$dbpass = 'group2';
	$dbname = 'id6943004_advwebproject';
	$conn = mysqli_connect($dbhost,$dbuser,$dbpass,$dbname);

	if(! $conn ) {
		die('Could not connect: ' . mysqli_error());
	}
if( isset($_POST['add'])) {
   	$id = ($_POST['add']);
}

$sql = "SELECT * FROM Inventory WHERE id='".$id."'";
$result = mysqli_query($conn, $sql);
if (mysqli_num_rows($result) > 0) {
	while($row = mysqli_fetch_assoc($result)) {
	$name = $row['name'];
	$code = $name."-".$id;
	$_SESSION['add'] = $id;
	$_SESSION['code'] = $code;
	$url = "Cart.php";
	header('Location: '.$url);
}} else {
    	    echo "0 results";
    	}
    
    	mysqli_close($conn);

?>