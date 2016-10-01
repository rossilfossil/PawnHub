<?php
	include "../connect_to_pms.php";

	$item = $_POST['itemID'];
	echo "wat";
	$sql = mysql_fetch_assoc(mysql_query("SELECT * FROM tbl_Items
							INNER JOIN tbl_Item
							ON tbl_Items.itemID = tbl_Item.itemID
							WHERE item_ID = $item"));
?>
