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
while($row = mysqli_fetch_assoc($result)) {
	$category = $row['category'];
	$code = $category."-".$id;
}
$_SESSION['add'] = $id;
$_SESSION['code'] = $code;
$url = "Cart.php";
header("Location:Cart.php");
?>