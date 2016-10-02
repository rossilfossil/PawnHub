<?php
	include('../connect_to_pms.php');	
	if(!isset($_SESSION['branchId'])){
		include("adminhomeparent.php");
        echo "<br><br><br><br><br><br><br><center><h1>You have no access to this page</h1></center>";
		return;		
	}
	include('adminparent.php');	

?>
<!-- Modal Structure -->
  <div id="viewModal" class="modal">
    <div class="modal-content">
    <h4>Auction Details</h4>
    <div class="black divider"></div><br>
      <div id="viewContent"></div>
    </div>
    <div class="modal-footer">
      <a href="#!" class=" modal-action modal-close waves-effect waves-green btn-flat">Close</a>
    </div>
  </div>
<script type="text/javascript" src="viewAuction.js"></script>
<script type="text/javascript">

$(document).ready(function(){
    $('#tableOutput').DataTable({
    "bLengthChange": false,
    "pageLength" : 5
    });
})

	$(document).ready(function() {
		Materialize.updateTextFields();
	});
    $('.collapsible').collapsible({
      accordion : false // A setting that changes the collapsible behavior to expandable instead of the default accordion style
    });	
</script>

<div class="myfont container">
    <div class="row">
		<div class="col l12">
			<h4><center>HOME DELIVERIES</center></h4>
			<div class="black divider"></div>
			<div class="card">
				<table  class="highlight centered" id="tableOutput">
					<thead>
						<th>ID</th>
						<th>Winner</th>
						<th>Delivery Address</th>
						<th>Price</th>
						<th>Status</th>
						<th></th>
						<th></th>
					</thead>
					<tbody>
						<?php
							$get = mysql_query("SELECT * FROM tbl_Checkouts
												INNER JOIN tbl_Bidders
												ON tbl_Bidders.bidder_ID = tbl_Checkouts.bidder_ID
												INNER JOIN tbl_Auctions
												ON tbl_auctions.auction_ID = tbl_Checkouts.auction_ID
												INNER JOIN tbl_Deliveries
												ON tbl_Deliveries.checkout_ID = tbl_Checkouts.checkout_ID
												INNER JOIN tbl_delivery_receipts
												ON tbl_delivery_receipts.delivery_ID = tbl_Deliveries.delivery_ID
         										INNER JOIN tbl_Cities
         										ON tbl_Cities.city_ID = tbl_Deliveries.city_ID
         										INNER JOIN tbl_Provinces
         										ON tbl_Cities.province_ID = tbl_Provinces.province_ID
												WHERE claim_preference = 0
												");
							if(!mysql_num_rows($get)==0){
								while($get_row = mysql_fetch_assoc($get)){
									
									if($get_row['checkout_status'] == 0){
										$statustxt = "Pending";
										$button = '<button name="send" value="0" class="btn black white-text" type="submit"><i class="material-icons" >print</i></button>';
									}
									else if($get_row['checkout_status'] == 1){
										$statustxt = "Ready";
										$button = '<button name="send" value="1" class="btn black white-text" type="submit"><i class="material-icons" >motorcycle</i></button>';
									}
									else if($get_row['checkout_status'] == 2){
										$statustxt = "On Route";
										$button ='	<button name="send" value="2" class="btn black white-text" type="submit"><i class="material-icons" >done</i></button>';
									}
									else if($get_row['checkout_status'] == 3){
										$statustxt = "Delivered";
										$button ='	<button name="send" value="3" class="btn black white-text" type="submit"><i class="material-icons" >done_all</i></button>';
									}
									else if($get_row['checkout_status'] == 4){
										$statustxt = "Redeemed";
										$button = "";
									}
									
						?>
									<tr class="black-text">
										<td><?php echo $get_row['checkout_ID']?></td>
										<td><?php echo $get_row['bidder_firstname']." ".$get_row['bidder_middlename']." ".$get_row['bidder_lastname']?></td>
										<td><?php echo $get_row['delivery_housenumber']." ".$get_row['delivery_street']." Street,".$get_row['delivery_barangay']." ".$get_row['city_name']." ,".$get_row['province_name']?></td>
										
										<td>PHP<?php echo $get_row['current_price']+$get_row['delivery_fee']?></td>
										<td><?php echo $statustxt?></td>
										<td><button class="btn black white-text" onclick="viewContent(<?php echo $get_row['auction_ID']?>)">View</button></td>
										<td>
										<form action="" method="POST">
											<input type="hidden" name="id" value="<?php echo $get_row['checkout_ID']?>">
											<input type="hidden" name="aucid" value="<?php echo $get_row['auction_ID']?>">
											<input type="hidden" name="receipt" value="<?php echo $get_row['receipt_ID']?>">
											<input type="hidden" name="item" value="<?php echo $get_row['item_ID']?>">
											<?php echo $button?>
										</form>
									</tr>
						<?php
								}
							}
						?>
					</tbody>
				</table>
			</div>
		</div>	
	</div>
<script type="text/javascript">
	$(document).ready(function() {
		Materialize.updateTextFields();
	});
	$('.collapsible').collapsible({
		accordion : false // A setting that changes the collapsible behavior to expandable instead of the default accordion style
	}); 
	$('.modal-trigger').leanModal({
		dismissible: true, // Modal can be dismissed by clicking outside of the modal
		opacity: .5, // Opacity of modal background
		in_duration: 300, // Transition in duration
		out_duration: 200, // Transition out duration
	});

	$('.dropdown-button').dropdown({
		inDuration: 300,
		outDuration: 225,
		constrain_width: false, // Does not change width of dropdown to that of the activator
		hover: true, // Activate on hover
		gutter: 0, // Spacing from edge
		belowOrigin: false, // Displays dropdown below the button
		alignment: 'left' // Displays dropdown with edge aligned to the left of button
	});
</script>		

<?php
	if(isset($_POST['send'])){
		$id = $_POST['id']; // checkout id
		$aucid = $_POST['aucid']; // auction id
		$mode = $_POST['send'];
		$receipt = $_POST['receipt'];
		
		if ($mode == 0){ // pending
			// print receipt
			// open new tab
			// print from delivery receipts
			$_SESSION['delivery_receipt'] = $receipt;
			echo "<script>
					alert('Print Delivery Receipt');
					window.open('form-cash-receipt.php','_blank');
				  </script>";

		}
		else if ($mode == 1){ // ready
			// deliver
			// set status to on route
			$updateListing = 7;
			$updateItem = 6;
			echo "<script>alert('Deliver Item')</script>";
		}
		else if ($mode == 2){ // on route
			$updateListing = 8;
			$updateItem = 7;
			echo "<script>alert('Item Delivered!')</script>";
			// deliver
			// set status to delivered
		}
		else if ($mode == 3){ // delivered
			$updateListing = 9;
			$updateItem = 8;
			$date = date("Y-m-d");
			$time = date("G:i:s");
			$sql = "UPDATE tbl_delivery_receipts SET payment_date = '$date' , payment_time = '$time' WHERE receipt_ID = $receipt";
			//var_dump($sql);
			$res = mysql_query($sql) or die("Error in Query: ".mysql_error());
			echo "<script>alert('Item Paid!')</script>";
			// redeem
			// set status to redeemed
		}
		if ($mode!=0 AND $mode!= 4){	
		$sql = mysql_query("SELECT * FROM tbl_Items
											INNER JOIN tbl_item
											ON tbl_Items.itemId = tbl_Item.itemId
											INNER JOIN tbl_Auctionitems
											ON tbl_Items.item_ID = tbl_Auctionitems.item_ID
											WHERE tbl_Auctionitems.auction_ID = $aucid");
						if(!mysql_num_rows($sql)==0){
							while($getitem = mysql_fetch_assoc($sql)){
								$item = $getitem['item_ID'];
								$update = "UPDATE tbl_Items SET item_status = '$updateItem' WHERE item_ID = '$item'";
//								var_dump($update);
								$res = mysql_query($update) or die("Error in Query: ".mysql_error());									
							}
						}
			/*
			$sql = "UPDATE tbl_Items SET item_status = $updateItem WHERE item_ID = $item";
			$res = mysql_query($sql) or die("Error in Query: ".mysql_error());
			*/
			$sql = "UPDATE tbl_Auctions SET auction_status = $updateListing WHERE auction_ID = $aucid";
//			var_dump($sql);
			$res = mysql_query($sql) or die("Error in Query: ".mysql_error());		
		}

		$mode = $mode + 1;
		$sql = "UPDATE tbl_Checkouts SET checkout_status = $mode WHERE checkout_ID = $id";
		$res = mysql_query($sql) or die("Error in Query: ".mysql_error());

		echo "
			<script>
			window.location.href = 'transaction_deliver.php';
			</script>
		";
		
	}
?>