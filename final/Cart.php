<?php
session_start();
require_once("dbcontroller.php");
$db_handle = new DBController();
if(!empty($_GET["action"])) {
switch($_GET["action"]) {
	case "add":
		if(!empty($_POST["quantity"])) {
			$productByCode = $db_handle->runQuery("SELECT * FROM product WHERE code='" . $_GET["code"] . "'");
			$itemArray = array($productByCode[0]["code"]=>array('id'=>$productByCode[0]["id"],'name'=>$productByCode[0]["name"], 'code'=>$productByCode[0]["code"],'quantity'=>$_POST["quantity"], 'price'=>$productByCode[0]["price"], 'image'=>$productByCode[0]["image"]));
			
			if(!empty($_SESSION["cart_item"])) {
				if(in_array($productByCode[0]["code"],array_keys($_SESSION["cart_item"]))) {
					foreach($_SESSION["cart_item"] as $k => $v) {
							if($productByCode[0]["code"] == $k) {
								if(empty($_SESSION["cart_item"][$k]["quantity"])) {
									$_SESSION["cart_item"][$k]["quantity"] = 0;
								}
								$_SESSION["cart_item"][$k]["quantity"] += $_POST["quantity"];
							}
					}
				} else {
					$_SESSION["cart_item"] = array_merge($_SESSION["cart_item"],$itemArray);
				}
			} else {
				$_SESSION["cart_item"] = $itemArray;
			}
		}
	break;
	case "remove":
		if(!empty($_SESSION["cart_item"])) {
			foreach($_SESSION["cart_item"] as $k => $v) {
					if($_GET["code"] == $k)
						unset($_SESSION["cart_item"][$k]);				
					if(empty($_SESSION["cart_item"]))
						unset($_SESSION["cart_item"]);
			}
		}
	break;
	case "empty":
		unset($_SESSION["cart_item"]);
	break;	
	case "checkout":
		$CheckoutList = $_SESSION["cart_item"];
		header("Location: Checkout.php");
	break;
	case "home":
		header("Location: testhome.php");
	break;
	case "update":
		if(!empty($_SESSION["cart_item"])) {
			foreach($_SESSION["cart_item"] as $k => $v) {
					if($_GET["code"] == $k)
						$_SESSION["cart_item"][$k]["quantity"] = $_POST["quantity"];	
			}
		}
	break;
	case "login":
		header("Location: login.php");
	break;
}
}
?>
<HTML>
<HEAD>
<TITLE>Shopping Cart</TITLE>
<link href="https://fonts.googleapis.com/css?family=Dancing+Script" rel="stylesheet">
<link href="https://fonts.googleapis.com/css?family=Federant" rel="stylesheet">
<link href="https://fonts.googleapis.com/css?family=Titillium+Web" rel="stylesheet">
<link href="style.css" type="text/css" rel="stylesheet" />
</HEAD>
<BODY>
	<div id="shopping-cart">
	
	<div id="login" class="font"><a href="cart.php?action=login" class="link">Login >></div></a>
	<div><a href="cart.php?action=login"><img class="div-3" title="Login !" src="login.png" width="25px"/></a></a></div>
	
	<div id="div-1" class="font"><a href="cart.php?action=home" class="link">Home</a>&nbsp&nbsp>&nbsp&nbspCart </div>
	<a href="cart.php?action=home" >
	<img class="div-2" title="Back Home!" src="home-1.png" width="25px"/></a>
	
	<div class="div-title">Shopping Cart</div>
	<br>
	<br>
	<hr style=" height:1px;border:none;width: 1120px; position: absolute; left: 6.5%;top:21%;border-top:1.5px solid #E0E0E0;" />
