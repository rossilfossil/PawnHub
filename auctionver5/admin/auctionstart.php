<?php
    include('../connect_to_pms.php');

	$auctionId = $_POST['auctionID'];
	
	$sql = "UPDATE tbl_Auctions SET auction_status = 1 WHERE auction_ID = $auctionId";
	$res = mysql_query($sql) or die("Error in Query: ".mysql_error());

	$latest = mysql_query("SELECT * FROM tbl_Auctions WHERE auction_status = 0  ORDER BY start_time LIMIT 1 ");
	if(!mysql_num_rows($latest) == 0){
		$get_time = mysql_fetch_assoc(mysql_query("SELECT * FROM tbl_Auctions WHERE auction_status = 0  ORDER BY start_time LIMIT 1"));
		$aucname = $get_time['auction_name'];
		$stopid = $get_time['auction_ID'];
		$stop = $get_time['start_time'];
		$stopex = $stop;
		$stopex = explode(':', $stop);
		$stophour = $stopex[0];
		$stopmin   = $stopex[1];
		$stopsec  = $stopex[2];
		$enddate = $get_time['start_date'];
		$enddateex = $enddate;
		$enddateex = explode('-', $enddateex);
		$endyear = $enddateex[0];
		$endmonth   = $enddateex[1];
		$endday  = $enddateex[2];	
		$resultText = $endyear."/". $endmonth."/". $endday."/". $stophour."/". $stopmin."/". $stopsec."/".$stopid."/".$aucname;
		echo $resultText;
	}
	else {
		echo 0;
	}	
?>