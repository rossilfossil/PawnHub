<?php
	// include "connect_to_pms.php";
	include "../email/samplemail.php";

	$datenow = date("Y-m-d");
	$timenow = date("G:i:s");
	function enddate($id){
		$get=mysql_query("SELECT * FROM tbl_Bids 
													INNER JOIN tbl_Bidders
													ON tbl_Bids.bidder_ID = tbl_Bidders.bidder_ID
													INNER JOIN tbl_Auctions
													ON tbl_Auctions.auction_ID = tbl_Bids.auction_ID
													WHERE tbl_Auctions.auction_id = $id
												");
		if (!mysql_num_rows($get)==0){
			$get_row = mysql_fetch_assoc($get);
			$bid = $get_row['bid_ID'];
			$amount = $get_row['bid_amount'];
			$sql = "UPDATE tbl_Bids SET bid_status = 3 WHERE bid_ID = $bid";
			$bidder_email = $get_row['bidder_email'];
			$deadline = date("M jS, Y", strtotime($get_row['deadline_date']))." ".date("g:i:s a", strtotime($get_row['deadline_time']));
			$message = "You have won an auction with a price of P". $amount. ". Please commit checkout before ".$deadline."";
			sendEmail($bidder_email,$message);
			$res = mysql_query($sql) or die("Error in Query: ".mysql_error());
			$action = 2; // ended with winner
		}	
		else{
			$action = 3; // ended without winner
		}
			// check auction status
		$sql = "UPDATE tbl_Auctions SET auction_status = $action WHERE auction_ID = $id";
		$res = mysql_query($sql) or die("Error in Query: ".mysql_error());
			

		$get = mysql_fetch_assoc(mysql_query("SELECT * FROM tbl_Items
											INNER JOIN tbl_auctionitems
											ON tbl_Items.item_ID = tbl_auctionitems.item_ID 
											INNER JOIN tbl_Auctions
											ON tbl_Auctions.auction_ID = tbl_auctionitems.auction_ID
											WHERE tbl_Auctions.auction_ID = $id"));
		$item = $get['item_ID'];
			// SETS item_status to won(2) or auction ended(3)
		$sql = "UPDATE tbl_Items SET item_status = $action WHERE item_ID = $item";	
		$res = mysql_query($sql) or die("Error in Query: ".mysql_error());
}

	$get=mysql_query("SELECT * FROM tbl_Auctions WHERE auction_status = 1 ORDER BY end_date, end_time");
	if(!mysql_num_rows($get)==0){
		while($get_row=mysql_fetch_assoc($get)){
			$id = $get_row['auction_ID'];
			$datecheck = $get_row['end_date'];
			$timecheck = $get_row['end_time'];
			echo $id;
			if(strtotime($datecheck) <= strtotime(date("Y-m-d"))){
				if(strtotime($datecheck) == strtotime(date("Y-m-d"))){
					if(strtotime($timecheck) <= strtotime(date("G:i:s"))){
						enddate($id);
					}	
				}
				if(strtotime($datecheck) < strtotime(date("Y-m-d"))){
					enddate($id);
				}
				else{
					return;
				}
			}
			else{
				return;
			}
		}	
	}
	else{
		return;
	}