<?php
if(isset($_SESSION["cart_item"])){
    $total_quantity = 0;
    $total_price = 0;
?>	

<table rules="rows" id="tbl-cart" style="width: 760px;">
<tbody>
<tr height="70px" class="font" style="font-size:15px;">
<td style="text-align:left;">Product</td>
<td style="text-align:left; width:150px;">Quantity</td>
<td style="text-align:center;" >Price</td>
<td style="text-align:left; width:40px">Remove</td>
</tr>	
<?php		
    foreach ($_SESSION["cart_item"] as $item){
        $item_price = $item["quantity"]*$item["price"];
		?>
				
				<form method="post" action="cart.php?action=update&code=<?php echo $item["code"]; ?>">
				<tr height="200px">
				<td width="370px"><table  style="font-size:12px;border-spacing:0px;">
					<tr>
						<td rowspan="2" width="200px"><img src="<?php echo $item["image"]; ?>" class="cart-item-image" style="width: 200px;height: auto;border-radius: 0;padding:0; border-color:#FFFFFF;"/></td>
						<td style="font-size:14px;"class="font"><?php echo $item["name"]; ?></td></tr>
					<tr><td><?php echo "$ ".$item["price"]; ?></td></tr>
					</table>
				
				<td><div><input style="text-align:right; width:50px" type="number" class="product-quantity" name="quantity" min='1' value="<?php echo $item["quantity"] ?>" size="2" required="required" /><input type="submit" value="Update" class="btnAddAction" /></div></td>
				
				<td  style="text-align:center;"><?php echo "$ ". number_format($item_price,2); ?></td>
				<td style="text-align:center;"><a href="cart.php?action=remove&code=<?php echo $item["code"]; ?>" class="btnRemoveAction"><img src="delete.png" width="20px" title="Remove Item" /></a></td>
				</tr>
				</form>	
				<?php
				$total_quantity += $item["quantity"];
				$total_price += ($item["price"]*$item["quantity"]);
		}
		?>

<tr height="70px;">
<td align="right">Total:</td>
<td align="center"><?php echo $total_quantity; ?></td>
<td align="center"><strong><?php echo "$ ".number_format($total_price, 2); ?></strong></td>
<td><a href="cart.php?action=empty"><img src="empty.png" width="35px" title="Empty cart !"/></a></td>
</tr>
</tbody>
</table>	
  <?php
} else {
?>
<div id="no-records" class="font">Your Cart is Empty<br><br><a href="cart.php?action=home">Back Home >></a></div>
<?php 
}
?>
</div>
<?php
 if(!empty($_SESSION["cart_item"])) {?>
<div style="margin-left:640px; position:absolute;"><a href="cart.php?action=checkout" ><img src="checkout.png" width="200px" title="Check Out!" /></a></div><br><br><br>
<br><br>
<div class="font" id="subtotal" style="background-color: #efd1bd;
	opacity:0.8;
	position: fixed;
	right: 6%;
	top: 27.5%;
	width: 300px;
	height: 370px;">
	<strong><p style=" margin-left:7%; margin-top:7%; font-size:20px;">SUMMARY</p></strong>
	<hr style="border:none;width: 278px; position: absolute; left: 3.5%;top:13%;border-top:1.5px solid #E0E0E0;" />
	<table style=" width:275px; border-spacing:10px; margin-left:5%; margin-top: 5%; font-size: 15px;">
	<tr>
		<td style="text-align:left; width:100px;"><strong>ITEM TOTAL:</strong></td>
		<td style="text-align:right;width:100px;"><strong><?php echo "$ ".number_format($total_price, 2); ?></strong></td>
	</tr>
	<tr>
		<td style="text-align:left;"><strong>SHIPPING:</strong></td>
		<td style="text-align:right;"><strong>$ 0.00</strong></td>
	</tr>
	<tr>
		<td style="text-align:left;"><strong>TAX:</strong></td>
		<td style="text-align:right;"><strong>$ 0.00</strong></td>
	</tr>
	<tr><td colspan="2">
		<hr style="border:none;width: 278px; position: absolute; left: 3.5%;top:48.5%;border-top:1.5px solid #E0E0E0;" />
	</td></tr>
	<tr>
		<td style="text-align:left; width:220px;"><strong>SUBTOTAL:</strong></td>
		<td style="text-align:right;"><strong><?php echo "$ ".number_format($total_price, 2); ?></strong></td>
	</tr></table>
	<div>
		<a href="cart.php?action=checkout" ><img title="Buy Now!" src="paypal.png" width="200px"  style="margin-left:16.5%; margin-top:3%;"/></a>
	</div>
</div>
 <?php 
 } 
 else{ ?>
 <hr style=" height:1px;border:none;width: 1120px; position: absolute; left: 6.5%;border-top:1.5px solid #E0E0E0;" /><br><br>}
<?php
}
?>
 
</BODY>
</HTML>