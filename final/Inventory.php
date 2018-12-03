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
	
	if(!empty($_POST['name'])){
		$name = $_POST['name'];
	}
	
	if(!empty($_POST['description'])){
		$description = $_POST['description'];
	}
	
	if(!empty($_POST['price'])){
		$price = $_POST['price'];
	}
	
	if(!empty($_POST['image'])){
		$image = $_POST['image'];
	}
	
	if(!empty($_POST['category'])){
		$category = $_POST['category'];
	}
	
	if(!empty($_POST['type'])){
	$type = $_POST['type'];
	}
	
	if(!empty($_POST['sort'])){
		$sort = $_POST['sort'];
	}
	
	if(!empty($_POST['edit'])){
		$edit = $_POST['edit'];
	}
	
	if(!empty($_POST['search'])){
		$search = $_POST['search'];
		$sql4 = "SELECT * FROM Inventory WHERE ".$sort."= '".$search."'";
		unset($_POST['search']);
	}
	else{
		$sql4 = "SELECT id, name, price, category, type FROM Inventory";
	}
	
	if(!empty($_POST['add'])){
		//insert
		$sql = "INSERT INTO Inventory (name, description, price, image, category,type,code) VALUES (\"$name\", \"$description\", \"$price\", \"images/inv/none.jpg\", \"$category\",'$type','test')";
		$result = mysqli_query($conn, $sql);
		$id = mysqli_insert_id($conn);
		// set code
		$code = $category."-".$id;
		$sql1 = "UPDATE Inventory SET code = '".$code."' WHERE Inventory.id = ".$id;
		$result = mysqli_query($conn, $sql1);
		
		//Whether the Inventory picture uploaded is correct
		if(!empty($_FILES["pic"])){
			$upfile=$_FILES["pic"];
			$typelist=array("image/jpeg","image/jpg","image/png","image/gif");
			$path="./images/inv/";//Define an uploaded directory
			$extension = pathinfo($upfile["name"],PATHINFO_EXTENSION);//get the name of the uploaded file
			$newname = $name."-".$code.".".$extension;
		if(is_uploaded_file($upfile["tmp_name"])){
			if(move_uploaded_file($upfile["tmp_name"],$path.$newname)){
				$sql3 = "UPDATE Inventory SET image = '".$path.$newname."' WHERE Inventory.id = ".$id;
				$result3 = mysqli_query($conn, $sql3);
			}else{
				echo("Error...<br><br>");
			}
		}
	}}
?>
<html>
<head>
<title>Inventory</title>
<link href="https://fonts.googleapis.com/css?family=Dancing+Script" rel="stylesheet">
<link href="Inventory.css" type="text/css" rel="stylesheet" />
<link href="https://fonts.googleapis.com/css?family=Titillium+Web" rel="stylesheet">
</head>
<body>

<div id="leftcon">
	<div>
	<table id="t01" style="height:30%;">
		<tr class="tr01"><td id="inv" class="td01" onclick="list()">Inventory  &nbsp  List</td></tr>
		<tr class="tr01"><td id="additem" class="td01" onclick="add()">Add Item</td></tr>
		<tr class="tr01"><td class="td01" onclick="window.location.href='account.php'">Account Setting</td></tr>
	</table>
	<div>
</div>

<div id="rightcon">
<div style="position:absolute;margin-left:5.5%;top:1.5%;"><a href="storelisting.php" style="text-decoration:none; color:black;">Home</a>&nbsp&nbsp>&nbsp&nbsp Inventory</div>
<a href="storelisting.php">
<img style="margin-left:0.5%;margin-top:0.5%;" title="Back Home!" src="images/icons/home-1.png" width="25px"/></a>
<h2 id="subtitle">Inventory &nbsp List</h2>
<hr class="hr" style="top:20%;"/>
<!------------------------------------Add-------------------------------------->
<form method="post" action="Inventory.php" enctype="multipart/form-data" id="add">
	<div id="img">
		<div>
			<input type="file" value="Upload" name="pic" id="pic" onchange="javascript:setImagePreview();" /><br>
		</div><br>
		<div id="localImag"><img id="preview" src="images/icons/none.jpg" /></div>  	
	</div>
		<br><br><br><br><br><br><br><br>
	<div id="info">	
	<table>
		<tr class="tr02">
			<td class="t02">Name: </td>
			<td><input type="text" name="name"></td>
		</tr>
		<tr class="tr02">
			<td>Description: </td>
			<td><input type="text" name="description"></td>
		</tr>
		<tr class="tr02">
			<td>Price: </td>
			<td><input type="text" name="price"></td>
		</tr>
		
		<tr class="tr02">
			<td>Category: </td>
			<td><input type="text" name="category"></td>
		</tr>
		<tr class="tr02">
			<td>Type: </td>
			<td><input type="text" name="type"></td>
		</tr>
		<tr class="tr02"><td colspan="2" style="text-align:center;"><button type="submit" id="addbtn" name="add" value="Add" onclick="window.location.replace('Inventory.php')" >Add</button></td></tr>
	</table>
	</div>
