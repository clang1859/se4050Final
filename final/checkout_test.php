<?php
session_start();
?>
<HTML>
<BODY>
<HEAD>
<TITLE>Check Out</TITLE>
<link href="style.css" type="text/css" rel="stylesheet" />
</HEAD>
<a id="btnHome" href="testhome.php"
	style="border:#536684  1px solid;
	padding: 5px 10px;
	color: #536684;
	float: right;
	text-decoration: none;
	border-radius: 3px; ">Home Page</a><br><br>
<div class="txt-heading">Shopping Cart</div>
<div id="shopping-cart">
<?php
if(isset($_SESSION["cart_item"])){
    $total_quantity = 0;
    $total_price = 0;
    foreach ($_SESSION["cart_item"] as $item){
		$total_quantity += $item["quantity"];
		$total_price += ($item["price"]*$item["quantity"]);
		}
	echo $total_quantity;
	echo "$ ".number_format($total_price, 2);
} ?>
</div>
</BODY>
</HTML>
