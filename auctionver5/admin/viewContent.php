<?php
    include('../connect_to_pms.php');	
	$today = date("Y-m-d");
	$currentTime = date("G:i:s");


	if (isset($_POST['aucID'])){	
		$auctionid = $_POST['aucID'];
	}
	else{
		echo "<center><h1>No Listing selected!</h1></center>";
		return;
	} // checks if there is a listing selected

	$get=mysql_query("SELECT * FROM tbl_Auctions 
		INNER JOIN tbl_Increments
		ON tbl_Auctions.increment_ID = tbl_Increments.increment_ID
		WHERE auction_ID = $auctionid");
	if (mysql_num_rows($get)==0){
		echo "<center><h1>Nothing to Display</h1></center>";
		return;
	} // checks if the listing still exists
	else{	
		$get_row = mysql_fetch_assoc($get);
		$auctionid = $get_row['auction_ID'];
		$auctionstatus = $get_row['auction_status'];
		$visitors = $get_row['auction_visitors'];
		$bidders = mysql_num_rows(mysql_query("SELECT DISTINCT bidder_ID FROM tbl_Bids WHERE auction_ID = $auctionid"));
	}
	$start_list = date("M jS, Y", strtotime($get_row['end_date']))." ".date("g:i:s a", strtotime($get_row['end_time']));
	$end_list = date("M jS, Y", strtotime($get_row['start_date']))." ".date("g:i:s a", strtotime($get_row['start_time']));
	$dead_list = date("M jS, Y", strtotime($get_row['deadline_date']))." ".date("g:i:s a", strtotime($get_row['deadline_time']));	
	$stop = $get_row['end_time'];
	$stopex = $stop;
	$stopex = explode(':', $stop);
	$stophour = $stopex[0];
	$stopmin   = $stopex[1];
	$stopsec  = $stopex[2];
	$enddate = $get_row['end_date'];
	$enddateex = $enddate;
	$enddateex = explode('-', $enddateex);
	$endyear = $enddateex[0];
	$endmonth   = $enddateex[1];
	$endday  = $enddateex[2];	
	// FOR TESTING PURPOSES
	//$enddate = "2016-07-01";
	//$stop = "17:36:30";	
?>
<script type="text/javascript" src="auctionend.js"></script>
<link rel="stylesheet" type="text/css" href="css/mycss.css">	
</head>
<body>	
	<div id="listingcontainer" class="row">
		<div class="col l12 s12"><!-- slider and countdown -->
			<!-- <div class="slider"> -->
    			<!-- <ul class="slides"> -->
    			<center>
				    <?php
						$getimg = mysql_query("SELECT * FROM tbl_Images
											INNER JOIN tbl_Items
											ON tbl_Images.item_ID = tbl_items.item_ID
											INNER JOIN tbl_Auctionitems
											ON tbl_Auctionitems.item_ID = tbl_Items.item_ID
											WHERE tbl_Auctionitems.auction_ID = $auctionid");
						if(!mysql_num_rows($getimg)==0){
							while($get_img = mysql_fetch_assoc($getimg)){
								?>
								<!-- <li> -->
									<img class="" style=" width: 100px; height: 100px; " src="../uploads/<?php echo $get_img['item_image']?>">
								<!-- </li> -->
								<?php
							}
						}
    				?>
    			</center>
    			<!-- </ul> -->
  				<!-- </div> -->
		</div>
		<div class="col l12 s12">
			<div class="row ">
				<p><b>Auction Name: </b><?php echo $get_row['auction_name'];?></p>
				<p><b>Auction Descriptions</b>: <?php echo $get_row['auction_description'];?></p>
				<p><b>Last Price:</b> <?php echo $get_row['current_price'];?>php</p>
							<?php
								$get=mysql_query("SELECT * FROM tbl_Bids 
									INNER JOIN tbl_Bidders
									ON tbl_Bids.bidder_ID = tbl_Bidders.bidder_ID
									WHERE auction_id = $auctionid
									ORDER BY bid_id DESC
									");
								if (mysql_num_rows($get)==0){
										$highestbidder = "No Bidders";
										$highestbidderid = 0;;
								}
								else {
									?>
									<?php
									while($get_row=mysql_fetch_assoc($get)){
										if (!isset($highestbidder)){
											$highestbidderid = $get_row['bidder_ID'];
											$highestbidder = $get_row['bidder_username'];;
										}
									}
								}	
							?>							
			</div>
		</div>	
			<div class="row">
				<div class="col l12 s12 m12">	
					<center><h5>Auction Item</h5></center>
					<table class="centered highlight">
						<thead>
							<th>ID</th>
							<th>Name</th>
						</thead>	
						<tbody>
							<tr>								
					<?php
						$sql = mysql_query("SELECT * FROM tbl_Items
											INNER JOIN tbl_item
											ON tbl_Items.itemId = tbl_Item.itemId
											INNER JOIN tbl_Auctionitems
											ON tbl_Items.item_ID = tbl_Auctionitems.item_ID
											WHERE tbl_Auctionitems.auction_ID = $auctionid");
						if(!mysql_num_rows($sql)==0){
							while($getitem = mysql_fetch_assoc($sql)){
								?>
								<tr>	
									<td><?php echo $getitem['item_ID']?></td>
									<td><?php echo $getitem['itemName']?></td>
								</tr>
								<?php
							}
						}						
					?>
							</tr>		
						</tbody>
					</table>
					<p><i class="material-icons">event</i><b>Start Date</b>: <?php echo $end_list?></p>
					<p><i class="material-icons">event</i><b>End Date</b>: <?php echo $start_list?></p>
					<p><i class="material-icons">event</i><b>Deadline</b>: <?php echo $dead_list?></p>

					<!-- <a class="modal-trigger black-text" href="#bidsmodal" data-target="bidsmodal"><i class="material-icons">history</i><b>Bid History</b><span class="badge black white-text"><?php echo mysql_num_rows($get)?> Bids</span></a> -->
					<p><i class="material-icons">face</i><b>Highest Bidder </b>:<?php echo $highestbidder?></p>
					<p><i class="material-icons">face</i><b>Bidders </b>:<?php echo $bidders?></p>
					<!--
					<p><i class="material-icons">face</i><b>Visitors </b>:<?php // echo $visitors?></p>
					-->
				</div>
			</div>	
</div>	
<script type="text/javascript">
	$(document).ready(function(){
		$('.slider').slider({full_width: true});
	});

	$(document).ready(function(){
		$('.materialboxed').materialbox();
	});

	$('.modal-trigger').leanModal({
      dismissible: true, // Modal can be dismissed by clicking outside of the modal
      opacity: .5, // Opacity of modal background
      in_duration: 300, // Transition in duration
      out_duration: 200, // Transition out duration
    }
  );
</script>
</div>
</body>
</html>