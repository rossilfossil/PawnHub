<?php
	include"../connect_to_pms.php";
	$enddate = $_POST['enddate'];
	$sql = mysql_fetch_assoc(mysql_query("SELECT * FROM tbl_biddingConstants WHERE bc_ID = 1"));
	$auctionperiod = $sql['auction_period'];

	$maximumDate = date("Y-m-d",strtotime("+$auctionperiod hours",strtotime($enddate)));
	echo $maximumDate;
?>