</form>
<!----------------------------------Editor------------------------------->
<iframe id="editor" name="editor" class="modal" style="display:none">
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
      <tr><td colspan="2"><center><button onclick="document.getElementById('editor').style.display='none'" type="submit" name="update" class="registerbtn">Submit</button></center></td></tr>
    </div>
	</form>
</iframe>
<!------------------------------------Inventory-------------------------------------->
<div id="list">
<!--  
	<iframe id="target" name="target" style="display:block;"></iframe>
	<form method="post" action="sort.php" target="target">   
-->
<!-----------------Search------------------->
	<form method="post" action="Inventory.php">  
	<div>
	<table id="t04">
		<tr>
			<td>Sort &nbsp by:</td> 
			<td>
				<select name="sort">
					<option value="id">ID</option>
					<option value="name">Name</option>
					<option value="price">Price</option>
					<option value="category">Category</option>
					<option value="type">Type</option>
				</select>
			</td> 
			<td><input style="width:70%;" type="text" name="search"></td> 
			<td><button type="submit" class="searchbtn"><img src="images/icons/search.png" width="25px" /></button></td> 
			<td><button class="searchbtn" title="Show all items!" onclick="window.location.replace('Inventory.php')"><img src="images/icons/showall.png" width="25px" /></button></td> 
		</tr>
	</table>
	</div>
	</form>
<!-----------------list------------------->
<div>
<form method="post" action="editor.php" target="editor">
	<table id="t03">
		<thead class="head">
		<tr style="height:40px;">
			<th width="60px">ID </th>
			<th width="190px">Name </th>
			<th width="95px">Price </th>
			<th width="130px">Category </th>
			<th width="120px">Type </th>
			<th width="50px">Edit </th>
			<th width="55px">Delete</th>
		</tr>
		</thead>
		<tbody class="scrollTbody">
		<?php
			$result = mysqli_query($conn, $sql4);
			if (mysqli_num_rows($result) > 0) {
			while($row = mysqli_fetch_assoc($result)) {?>
				<tr class="tr03"><td  width="60px"><?php echo $row["id"];?></td>
				<td width="200px"><?php echo $row["name"];?></td>
				<td width="100px"><?php echo $row["price"];?></td>
				<td width="130px"><?php echo $row["category"];?></td>
				<td width="120px"><?php echo $row["type"];?></td>
				<td width="60px"><button onclick="document.getElementById('editor').style.display='block'" type="submit" value="<?php echo $row["id"]; ?>" name="editid" class="searchbtn"><img src="images/icons/edit.png" width="18px" style="cursor:pointer;"/></button></td>
				<td width="60px"><button onclick="window.location.replace('Inventory.php')" type="submit" value="<?php echo $row["id"]; ?>" name="delete" class="searchbtn"><img src="images/icons/delete.png" width="18px" style="cursor:pointer;"/></button></td></tr>
		<?php	
			}}
			else { echo "0 results"; }
			mysqli_close($conn);
		?>
		</tbody>
	</table>	
	</table>	
</form></div>
</div>

</div>
</body>
<script>
function setImagePreview() {  
        var preview, img_txt, localImag, file_head = document.getElementById("pic"),  
        picture = file_head.value;  
        if (!picture.match(/.jpg|.gif|.png|.bmp/i)) return alert("The format of the picture you uploaded is not correct, please reselect it！"),  
        !1;  
        if (preview = document.getElementById("preview"), file_head.files && file_head.files[0]) 
			preview.style.display = "block",  
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
function list(){
	document.getElementById("subtitle").innerHTML = "Inventory &nbsp List";
	document.getElementById("add").style.display = "none";
	document.getElementById("list").style.display = "block";
	
	document.getElementById("inv").style.backgroundColor = "#d8d4d8";
	document.getElementById("additem").style.backgroundColor = "#c7c0d6";
}

function add(){
	document.getElementById("subtitle").innerHTML = "Add &nbsp Item";
	document.getElementById("add").style.display = "block";
	document.getElementById("list").style.display = "none";
	
	document.getElementById("additem").style.backgroundColor = "#d8d4d8";
	document.getElementById("inv").style.backgroundColor = "#c7c0d6";
}
var modal1 = document.getElementById('register');
window.onclick = function(event) {
    if (event.target == modal) {
        modal1.style.display = "none";
    }
}
function edit(){
	document.getElementById("editor").style.display = "block";
}
</script>
</html>