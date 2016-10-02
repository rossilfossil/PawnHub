<?php
	 // include "../connect_to_pms.php";
	$datenow = date("Y-m-d");
	$timenow = date("G:i:s");
	function deadline($id){
						$sql = "UPDATE tbl_Auctions SET auction_status = 6 WHERE auction_ID = $id";
						$res = mysql_query($sql) or die("Error in Query: ".mysql_error());
						$sql = mysql_query("SELECT * FROM tbl_Items
												INNER JOIN tbl_item
											ON tbl_Items.itemId = tbl_Item.itemId
												INNER JOIN tbl_Auctionitems
												ON tbl_Items.item_ID = tbl_Auctionitems.item_ID
												WHERE tbl_Auctionitems.auction_ID = $id");
						if(!mysql_num_rows($sql)==0){
							while($getitem = mysql_fetch_assoc($sql)){
								$item = $getitem['item_ID'];
								$update = "UPDATE tbl_Items SET item_status = 5 WHERE item_ID = '$item'";
								$res = mysql_query($update) or die("Error in Query: ".mysql_error());									
							}
						}

						$get=mysql_fetch_assoc(mysql_query("SELECT * FROM tbl_Bids 
																	INNER JOIN tbl_Bidders
																	ON tbl_Bids.bidder_ID = tbl_Bidders.bidder_ID
																	WHERE auction_id = $id
												"));
				
						$bid = $get['bid_ID'];
						$sql = "UPDATE tbl_Bids SET bid_status = 2 WHERE bid_ID = $bid";
						$res = mysql_query($sql) or die("Error in Query: ".mysql_error());
	} // function
	$get=mysql_query("SELECT * FROM tbl_Auctions WHERE auction_status = 2");
	if(!mysql_num_rows($get)==0){
		while($get_row=mysql_fetch_assoc($get)){
			$id = $get_row['auction_ID'];
			$datecheck = $get_row['deadline_date'];
			$timecheck = $get_row['deadline_time'];
			if(strtotime($datecheck) <= strtotime(date("Y-m-d"))){
				if(strtotime($datecheck) == strtotime(date("Y-m-d"))){
					if(strtotime($timecheck) <= strtotime(date("G:i:s"))){
						deadline($id);
					}	
				}
				if(strtotime($datecheck) < strtotime(date("Y-m-d"))){
						deadline($id);
				}
				//else{
					//return;
			//	}
			}
			 //else{
				 //return;
			// }
		}	
	}
	 //else{
		 //return;
	//}
