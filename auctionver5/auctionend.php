<?php
    include('connect_to_pms.php');
	include('../email/samplemail.php');

	$auctionId = $_POST['auctionID'];

	$get = mysql_fetch_assoc(mysql_query("SELECT * FROM tbl_Auctions WHERE auction_ID = $auctionId"));
	
	if($get['auction_status'] == 1){
		$get=mysql_query("SELECT * FROM tbl_Bids 
													INNER JOIN tbl_Bidders
													ON tbl_Bids.bidder_ID = tbl_Bidders.bidder_ID
													INNER JOIN tbl_Auctions
													ON tbl_Auctions.auction_ID = tbl_Bids.auction_ID
													WHERE tbl_Auctions.auction_id = $auctionId
						");
		if (!mysql_num_rows($get)==0){
			$action = 2; // ended with winner
			$get_row = mysql_fetch_assoc($get);
			$bid = $get_row['bid_ID'];
			$sql = "UPDATE tbl_Bids SET bid_status = 3 WHERE bid_ID = $bid";
			$bidder_email = $get_row['bidder_email'];
			$deadline = date("M jS, Y", strtotime($get_row['deadline_date']))." ".date("g:i:s a", strtotime($get_row['deadline_time']));
			$message = "You have won an auction with a price of P ". $bid. ".<br><br>Please commit checkout before ".$deadline."";
			sendEmail($bidder_email,$message);
			$res = mysql_query($sql) or die("Error in Query: ".mysql_error());
		}	
		else{
			$action = 3; // ended without winner
		}

		// check auction status
		$sql = "UPDATE tbl_Auctions SET auction_status = $action WHERE auction_ID = $auctionId";
		$res = mysql_query($sql) or die("Error in Query: ".mysql_error());

		$get = mysql_fetch_assoc(mysql_query("SELECT * FROM tbl_Items 
										INNER JOIN tbl_Auctions
										ON tbl_Auctions.item_ID = tbl_Items.item_ID
										WHERE tbl_Auctions.auction_ID = $auctionId"));
		$item = $get['item_ID'];
		// SETS item_status to won(2) or auction ended(3)
		$sql = "UPDATE tbl_Items SET item_status = $action WHERE item_ID = $item";	
		$res = mysql_query($sql) or die("Error in Query: ".mysql_error());
	}
?>