<?php
    include('connect_to_pms.php');

	if(isset($_POST['submitbid'])){
		$bid = $_POST['bid'];
		if (!isset($_SESSION['userId'])){
			echo "<script>
 			alert('waaaaa')
			</script>";
			return;
		}
		$bidder = $_SESSION['userId'];
		$date = date("Y-m-d");
		$time = date("G:i:s");
		$auctionid = $_POST['auctionid'];
		$sql = mysql_fetch_assoc(mysql_query("SELECT * FROM tbl_Increments WHERE start_point <= $bid AND end_point >= $bid"));
		$incrementid = $sql['increment_ID'];
		$sql = "INSERT INTO tbl_Bids(bid_amount,bidder_ID,bid_date,bid_time,auction_ID) values('$bid','$bidder','$date','$time','$auctionid')";
		$res = mysql_query($sql) or die("Error in Query: ".mysql_error());
		$sql = "UPDATE tbl_Auctions SET current_price = $bid, increment_ID = $incrementid WHERE auction_ID = $auctionid";
		$res = mysql_query($sql) or die("Error in Query: ".mysql_error());
		echo "
			<script>
				window.location.href = 'listing.php';	
			</script>";
	}
?>