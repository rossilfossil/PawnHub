<?php
		include("connect_to_pms.php");
		$id = $_SESSION['auction_id'];

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
																	WHERE auction_id = $id"));
						$bid = $get['bid_ID'];
						$sql = "UPDATE tbl_Bids SET bid_status = 2 WHERE bid_ID = '$bid'";
						$res = mysql_query($sql) or die("Error in Query: ".mysql_error());

    echo "
      <script>
      	alert('Checkout Successfully cancelled!');
        window.location.href = 'cart.php';
      </script>";
?>
