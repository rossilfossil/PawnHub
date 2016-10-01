<?php
$date = "2016-1-31";
//echo date('Y-m-d', strtotime("+30 days"));
echo date("Y-m-d",strtotime("+48hours",strtotime($date))) ;

include "../connect_to_pms.php";
/*
foreach ($_SESSION['item_stack'] as $value) {
			$sql = "UPDATE tbl_Items SET item_status = 1 WHERE item_ID = $value	";
			$res = mysql_query($sql) or die("Error in Query: ".mysql_error());
			echo "ok";
		}
*/
unset($_SESSION['item_stack']);
?>