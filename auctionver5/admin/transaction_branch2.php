<?php
	include('../connect_to_pms.php');
	include('adminparent.php');
	
?>
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
    "bLengthChange": false
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
			<h4><center>BRANCH DELIVERIES</center></h4>
			<div class="black divider"></div>
			<div class="card">
			<table  class="highlight centered" id="tableOutput">
					<thead>
						<th>ID</th>
						<th>Winner</th>
						<th>Branch</th>
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
												INNER JOIN tbl_Pickups
												ON tbl_Pickups.checkout_ID = tbl_Checkouts.checkout_ID
												INNER JOIN tbl_Branch
												ON tbl_Pickups.branchId = tbl_Branch.branchId
												INNER JOIN tbl_voucher
												ON tbl_Voucher.checkoutid = tbl_Checkouts.checkout_ID
												INNER JOIN tbl_auction_payment
												ON tbl_auction_payment.voucherId = tbl_voucher.voucherId
												WHERE claim_preference = 1
												");
							if(!mysql_num_rows($get)==0){
								while($get_row = mysql_fetch_assoc($get)){
									if($get_row['checkout_status'] == 0){
										if($get_row['status'] == 0){
											$statustxt = "Pending";	
											$button="";
										}
										else{
											$statustxt = "Paid";
											$button = '<button name="send" value="1" class="btn black white-text" type="submit"><i class="material-icons" >motorcycle</i></button>';
										}
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
										$statustxt = "In Branch";
										$button = "";
									}
									
						?>
									<tr class="black-text">
										<td><?php echo $get_row['checkout_ID']?></td>
										<td><?php echo $get_row['bidder_firstname']." ".$get_row['bidder_middlename']." ".$get_row['bidder_lastname']?></td>
										<td><?php echo $get_row['branchName']?></td>
										<td><?php echo $get_row['current_price']?></td>
										<td><?php echo $statustxt?></td>
										<td>
										<form action="" method="POST">
											<input type="hidden" name="id" value="<?php echo $get_row['checkout_ID']?>">
											<input type="hidden" name="item" value="<?php echo $get_row['item_ID']?>">
											<input type="hidden" name="branch" value="<?php echo $get_row['branchId']?>">
											<input type="hidden" name="voucher" value="<?php echo $get_row['voucherId']?>">
											<?php echo $button?>
										</form>
										<td>
											<button class="btn black white-text" onclick="viewContent(<?php echo $get_row['auction_ID']?>)">View</button>
										</td>
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
		// ireready pa lang
		$id = $_POST['id'];
		$item = $_POST['item'];
		$mode = $_POST['send'];
		$branch = $_POST['branch'];
		$voucher = $_POST['voucher'];
		
		if ($mode == 0){ // pending
			// print receipt
			// open new tab
		}
		else if ($mode == 1){ // ready
			// deliver
			// set status to on route
			$updateListing = 7;
			$updateItem = 6;
			echo "<script>alert('Deliver Item')</script>";
		}
		else if ($mode == 2){ // on route
			$updateListing = 9;
			$updateItem = 8;
			// deliver
			// set status to delivered

			// populate auction_items
			$sql = "INSERT INTO tbl_auction_item(voucherId,branchId) values('$voucher','$branch')";
			$res = mysql_query($sql) or die("Error in Query: ".mysql_error());			
			echo "<script>alert('Item Delivered to Branch!')</script>";
			$mode = $mode + 1;
		}
		else if ($mode == 3){ // delivered
			$updateListing = 9;
			$updateItem = 8;
			// redeem
			// set status to redeemed
		}
		if (!$mode==0){	
			$sql = "UPDATE tbl_Items SET item_status = $updateItem WHERE item_ID = $item";
			$res = mysql_query($sql) or die("Error in Query: ".mysql_error());

			$sql = "UPDATE tbl_Auctions SET auction_status = $updateListing WHERE item_ID = $item";
			$res = mysql_query($sql) or die("Error in Query: ".mysql_error());		
		}

		$mode = $mode + 1;
		$sql = "UPDATE tbl_Checkouts SET checkout_status = $mode WHERE checkout_ID = $id";
		$res = mysql_query($sql) or die("Error in Query: ".mysql_error());

		/*
		var_dump($sql);
		*/
		// listing
		echo "
			<script>
			window.location.href = 'transaction_branch.php';
			</script>
		";
	}
?>