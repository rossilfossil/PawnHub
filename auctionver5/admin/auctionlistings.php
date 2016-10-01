<?php
		include("../connect_to_pms.php");
		include("adminparent.php");
?>
<script type="text/javascript" src="editAuction.js"></script>
<script type="text/javascript" src="maximumAuctionPeriod.js"></script>

<!-- EDIT MODAL  -->
  <div id="editModal" class="modal">
    <div class="modal-content">
    <h4>EDIT AUCTION LISTING</h4>
    <div class="black divider"></div><br>
      <div id="editContent"></div>
    </div>
  </div>
  <!-- END EDIT MODAL -->
  <!-- EXTEND MODAL -->
    <div id="extendModal" class="modal">
    <div class="modal-content">
    <h4>EXTEND AUCTION LISTING</h4>
    <div class="black divider"></div><br>
      <div id="extendContent"></div>
    </div>
  </div>
  <!-- END EXTEND MODAL -->
<div class="container"><br>
	<a href="transac_listing.php" class="btn black white-text z-depth-3"><i class="material-icons left">add</i>Add Listing</a>
	<a href="calendar.php" class="right btn black white-text">Calendar</a>
	<br><div id="listings" class="row">
<?php		
			$get=mysql_query("SELECT * FROM tbl_Auctions
								INNER JOIN tbl_subcategories
								ON tbl_auctions.subcategory_ID = tbl_subcategories.subcategory_ID
								INNER JOIN tbl_categories
								ON tbl_subcategories.category_ID = tbl_categories.category_ID
								INNER JOIN tbl_main_categories
								ON tbl_categories.main_category_ID = tbl_main_categories.main_category_ID
								ORDER BY tbl_Auctions.auction_status ASC 
				");
			if (mysql_num_rows($get)==0){
				echo "<center><h1>No Auctions Listed</h1></center>";
			}
			else {
				while($get_row=mysql_fetch_assoc($get)){
					$auc = $get_row['auction_ID'];
					$sql=mysql_query("SELECT * FROM tbl_Images
											INNER JOIN tbl_Items
											ON tbl_Images.item_ID = tbl_items.item_ID
											INNER JOIN tbl_Auctionitems
											ON tbl_Auctionitems.item_ID = tbl_Items.item_ID
											WHERE tbl_Auctionitems.auction_ID = $auc LIMIT 1
										");
					$get2=mysql_fetch_assoc($sql);
					if(mysql_num_rows($sql)!=0){
						$pic = $get2['item_image'];
					}
					else{
						$pic = "default.png";
					}
					$buttontext = "";
					$aucid = $get_row['auction_ID'];
					if ($get_row['auction_status'] == 0){
							$buttontext = '<input class="btn black" type="submit" name="bid" value="EDIT" onclick="editAuction('.$aucid.')">';
					}	
					else if($get_row['auction_status'] == 1){
						$buttontext = '<input class="btn black" type="submit" name="bid" value="EXTEND" onclick="extendAuction('.$aucid.')">';
					}
					$bidders = mysql_num_rows(mysql_query("SELECT DISTINCT bidder_ID FROM tbl_Bids WHERE auction_ID = $auc"));
	?>						
					<div class="col s12 m6 l4">
  						<div class="card somehowsmall">
							<div class="card-image">
								<img class="activator" style="height:250px" src="../uploads/<?php echo $pic?>">
							</div>
							<div class="card-content"> <!-- mb_strimwidth($get_row['auction_name'], 0, 10, "...") ; -->
								<span class="card-title activator grey-text text-darken-4"><?php echo mb_strimwidth($get_row['auction_name'], 0, 20, '...')?><i class="material-icons right">more_vert</i></span>
								<div class="row">	
									<div class="col s5"><?php echo "₱". $get_row['current_price']?></div>
									<div class="col s7">
									<!-- <form action="" method="POST"> -->
										<input type="hidden" name="auctionid" value="<?php echo $get_row['auction_ID']?>">
										<div class="col push-s2">
										<?php echo $buttontext?>
										</div>
									<!-- </form> -->
									</div>
								</div>
							</div>
							<div class="card-reveal">
								<span class="card-title grey-text text-darken-4"><?php echo mb_strimwidth($get_row['auction_name'], 0, 20, '...')?><i class="material-icons right">close</i></span>
								<p><?php echo $get_row['auction_description']?></p>
								<p><b>Time Left</b>:
								<?php
									//Convert to date
									$datestr=$get_row['end_date']." ".$get_row['end_time'];//Your date
									$date=strtotime($datestr);//Converted to a PHP date (a second count)

									//Calculate difference
									$diff=$date-time();//time returns current time in seconds
									$days=floor($diff/(60*60*24));//seconds/minute*minutes/hour*hours/day)
									$hours=round(($diff-$days*60*60*24)/(60*60));

									//Report
									if ($get_row['auction_status'] == 1 OR $get_row['auction_status'] == 0){
										echo "$days days $hours hours";
									}
									else{
										echo "Ended";
									}

								?>
								</p>
								<p><b>Current Price:</b> <?php echo $get_row['current_price']?>php</p>
								<p><b>Start Price:</b> <?php echo $get_row['starting_amount']?>php</p>
								<p><b>Auction Category: </b><?php echo $get_row['subcategory_name']?></p>
								<p><b>Starting Date:</b> 
									<?php echo date("M jS, Y", strtotime($get_row['start_date']));
									?>
								</p>
								<p><b>Bidders:</b> <?php echo $bidders?></p>
							</div>
						</div>	
					</div>
	<?php
			}
		}
	?>
	</div>
</div>

<?php
	if(isset($_POST['edit'])){
		$id = $_POST['modalID']; // id ng dating auction
		$sql = mysql_fetch_assoc(mysql_query("SELECT * FROM tbl_biddingConstants WHERE bc_ID = 1"));
		$deadlineperiod = $sql['deadline_period'];
		$auctionname = $_POST['modalName'];
		$auctiondesc = $_POST['modalDesc'];
		$startdate = $_POST['modalSDate'];
		$starttime = $_POST['modalSTime'];
		$enddate = $_POST['enddate'];
		$endtime = $_POST['modalETime'];
		$deadlinedate = date("Y-m-d",strtotime("+$deadlineperiod hours",strtotime($enddate)));
		$deadlinetime = $endtime;
		// $sql = "INSERT INTO tbl_Auctions(auction_name,auction_description,starting_amount,current_price,start_date,start_time,end_date,end_time,increment_id,subcategory_id,auction_status,deadline_date,deadline_time) values('$auctionname','$auctiondesc','$startingamount','$startingamount','$startdate','$starttime','$enddate','$endtime','$incrementid','$subcat','0','$deadline_date','$deadline_time')";
		$sql ="UPDATE tbl_Auctions
			SET auction_name = '$auctionname',auction_description = '$auctiondesc',start_date = '$startdate',start_time = '$starttime',end_date = '$enddate',end_time = '$endtime',deadline_date = '$deadlinedate',
			deadline_time = '$deadlinetime'
		WHERE auction_ID = $id";
		$res = mysql_query($sql) or die("Error in Query: ".mysql_error());
		echo "<script>alert('Auction Details Edited!');
			window.location.href = 'auctionlistings.php';
		</script>";
	}

		if(isset($_POST['extend'])){
		$id = $_POST['modalID']; // id ng dating auction
		$sql = mysql_fetch_assoc(mysql_query("SELECT * FROM tbl_biddingConstants WHERE bc_ID = 1"));
		$enddate = $_POST['enddate'];
		$endtime = $_POST['modalETime'];
		$deadlinedate = date("Y-m-d",strtotime("+$deadlineperiod hours",strtotime($enddate)));
		$deadlinetime = $endtime;
		// $sql = "INSERT INTO tbl_Auctions(auction_name,auction_description,starting_amount,current_price,start_date,start_time,end_date,end_time,increment_id,subcategory_id,auction_status,deadline_date,deadline_time) values('$auctionname','$auctiondesc','$startingamount','$startingamount','$startdate','$starttime','$enddate','$endtime','$incrementid','$subcat','0','$deadline_date','$deadline_time')";
		$sql ="UPDATE tbl_Auctions
			SET end_date = '$enddate',end_time = '$endtime',deadline_date = '$deadlinedate',
			deadline_time = '$deadlinetime'
		WHERE auction_ID = $id";
		$res = mysql_query($sql) or die("Error in Query: ".mysql_error());
		echo "<script>alert('Auction Extended!');
			window.location.href = 'auctionlistings.php';
		</script>";
	}
?>
