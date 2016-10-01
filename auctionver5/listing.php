<?php
    include('connect_to_pms.php');	
	$today = date("Y-m-d");
	$currentTime = date("G:i:s");

    $_SESSION['redirect']="listing.php";
	if(!isset($_SESSION['userId'])){
        include('homepageparent.php');
        $user=-1;
    }
    else{ 
        $user = $_SESSION['userId'];
        include('accessgrantedparent.php');		
    }

	if (isset($_SESSION['auction_id'])){	
		$auctionid = $_SESSION['auction_id'];
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
		if ($get_row['auction_status']==2){
    		$_SESSION['checkoutconfirmation'] = 1;
    	}
		$bidders = mysql_num_rows(mysql_query("SELECT DISTINCT bidder_ID FROM tbl_Bids WHERE auction_ID = $auctionid"));
	}
	$start_list = date("M jS, Y", strtotime($get_row['end_date']))." ".date("g:i:s a", strtotime($get_row['end_time']));
	$end_list = date("M jS, Y", strtotime($get_row['start_date']))." ".date("g:i:s a", strtotime($get_row['start_time']));
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
<script type="text/javascript">
	$(document).ready(function(){
	    $('#tableOutput').DataTable({
	    "bLengthChange": false,
	    "pageLength" : 5
	    });
	   }); 

