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
	if(isset($_POST['editid'])){
		$select_id = $_POST['editid'];
		$_SESSION['id'] = $_POST['editid'];
	}
	/***********************************************************///Get id from inventory
	if(!empty($select_id)){
			$sql = "SELECT name, image, description, price, category, type FROM Inventory WHERE id='".$select_id."'";
			$result = mysqli_query($conn, $sql);
			if (mysqli_num_rows($result) > 0) {
			while($row = mysqli_fetch_assoc($result)) {
				$select_name = $row['name'];
				$select_img = $row['image'];
				$select_des = $row['description'];
				$select_price = $row['price'];
				$select_cate = $row['category'];
				$select_type = $row['type'];
			}}
			else {echo "error";}
			?>
			<html>
	<head>
	<link href="Inventory.css" type="text/css" rel="stylesheet" />
	<link href="https://fonts.googleapis.com/css?family=Titillium+Web" rel="stylesheet">
	<style type="text/css">
	.editinput{
		width: 75%;
		padding: 12px 20px;
		margin: 8px 55px;
		display: inline-block;
		border: 1px solid #ccc;
		box-sizing: border-box;
		height:35px;
	}
	</style>
	</head>
	<body>
  <form class="modal-editor animate" action="editor.php" method="POST" enctype="multipart/form-data">
	<span onclick="window.parent.location.replace('Inventory.php')" class="close" title="Close Modal">&times;</span>
	<div id="imgedit">
		<input type="file" value="Upload" name="pic" id="pic" onchange="javascript:setImagePreview();" /><br><br>
		<div id="localImag"><img id="preview" src="<?php echo $select_img;?>" /></div>  	
	</div> 
	<div id="conedit">
	<table id="t05">
		<tr><td>Name: </td>
			<td><input class="editinput" type="text" value="<?php echo $select_name; ?>" name="name"/></td></tr>
		<tr><td>Description: </td>
			<td style="text-align:right;"><textarea rows="3" col="15" name="description"><?php echo $select_des; ?></textarea></td></tr>
		<tr><td>Price: </td>
			<td><input  class="editinput"type="text" value="<?php echo $select_price; ?>" name="price"/></td></tr>
		<tr><td>Category: </td>
			<td><input  class="editinput"type="text" value="<?php echo $select_cate; ?>" name="category"/></td></tr>
		<tr><td>Type: </td>
			<td><input  class="editinput"type="text" value="<?php echo $select_type; ?>" name="type"/></td></tr>
      <tr><td colspan="2"><center><button onclick="" type="submit" name="update" class="registerbtn">Submit</button></center></td></tr>
    </div>
	</form>
	</body>
	<script>
	function setImagePreview() {  
        var preview, img_txt, localImag, file_head = document.getElementById("pic"),  
        picture = file_head.value;  
        if (!picture.match(/.jpg|.gif|.png|.bmp/i)) return alert("The format of the picture you uploaded is not correct, please reselect it！"),  
        !1;  
        if (preview = document.getElementById("preview"), file_head.files && file_head.files[0]) preview.style.display = "block",  
            preview.style.width = "150px",  
            preview.style.height = "150px",  
            preview.src = window.navigator.userAgent.indexOf("Chrome") >= 1 || window.navigator.userAgent.indexOf("Safari") >= 1 ? window.webkitURL.createObjectURL(file_head.files[0]) : window.URL.createObjectURL(file_head.files[0]);  
        else {  
            file_head.select(),  
            file_head.blur(),  
            img_txt = document.selection.createRange().text,  
            localImag = document.getElementById("localImag"),  
            localImag.style.width = "150px",  
            localImag.style.height = "150px";  
            try {  
                localImag.style.filter = "progid:DXImageTransform.Microsoft.AlphaImageLoader(sizingMethod=scale)",  
                localImag.filters.item("DXImageTransform.Microsoft.AlphaImageLoader").src = img_txt  
            } catch(f) {  
                return alert("The format of the picture you uploaded is not correct, please reselect it！"),  
                !1  
            }  
            preview.style.display = "none",  
            document.selection.empty()  
        }  
        !0  
    }  
	</script>
</html>
<?php }
	///*********************************************/Get data from the submit in editor.php
	if(!empty($_POST['name'])){ 
	
	echo "<script>window.parent.location.replace('Inventory.php');</script>";
		//delete photo
		$sql = "SELECT image FROM Inventory WHERE id='".$_SESSION['id']."'";
		$result = mysqli_query($conn, $sql);
		if (mysqli_num_rows($result) > 0) {
			while($row = mysqli_fetch_assoc($result)) {
				$photo = $row['image'];
			}}
		else {echo "no name result.";}
		$code = $_POST['category']."-".$_SESSION['id'];
		//insert
		$sql = "Update Inventory SET name='".$_POST['name']."', description='".$_POST['description']."', price='".$_POST['price']."', category='".$_POST['category']."', type='".$_POST['type']."', code='".$code."' WHERE id='".$_SESSION['id']."'";
		$result = mysqli_query($conn, $sql);
		
		//Whether the Inventory picture uploaded is correct
		if(!empty($_FILES["pic"])){
			$upfile=$_FILES["pic"];
			$typelist=array("image/jpeg","image/jpg","image/png","image/gif");
			$path="./images/inv/";//Define an uploaded directory
			$extension = pathinfo($upfile["name"],PATHINFO_EXTENSION);//get the name of the uploaded file
			$newname = $_POST['name']."-".$code.".".$extension;
		if(is_uploaded_file($upfile["tmp_name"])){
			if(move_uploaded_file($upfile["tmp_name"],$path.$newname)){
				unlink($photo);
				$sql3 = "UPDATE Inventory SET image = '".$path.$newname."' WHERE Inventory.id = ".$_SESSION['id'];
				
			}else{
				echo("Error...<br><br>");
			}
		}else{
			$sql3 = "UPDATE Inventory SET image = '".$photo."' WHERE Inventory.id = ".$_SESSION['id'];
		}
		$result3 = mysqli_query($conn, $sql3);
		unset($_SESSION['id']);
		}
		?>
		<center><img src="images/icons/wait.png" width="100px" style="position:absolute; top:10%;"></center>
		<?php } 
		if(isset($_POST['delete'])){
			$sql = "DELETE FROM Inventory WHERE id=".$_POST['delete'];
			$result = mysqli_query($conn, $sql);
		}?>

