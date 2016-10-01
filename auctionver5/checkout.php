<?php
    include('connect_to_pms.php');	
	$today = date("Y-m-d");
	$currentTime = date("G:i:s");
    $_SESSION['redirect']="checkout.php";
    // checks if a user logs in before accessing the page
    if(!isset($_SESSION['userId'])){
        include('homepageparent.php');
        echo "<center><h1>Please Log in!</h1></center>";
        return;
    }
    else{ 
        $user = $_SESSION['userId'];
        include('accessgrantedparent.php');
    }

	// checks if there is a listing selected
	if (isset($_SESSION['auction_id'])){	
		$auctionid = $_SESSION['auction_id'];
	}
	else{
		echo "<center><h1>No Listing selected!</h1></center>";
		return;
	} 

	// if(!isset($_SESSION['checkoutconfirmation'])){
	// 	echo "<center><h1>No Checkouts selected!</h1></center>";
	// 	return;
	// }
	//unset($_SESSION['checkoutconfirmation']);

	$get=mysql_query("SELECT * FROM tbl_Auctions 
		WHERE auction_ID = $auctionid 
		");
		//AND auction_status = 2
	// checks if the listing still exists
	if (mysql_num_rows($get)==0){
		echo "<center><h1>Nothing to Display</h1></center>";
		return;
	} 
	else{	
		$get_row = mysql_fetch_assoc($get);
		$auctionid = $get_row['auction_ID'];
		$auctionstatus = $get_row['auction_status'];
		$get_bidder = mysql_fetch_assoc(mysql_query("SELECT * FROM tbl_Bidders 
														INNER JOIN tbl_Cities
														ON tbl_bidders.bidder_city = tbl_Cities.city_ID
														INNER JOIN tbl_Provinces
														ON tbl_cities.province_ID = tbl_Provinces.province_ID
														WHERE bidder_ID = $user"));
		$bidder_firstname = $get_bidder['bidder_firstname'];
		$bidder_middlename = $get_bidder['bidder_middlename'];
		$bidder_lastname = $get_bidder['bidder_lastname'];
		$bidder_province = $get_bidder['province_name'];
		$provincecode = $get_bidder['province_ID'];
		$bidder_city = $get_bidder['city_name'];
		$citycode = $get_bidder['city_ID'];
		$bidder_barangay = $get_bidder['bidder_barangay'];
		$bidder_street = $get_bidder['bidder_street'];
		$bidder_housenumber = $get_bidder['bidder_housenumber'];
	}
?>

</head>
<script type="text/javascript" src="admin/validation.js"></script>
<script type="text/javascript" src="admin/getCity.js"></script>
<script type="text/javascript">
	function rad(num) {
		if (num == 0) {
			document.getElementById('gen').style.display = "block";
			document.getElementById('jew').style.display = "none";				
			addressRadio(1);
		}
		else{
			document.getElementById('gen').style.display = "none";
			document.getElementById('jew').style.display = "block";
		}
	document.getElementById("tayp2").value = num;
	}
	function addressRadio(option){
		if (option == 1){
			document.getElementById("delivery_province").value = "<?php echo $provincecode?>";
			setCity(<?php echo $provincecode?>);
			document.getElementById("delivery_city").value = "<?php echo $citycode?>";
			document.getElementById("delivery_barangay").value = "<?php echo $bidder_barangay?>";
			document.getElementById("delivery_street").value = "<?php echo $bidder_street?>";
			document.getElementById("delivery_housenumber").value = "<?php echo $bidder_housenumber?>";
		}
		else if (option == 2){
			document.getElementById("delivery_province").value = "";
			document.getElementById("delivery_city").value = "";
			document.getElementById("delivery_barangay").value = "";
			document.getElementById("delivery_street").value = "";
			document.getElementById("delivery_housenumber").value = "";
		}
	}
</script>
<body>	
	<div id="listingcontainer" class="container myfont center row-width2">
		<div class="row card blue-grey lighten-4"> <!-- AS A WHOLE -->
			<div class="col l12 m12">
				<center><h4>CHECK OUT FORM</h4></center>
				<div class="black divider"></div>
				<h5>BIDDER'S INFORMATION</h5>
				<div class="row ">
					<div class="input-field col s12 m4 l4">
						<input id="first_name" type="text" class="black-text center" value="<?php echo $bidder_firstname?>" DISABLED>
						<label class="active black-text" for="first_name">First Name</label>
					</div>
					<div class="input-field col s12 m4 l4">
						<input id="middle_name" type="text" class="black-text center" value="<?php echo " ".$bidder_middlename?>" DISABLED>
						<label class="active black-text" for="middle_name">Middle Name</label>
					</div>
					<div class="input-field col s12 m4 l4">
						<input id="last_name" type="text" class="black-text center" value="<?php echo $bidder_lastname?>" DISABLED>
						<label class="active black-text" for="last_name">Last Name</label>
					</div>
				</div>
				<div class="row">
					<div class="input-field col s12 m6 l6">
						<input id="province" type="text" class="black-text center" value="<?php echo $bidder_province?>" DISABLED>
						<label class="active black-text" for="province">Province</label>
					</div>
					<div class="input-field col s12 m6 l6">
						<input id="city" type="text" class="black-text center" value="<?php echo $bidder_city?>" DISABLED>
						<label class="active black-text" for="city">City</label>
					</div>
				</div>
				<div class="row">
					<div class="input-field col s12 m4 l4">
						<input id="barangay" type="text" class="black-text center" value="<?php echo $bidder_barangay?>" DISABLED>
						<label class="active black-text" for="barangay">Barangay</label>
					</div>
					<div class="input-field col s12 m4 l4">
						<input id="street" type="text" class="black-text center" value="<?php echo $bidder_street?>" DISABLED>
						<label class="active black-text" for="street">Street</label>
					</div>
					<div class="input-field col s12 m4 l4">
						<input id="housenumber" type="text" class="black-text center" value="<?php echo $bidder_housenumber?>" DISABLED>
						<label class="active black-text" for="housenumber">House Number</label>
					</div>
				</div>
				<div class="black divider"></div>
				<h5>ITEM INFORMATION</h5>
			</div>
			<div class="col l5 s12">
				<div class="slider" >
	    			<ul class="slides">
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
								<li>
									<img class="" style=" width: 100%; height: 100%; " src="uploads/<?php echo $get_img['item_image']?>">
								</li><?php
							}
						}
						else{
								?>
									<img class="" style=" width: 100%; height: 100%; " src="uploads/default.png">
								<?php
							}
    				?>
	    			</ul>
	  				</div>
			</div>
			<div class="col l6 m12 s12 myfont">
				<div class="row">
					<br><br>
					<p><h4><?php echo $get_row['auction_name'];?></h4></p>
					<p><h5><?php echo $get_row['auction_description'];?></h5></p>
				</div>
				<div class="row">
					<p><h5><b>Price:</b> <?php echo $get_row['current_price'];?>php</h5></p>
				</div>
				<div class="row">	
					<div class="col l6 m3 s12">
						<i class="material-icons">event</i><b>Start Date</b>
					</div>
					<div class="col l6 m3 s12">
						<?php echo date("M jS, Y", strtotime($get_row['start_date']))." ".date("g:i:s a", strtotime($get_row['start_time']))?>
					</div>
					<div class="col l6 m3 s12">
						<i class="material-icons">event</i><b>End Date</b>
					</div>
					<div class="col l6 m3 s12">
						<?php echo date("M jS, Y", strtotime($get_row['end_date']))." ".date("g:i:s a", strtotime($get_row['end_time']))?>
					</div>
				</div>
			</div>
			<div class="col l12 m12 s12">
					<!-- <center><h5>Auction Item</h5></center> -->
					<table class="centered highlight">
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
			</div>
			<!-- </div>
			<div class="row"> -->
				<div class="col l12 m12 s12">
					<div class="black divider"></div>
					<h5>CLAIMING PREFERENCE</h5>
					<div class="row">
						<div class="col l6 m6 s12">				
							<input type="radio" value="0" name = "tayp" id="radio1" onclick = "rad(0)" required/>
								<label for="radio1" class="black-text"><h6><i class="material-icons left">motorcycle</i>Delivery</h6></label>
						</div>	
						<div class="col l6 m6 s12">
							<input type="radio" value="1" name = "tayp" id="radio2" onclick = "rad(1)" required/>
								<label for="radio2" class="black-text"><h6><i class="material-icons left">store</i>Pick-Up </h6></label>
						</div>		
					</div>


					<div class="black divider"></div>
					<div id = "gen" class="col l12" style = "display:none">
						<h5><center>DELIVERY</center></h5>
						<form action="" method="POST">
							<div class="row center">
								<div class="col l6 m6 s12">
									<input type="radio"  value="0" name = "addresstayp" id="addressradio1" onclick = "addressRadio(1)" checked required/>
									<label for="addressradio1" class="black-text"><h6>Use Home Address</h6></label>
								</div>	
								<div class="col l6 m6 s12">
									<input type="radio" value="1" name = "addresstayp" id="addressradio2" onclick = "addressRadio(2)" required/>
									<label for="addressradio2" class="black-text"><h6>Different Address</h6></label>
								</div>
							</div>	
			<div class="row center">
				<div class="input-field col s12 m6 l6">
					<br>
					<select class="browser-default" name='delivery_province' id='delivery_province' onchange="setCity(this.value)" REQUIRED>
						<option value = "" selected disabled>Select Province:</option>
						<?php
							$get = mysql_query("SELECT * FROM tbl_Provinces ORDER BY province_name ASC");
							if(!mysql_num_rows($get)==0){
								while($get_row = mysql_fetch_assoc($get)){
								?><option value = "<?php echo $get_row['province_ID']; ?>"><?php echo $get_row['province_name']; ?></option>
							<?php
								}
							}
						?>
					</select>
					<label class="black-text active" for="itemid">Province</label>
					<br>
				</div>
				<div class="input-field col s12 m6 l6">
					<br>
					<select class="browser-default" name='delivery_city' id='delivery_city' REQUIRED>
							<option value="" selected disabled>Select City</option>	
							<?php
							$get = mysql_query("SELECT * FROM tbl_Cities ORDER BY city_name ASC");
							if(!mysql_num_rows($get)==0){
								while($get_row = mysql_fetch_assoc($get)){
								?><option value = "<?php echo $get_row['city_ID']; ?>"><?php echo $get_row['city_name']; ?></option>
							<?php
								}
							}
						?>
					</select>

					<label class="black-text active" for="itemid">City</label>
					<br>
				</div>
			</div>
							<div class="row">
								<div class="input-field col s12 m4 l4">
									<input name="delivery_barangay" id="delivery_barangay" type="text" class="black-text validate center" value="<?php echo $bidder_barangay?>" onkeyup = "validateNoSpecs(this.value,'delivery_barangay')" REQUIRED>
									<label class="active black-text" for="barangay">Barangay</label>
								</div>
								<div class="input-field col s12 m4 l4">
									<input name="delivery_street" id="delivery_street" type="text" class="black-text validate center" value="<?php echo $bidder_street?>" onkeyup = "validateNoSpecs(this.value,'delivery_street')" REQUIRED>
									<label class="active black-text" for="street">Street</label>
								</div>
								<div class="input-field col s12 m4 l4">
									<input name="delivery_housenumber" id="delivery_housenumber" type="text" class="black-text validate center" value="<?php echo $bidder_housenumber?>" onkeyup = "validateNoSpecs(this.value,'delivery_housenumber')" REQUIRED>
									<label class="active black-text" for="housenumber">House Number</label>
								</div>
							</div>
							<div class="row">
								<div class="col s12 center">
									<button class="btn btn-large black white-text" name="deliverysubmit" type="submit">Confirm</button>
								</div>
							</div>
						</form>
					</div>	

					<div class="black divider"></div>

					<div id = "jew" class="col l12 m12 s12" style = "display:none">
						<h5><center>PICKUP</center></h5>


						<form action="" method="POST">
							<div class="row center">
								<!-- <div class="col l3 m3 s12 center">
									<center>
									Region
										<select class = "browser-default center" name = 'region' id='region' REQUIRED>
											<option value = "" selected disabled>Select Region</option>
										</select>
									</center>
								</div>
								<div class="col l3 m3 s12 center">
									<center>
									Province
										<select class = "browser-default center" name = 'province' id='province' REQUIRED>
											<option value = "" selected disabled>Select Province</option>
										</select>
									</center>
								</div>
								<div class="col l3 m3 s12 center">
									<center>
									City
										<select class = "browser-default center" name = 'city' id='city' REQUIRED>
											<option value = "" selected disabled>Select City</option>
										</select>
									</center>
								</div> -->
								<!-- <div class="col l3 m3 s12 center"> -->
								<div class="col l4 m4 s12 center">
									<center>
									Branch
										<select class = "browser-default center" name = 'branch' id='branch' REQUIRED>
											
											<option value = "" selected disabled>Select Branch</option>
											<?php
												$get = mysql_query("SELECT * FROM tbl_branch");
												if(!mysql_num_rows($get)==0){
													while($get_row = mysql_fetch_assoc($get)){
													?><option value = "<?php echo $get_row['branchId']; ?>"><?php echo $get_row['branchName']; ?></option>
												<?php
													}
												}
											?>
										</select>
									</center>
								</div>	
								<div class="row center">	
									<div class="col l12 m12 s12">
										You can claim your item in the pawnshop branch near you!
									</div>
									<div class="col l12 m12 s12	">	
										<button class="btn btn-large black white-text" type="submit" name="pickupsubmit">Confirm</button>
									</div>
								</div>

							</div>
						</form>

					</div>

			
				</div>
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
 $(document).ready(function() {
    Materialize.updateTextFields();
  });		
</script>
</body>
</html>

<?php
	if(isset($_POST['pickupsubmit'])){
		$branch = $_POST['branch'];
		
		$sql = "INSERT INTO tbl_Checkouts(bidder_ID,auction_ID,claim_preference) VALUES('$user','$auctionid','1')";
		$res = mysql_query($sql) or die("Error in Query: ".mysql_error());

		$get = mysql_fetch_assoc(mysql_query("SELECT * FROM tbl_Checkouts ORDER BY checkout_ID DESC LIMIT 1"));
		$checkout_ID = $get['checkout_ID'];		

		$sql = "INSERT INTO tbl_Pickups(checkout_ID,branchId) VALUES('$checkout_ID','$branch')";
		$res = mysql_query($sql) or die("Error in Query: ".mysql_error());
		

		// sets the auction to CHECKED OUT
		$sql = "UPDATE tbl_Auctions SET auction_status = 5 WHERE auction_ID = '$auctionid'";
		$res = mysql_query($sql) or die("Error in Query: ".mysql_error());

		// sets the item to CHECKED OUT
		$sql = mysql_query("SELECT * FROM tbl_Items
											INNER JOIN tbl_item
											ON tbl_Items.itemId = tbl_Item.itemId
											INNER JOIN tbl_Auctionitems
											ON tbl_Items.item_ID = tbl_Auctionitems.item_ID
											WHERE tbl_Auctionitems.auction_ID = $auctionid");
						if(!mysql_num_rows($sql)==0){
							while($getitem = mysql_fetch_assoc($sql)){
								$item = $getitem['item_ID'];
								$update = "UPDATE tbl_Items SET item_status = 4 WHERE item_ID = '$item'";
								var_dump($update);
								$res = mysql_query($update) or die("Error in Query: ".mysql_error());									
							}
						}
		
		$sql = "UPDATE tbl_Items SET item_status = 4 WHERE item_ID = '$item'";
		$res = mysql_query($sql) or die("Error in Query: ".mysql_error());
		
		// populates voucher
	
		$sql = "INSERT INTO tbl_Voucher(checkoutId) VALUES('$checkout_ID')";
		$res = mysql_query($sql) or die("Error in Query: ".mysql_error());		
	
		$get = mysql_fetch_assoc(mysql_query("SELECT * FROM tbl_Voucher ORDER BY voucherId DESC LIMIT 1"));
		$voucher_ID = $get['voucherId'];		

		// populates auction payment
		$sql = "INSERT INTO tbl_auction_payment(voucherId) VALUES('$voucher_ID')";
		$res = mysql_query($sql) or die("Error in Query: ".mysql_error());		

		// checkout summary NEW TAB
		// account

		$_SESSION['voucher'] = $voucher_ID;

		echo "
			<script>
				window.open('form-auction-voucher.php','_blank');
			</script>
		";		

		echo "
			<script>
				window.location.href='home.php';
			</script>
		";		

	}
	if(isset($_POST['deliverysubmit'])){
		$delivery_city = $_POST['delivery_city'];
		$delivery_province = $_POST['delivery_province'];
		$delivery_barangay = trim($_POST['delivery_barangay']);
		$delivery_street = trim($_POST['delivery_street']);
		$delivery_housenumber = trim($_POST['delivery_housenumber']);

		$sql = "INSERT INTO tbl_Checkouts(bidder_ID,auction_ID,claim_preference) VALUES('$user','$auctionid','0')";
		$res = mysql_query($sql) or die("Error in Query: ".mysql_error());

		$get = mysql_fetch_assoc(mysql_query("SELECT * FROM tbl_Checkouts ORDER BY checkout_ID DESC LIMIT 1"));
		$checkout_ID = $get['checkout_ID'];		

		$sql = "INSERT INTO tbl_Deliveries(checkout_ID,delivery_province,city_ID,delivery_barangay,delivery_street,delivery_housenumber) VALUES('$checkout_ID','$delivery_province','$delivery_city','$delivery_barangay','$delivery_street','$delivery_housenumber')";
		$res = mysql_query($sql) or die("Error in Query: ".mysql_error());
	
		$sql = "UPDATE tbl_Auctions SET auction_status = 5 WHERE auction_ID = '$auctionid'";
		$res = mysql_query($sql) or die("Error in Query: ".mysql_error());

		$sql = mysql_query("SELECT * FROM tbl_Items
											INNER JOIN tbl_item
											ON tbl_Items.itemId = tbl_Item.itemId
											INNER JOIN tbl_Auctionitems
											ON tbl_Items.item_ID = tbl_Auctionitems.item_ID
											WHERE tbl_Auctionitems.auction_ID = $auctionid");
						if(!mysql_num_rows($sql)==0){
							while($getitem = mysql_fetch_assoc($sql)){
								$item = $getitem['item_ID'];
								$update = "UPDATE tbl_Items SET item_status = 4 WHERE item_ID = '$item'";
								$res = mysql_query($update) or die("Error in Query: ".mysql_error());									
							}
						}
		/*
		$sql = "UPDATE tbl_Items SET item_status = 4 WHERE item_ID = '$item'";
		$res = mysql_query($sql) or die("Error in Query: ".mysql_error());
		*/
		$sql = "INSERT INTO tbl_Voucher(checkoutId) VALUES('$checkout_ID')";
		$res = mysql_query($sql) or die("Error in Query: ".mysql_error());		

		$get = mysql_fetch_assoc(mysql_query("SELECT * FROM tbl_Voucher ORDER BY voucherId DESC LIMIT 1"));
		$voucher_ID = $get['voucherId'];		
	
		$get = mysql_fetch_assoc(mysql_query("SELECT * FROM tbl_Deliveries ORDER BY delivery_ID DESC LIMIT 1"));
		$delivery_ID = $get['delivery_ID'];		

		// populates delivery receipt


		$get = mysql_fetch_assoc(mysql_query("SELECT * FROM tbl_Regions
											INNER JOIN tbl_Provinces
											ON tbl_Regions.region_ID = tbl_Provinces.region_ID
                                            INNER JOIN tbl_cities
                                            ON tbl_Cities.province_ID = tbl_Provinces.province_ID
                                            WHERE city_ID = $delivery_city
											"));
		$delivery_fee = $get['delivery_fee'];		
		$date = date("Y-m-d");
		$time = date("G:i:s");
		$sql = "INSERT INTO tbl_delivery_receipts(delivery_ID,delivery_fee,delivery_date,delivery_time) VALUES('$delivery_ID','$delivery_fee','$date','$time')";
		$res = mysql_query($sql) or die("Error in Query: ".mysql_error());		

		// checkout summary

		// checkout expiration date
		// echo date('Y-m-d', strtotime("+30 days"));

		$_SESSION['voucher'] = $voucher_ID;

		echo "
			<script>
				window.open('form-auction-voucher.php','_blank');
			</script>
		";		

		echo "
			<script>
				window.location.href='home.php';
			</script>
		";		

	}
?>