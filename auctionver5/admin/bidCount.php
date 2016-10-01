<?php
	include("../connect_to_pms.php");
	$num = $_POST['ctr'];
	$responseText = "";
	$numbids = mysql_num_rows(mysql_query("SELECT * FROM tbl_Bids"));
	if($num < $numbids){
		$get = mysql_fetch_assoc(mysql_query("SELECT * FROM tbl_Bids"));
	}
	else{
		$responseText = 0;
	}
	// echo $responseText;
?>