<?php
    include('../connect_to_pms.php');	
	$today = date("Y-m-d");
	$currentTime = date("G:i:s");

	$auctionid = $_POST['aucID'];

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
<link rel="stylesheet" type="text/css" href="css/mycss.css">	
<script type="text/javascript" src="maximumAuctionPeriod.js"></script>
<script type="text/javascript" src="validation.js"></script>

</head>
<body>	
			<div class="row"><!-- slider and countdown -->
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

         	<form action="" method="POST" enctype="multipart/form-data">
			<div class="row">
				<div class="col s12">	
	         		<input type="hidden" name="modalID" id="modalID" value="<?php echo $get_row['auction_ID']?>" required>
				</div>
				<div class="col m6 l6 s12">	
	         		<label for="modalName" class="black-text">Auction Name</label>
	         		<input type="text"  name="modalName" id="modalName" value="<?php echo $get_row['auction_name']?>"  disabled>
	         	</div>
				<div class="col m6 l6 s12">		
	         		<label for="modalDesc" class="black-text">Auction Description</label>
	         		<input type="text"  name="modalDesc" id="modalDesc" value="<?php echo $get_row['auction_description']?>"  disabled>
				</div>
			</div>		
<!-- 			<div class="row">
				<div class="col s12">
         			<label for="modalPrice">Price</label>
         			<input type="number" name="modalPrice" step="0.01" id="modalPrice" value="<?php //echo $get_row['auction_']?>"  disabled>
				</div>	
			</div> -->
			<div class="row">
				<div class="col s12 m6 l6">
         			<label class="black-text" for="modalSDate">Start Date</label>
					<input type="date" id="modalDate" name="modalSDate" class="validate" min="<?php echo $today?>" oninput="setMaxDate(this.value);document.getElementById('enddate').min=this.value;" value="<?php echo $get_row['start_date']?>"  disabled>
				</div>
				<div class="col s12 m6 l6">
         			<label class="black-text" for="modalSTime">Start Time</label>
					<input type="time" id="modalTime" name="modalSTime" class="validate" value="<?php echo $get_row['start_time']?>"  disabled>
				</div>
			</div>
			<div class="row">
				<div class="col s12 m6 l6">	
         			<label for="enddate">End Date</label>
					<input type="date" id="enddate" name="enddate" class="validate" min="<?php echo $get_row['end_date']?>" value="<?php echo $get_row['end_date']?>" required>         	
				</div>
				<div class="col s12 m6 l6">
					<label for="modalETime">End Time</label>
					<input type="time" id="modalETime" name="modalETime" class="validate" min="<?php echo $get_row['end_time']?>" value="<?php echo $get_row['end_time']?>" required>
				</div>
			</div>			
         	<button class="right btn black white-text" type="submit" name="extend">Extend</button>
         	</form>
</body>
</html>