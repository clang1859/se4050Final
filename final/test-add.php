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