</script>
<link rel="stylesheet" type="text/css" href="css/mycss.css">	
</head>
<body>	
	<div class="row" id="notification"></div>
	<div id="listingcontainer" class="row">
		<div class="col l4 s12"><!-- slider and countdown -->
			<div id ="jsalarm_ct" class="black white-text" style="font-size:30px;">	</div>
			<div class="slider">
    			<ul class="slides">
				    <?php
						$getimg = mysql_query("SELECT * FROM tbl_Images
						 					INNER JOIN tbl_Items
						 					ON tbl_Images.item_ID = tbl_items.item_ID
						 					INNER JOIN tbl_Item
						 					ON tbl_items.itemId = tbl_Item.itemId
						 					INNER JOIN tbl_Auctionitems
						 					ON tbl_Auctionitems.item_ID = tbl_Items.item_ID
						 					WHERE tbl_Auctionitems.auction_ID = $auctionid");
						 if(!mysql_num_rows($getimg)==0){
						 	while($get_img = mysql_fetch_assoc($getimg)){
								?>
								<li>
									<img src="uploads/<?php echo $get_img['item_image']?>">
							        <div class="caption center-align">
							        	<br><br><br><br><br><br><br><br><br><br><br><br><br>
          								<h4 class="white black-text text-lighten-3 center"><?php echo $get_img['itemName']?></h4>
        							</div>
								</li>
								<?php
							}
    			?>
    			<?php
						}
						else{
								?>
									<img class="" style=" width: 100%; height: 100%; " src="uploads/default.png">
								<?php
							}	
						// }
    				?>
    			</ul>
  			</div>
		</div>
		<div class="col l4 s12">
			<div class="row">
				<p><h4><?php echo $get_row['auction_name'];?></h4></p>
				<p><h5>
				<!-- <textarea class="materialize-textarea black-text" disabled="">	 -->
				<?php echo trim($get_row['auction_description']);?>
				<!-- </textarea> -->
				</h5></p>
			</div>
			<div class="row">
				<p><h5><b>Current Price:</b> <?php echo $get_row['current_price'];?>php</h5></p>
				<p><h5><b>Minimum Bid: </b><?php echo $get_row['current_price']+$get_row['increment_amount']?>php (<?php echo $get_row['current_price'];?>php + <?php echo $get_row['increment_amount']?>php)</h5></p>
				<form action="bid.php" method="POST">
					<div class="row">
    					<div class="input-field col s12 m6 l4">
    						<input name="auctionid" id="auctionid" type="hidden" value="<?php echo $auctionid ?>">
							<input name="bid" id="bid" type="number" step="0.01" class="black-text validate" min="<?php echo $get_row['current_price']+$get_row['increment_amount']?>" REQUIRED>
							<label for="bid" class="black-text">Place Bid</label>
						</div>
						<div class="input-field col s12 m6 l4">
							<input class="btn black" type="submit" id="submitbid" name="submitbid" value="Submit Bid">
						</div>
					</div>
				</form>
			</div>

			<div class="row">
				<!-- Modal Structure -->
				<div id="bidsmodal" class="modal">
					<div class="modal-content" >
						<h4><b>Bid History</b></h4>
						
						<div class="divider"></div>
						<br>						
							<?php
								$get=mysql_query("SELECT * FROM tbl_Bids 
									INNER JOIN tbl_Bidders
									ON tbl_Bids.bidder_ID = tbl_Bidders.bidder_ID
									WHERE auction_id = $auctionid 
									AND bid_status != 1
									ORDER BY bid_id DESC
									");
								if (mysql_num_rows($get)==0){
									echo "<center><h4>No Bids has been made</h4></center>";
										$highestbidder = "No Bidders yet";
										$highestbidderid = 0;;
								}
								else {
									?>
									<table id="tableOutput" class="highlight">
										<thead>
											<th>Bid</th>
											<th>Bidder</th>
											<th>Date</th>
										</thead>
										<tbody>
									<?php
									while($get_row=mysql_fetch_assoc($get)){
										if (!isset($highestbidder)){
											$highestbidderid = $get_row['bidder_ID'];
											$highestbidder = $get_row['bidder_username'];;
										}
										?>
										<tr>
											<td><?php echo $get_row['bid_amount']?>php</td>
											<td><?php echo $get_row['bidder_username']?></td>
											<td><?php echo date("M jS, Y", strtotime($get_row['bid_date']))." ".date("g:i:s a", strtotime($get_row['bid_time'])); ?></td>
										</tr>
										<?php
									}
									?>
									</tbody>
									</table>
									<!-- <button class="btn black white-text">Retract Bid</button> -->
									<?php
								}	
							?>							
						</div>
					</div>
				</div>	
			</div>
			<div class="row">
				<div class="col l4 s12 m12 grey">	
					<!-- <center><h5>Auction Item</h5></center> -->
					<table id="tableOutput" class="centered highlight">
						<thead>
							<!-- <th>ID</th> -->
							<th>Auction Item</th>
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
									<!-- <td><?php //echo $getitem['item_ID']?></td> -->
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
					<a class="modal-trigger black-text" href="#bidsmodal" data-target="bidsmodal"><i class="material-icons">history</i><b>Bid History</b><span class="badge black white-text"><?php echo mysql_num_rows($get)?> Bids</span></a>
					<p><i class="material-icons">face</i><b>Highest Bidder </b>:<?php echo $highestbidder?></p>
					<p><i class="material-icons">face</i><b>Bidders </b>:<?php echo $bidders?></p>
					<!--
					<p><i class="material-icons">face</i><b>Visitors </b>:<?php // echo $visitors?></p>
					-->
				</div>
			</div>
		</div>
	
</div>
	
<script type="text/javascript">
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
<script type="text/javascript">
	var before="AUCTION ENDS"
	var current=" AUCTION ENDED"
	var montharray=new Array("Jan","Feb","Mar","Apr","May","Jun","Jul","Aug","Sep","Oct","Nov","Dec")

	function countdown(yr,m,d,hr,min,sec){
	theyear=yr;themonth=m;theday=d;thehr=hr;themin=min;thesec=sec
	var today=new Date()
	var todayy=today.getYear()
	if (todayy < 1000)
		todayy+=1900
		var todaym=today.getMonth()
		var todayd=today.getDate()
		var todayh=today.getHours()
		var todaymin=today.getMinutes()
		var todaysec=today.getSeconds()
		var todaystring=montharray[todaym]+" "+todayd+", "+todayy+" "+todayh+":"+todaymin+":"+todaysec
		futurestring=montharray[m-1]+" "+d+", "+yr+" "+hr+":"+min+":"+sec
		dd=Date.parse(futurestring)-Date.parse(todaystring)
		dday=Math.floor(dd/(60*60*1000*24)*1)
		dhour=Math.floor((dd%(60*60*1000*24))/(60*60*1000)*1)
		dmin=Math.floor(((dd%(60*60*1000*24))%(60*60*1000))/(60*1000)*1)
		dsec=Math.floor((((dd%(60*60*1000*24))%(60*60*1000))%(60*1000))/1000*1)
		if((dday==0&&dhour==0&&dmin==0&&dsec==0) || (dday<0&&dhour<0&&dmin<0&&dsec<0)) {
			document.getElementById("jsalarm_ct").innerHTML= "<h6><center>" + current +"</center></h6>"
			if (<?php echo $enddate?> == <?php echo $today?>){
				Materialize.toast('Auction Ended!', 4000,'black')
				document.getElementById('submitbid').disabled = true;
				document.getElementById('bid').disabled = true;
				auctionEnd(<?php echo $auctionid ?>); // ajax	

				if (<?php echo $user ?> == <?php echo $highestbidderid ?>) {
					Materialize.toast('Congratulations!',4000,'black')
					document.getElementById('notification').innerHTML = "<div class='container myfont'><h4><center>You've Won this Item</center></h4><a href='checkout.php' class=' btn black white-text'>Checkout</a></div>";
				}
			}
			// clearinterval
			return
		}
	else
		document.getElementById("jsalarm_ct").innerHTML= "<center> " + dday+ " : "+dhour+" : "+dmin+" : "+dsec+"" + "<h6> DAYS &nbsp;&nbsp; HRS&nbsp;&nbsp; MINS &nbsp;&nbsp; SECS </h6> </center>"
		setTimeout("countdown(theyear,themonth,theday,thehr,themin,thesec)",1000)
		}


if(<?php echo $user?> == -1){
	document.getElementById('submitbid').disabled = true;
	document.getElementById('bid').disabled = true;
	document.getElementById('notification').innerHTML = "<center><h4>Please Log in to Place Bid</h4></center>";
}	

// check Auction Status
if (<?php echo $auctionstatus?> == 1){
	<?php
		$visitors = $visitors + 1;
		$sql = "UPDATE tbl_Auctions SET auction_visitors = $visitors WHERE auction_ID = $auctionid";
		$res = mysql_query($sql) or die("Error in Query: ".mysql_error());
	?>

	if ('<?php echo $enddate?>' >= '<?php echo $today?>'){ // kung sa present o future pa ung deadline
		if(<?php echo $enddate?> == <?php echo $today?>) { // kung ngayon lang talaga
			// isang if pa para sa time
			if('<?php echo strtotime($stop)?>' <= '<?php echo strtotime(date("G:i:s"));?>'){ // stop, current time
				Materialize.toast('Auction Ended!',4000,'black')
				auctionEnd(<?php echo $auctionid ?>);				
				if (<?php echo $user?> == <?php echo $highestbidderid?>) { // highbidder
					if(<?php echo $auctionstatus?> >= 5){ // is mas mataas sa 5 ung status
						document.getElementById('notification').innerHTML = "<div class='container myfont'><h4><center>Item Checked out</center></h4>";
					}
					else{	
						document.getElementById('notification').innerHTML = "<div class='container myfont'><h4><center>You've Won this Item</center></h4><a href='checkout.php' class=' btn black white-text'>Checkout</a></div>";
					}
				}
			}
			else{
				Materialize.toast('Auction Will End Today', 4000,'black')	
				if (<?php echo $user?> == <?php echo $highestbidderid?>) {
					document.getElementById('notification').innerHTML = "<div class='container myfont'><h4><center>You are winning this item</center></h4>";
				}
				// no bids yet, and kung meron man hindi ikaw ung highest bidder
				countdown(<?php echo $endyear?>,<?php echo $endmonth?>,<?php echo $endday?>,<?php echo $stophour?>,<?php echo $stopmin?>,<?php echo $stopsec?>)
			}
		}
		else{
		// kung future
			Materialize.toast('Auction Ongoing', 4000,'black')
			if (<?php echo $user?> == <?php echo $highestbidderid?>) {
				document.getElementById('notification').innerHTML = "<div class='container myfont'><h4><center>You are winning this item</center></h4>";
			}
				countdown(<?php echo $endyear?>,<?php echo $endmonth?>,<?php echo $endday?>,<?php echo $stophour?>,<?php echo $stopmin?>,<?php echo $stopsec?>)
		}
	}
	else{ // hindi sya sa present or future, bali nakaraan na ,meaning tapos na
		Materialize.toast('Auction Ended!', 4000,'black')
		document.getElementById('submitbid').disabled = true;
		document.getElementById('bid').disabled = true;
		auctionEnd(<?php echo $auctionid ?>);						
		if (<?php echo $user?> == <?php echo $highestbidderid?>) { // highbidder
			if(<?php echo $auctionstatus?> >= 5){ // is mas mataas sa 5 ung status
					document.getElementById('notification').innerHTML = "<div class='container myfont'><h4><center>Item Checked out</center></h4>";
			}
			else{	
				document.getElementById('notification').innerHTML = "<div class='container myfont'><h4><center>You've Won this Item</center></h4><a href='checkout.php' class=' btn black white-text'>Checkout</a></div>";
			}
		}
	}	
}

else{
	Materialize.toast('Auction Ended', 4000,'black')	
	document.getElementById('submitbid').disabled = true;
	document.getElementById('bid').disabled = true;
	auctionEnd(<?php echo $auctionid ?>);			
	// check if STATUS is 2 3 and 4 //
	//
	//
	//
	//
	//
	//
	//
	//
	//
	//
	//
	//
	//
	//
	//
	//
	//
	//
	//
	//
	//
	//
	//
	//
	//
	//
	//
	//
	//
	//
	//
	//
	//
	//
	//
	//
	//
	//
	//
	//
		if (<?php echo $user?> == <?php echo $highestbidderid?>) { // highbidder
			if(<?php echo $auctionstatus?> >= 5){ // is mas mataas sa 5 ung status
				if(<?php echo $auctionstatus?> == 6){
					document.getElementById('notification').innerHTML = "<div class='container myfont'><h4><center>Forfeited</center></h4>";
				}	
				else
					document.getElementById('notification').innerHTML = "<div class='container myfont'><h4><center>Item Checked out</center></h4>";
			}
			else{	
				document.getElementById('notification').innerHTML = "<div class='container myfont'><h4><center>You've Won this Item</center></h4><a href='checkout.php' class=' btn black white-text'>Checkout</a></div>";
			}
		}
}
</script>