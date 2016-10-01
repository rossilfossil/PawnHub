<?php
	$con = mysql_connect('localhost','root') or die(mysql_error());
	mysql_select_db('pms') or die("Cannot Select db");
	$amount = $_POST['amount']; // tbl_items

	if (!$amount == ""){
		$sql = mysql_fetch_assoc(mysql_query("SELECT * FROM tbl_item 
												INNER JOIN tbl_Items		
												ON tbl_Items.itemId = tbl_item.itemId
			WHERE item_ID = $amount"));
			if ($sql){	
				$worth = $sql['itemWorth'];
			}
			else{
				$worth = 0;
			}
	}
	else{
		$worth = 0;
	}
	echo '<input name="ip" class="black-text" type="text" value='.$worth.' disabled> <label for="ip" class="black-text active">Ideal Price</label>';
?>	