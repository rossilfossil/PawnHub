<?php
	include("../connect_to_pms.php");
	$itemID = $_POST['itemID'];

	$sql = mysql_query("SELECT * FROM tbl_Items
							INNER JOIN tbl_Item
							ON tbl_Item.itemID = tbl_Items.itemID
							WHERE tbl_Items.item_ID = '$itemID'");
	if (!mysql_num_rows($sql)==0){
		while($get_row = mysql_fetch_assoc($sql)){
			$itemid = $get_row['item_ID'];
			$itemsql = "SELECT * FROM tbl_Images where item_ID = $itemid";
			$numimg = mysql_num_rows(mysql_query($itemsql));
		?>
				<div class="row">
					<div class="input-field col l4 s12">
						<input name="text2" type="text" class="black-text" value="<?php echo $get_row['itemName']?>" DISABLED>
						<label for="text2" class="active black-text">Item Name</label>
					</div>
				<!-- </div>	 -->
				<!-- <div class="row"> -->
					<div class="input-field col l4 s12">
						<input name="text3" type="text" class="black-text" value="<?php echo $get_row['itemWorth']?>" DISABLED>
						<label for="text3" class="active black-text">Appraise Value</label>
					</div>
				<!-- </div>	 -->
				<!-- <div class="row"> -->
					<div class="input-field col l4 s12">
						<input name="text4" type="text" class="black-text" value="<?php echo $numimg?>" DISABLED>
						<label for="text4" class="active black-text">Number of Images</label>
					</div>
				</div>	
				<div id="lagayanan ng images" class="container center">
		<?php
			if($numimg > 0){
				$sql2=mysql_query($itemsql);
				while($get_img = mysql_fetch_assoc($sql2)){
					// ?>
					<img src="../uploads/<?php echo $get_img['item_image']?>" border="1" height="100px" width="100px">
					<?php
				}
			}
			else{
				?>
					<h4><center>No Images Yet</center></h4>
				<?php
			}
			?>
			</div>
			<center>
				
				<form action="" method="POST" enctype="multipart/form-data">
					<input type="hidden" name="itemid" class="black-text" value="<?php echo $get_row['item_ID']?>">
					<input type="file" name="fileToUpload" id="fileToUpload" required>
					<button class="btn black white-text" type="submit" name="submit">Submit</button>
				</form>
			</center>
			<?php
		}
	}	
?>