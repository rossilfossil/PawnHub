<?php
	include('../connect_to_pms.php');
	include('adminparent.php');
?>

<div class="container">
    <div class="row">
		<div class="col l12">
			<h3><center>Delivery Payments</center></h3>
			<div class="black divider"></div>
			<div class="card">
				<table  class="highlight responsive-table centered" id="tableOutput">
					<thead>
						<th>ID</th>
						<th>Winner</th>
						<th>Delivery Address</th>
						<th>Item Name</th>
						<th>Price</th>
						<th></th>
					</thead>
					<tbody>
						<?php
							$get = mysql_query("SELECT * FROM tbl_Checkouts
												INNER JOIN tbl_Bidders
												ON tbl_Bidders.bidder_ID = tbl_Checkouts.bidder_ID
												INNER JOIN tbl_Auctions
												ON tbl_auctions.auction_ID = tbl_Checkouts.auction_ID
												INNER JOIN tbl_Items
												ON tbl_auctions.item_ID = tbl_Items.item_ID
												INNER JOIN tbl_Item
												ON tbl_item.itemId = tbl_Items.itemId
												INNER JOIN tbl_Deliveries
												ON tbl_Deliveries.checkout_ID = tbl_Checkouts.checkout_ID
												WHERE checkout_status = 2
												AND claim_preference = 0
												");
							if(!mysql_num_rows($get)==0){
								while($get_row = mysql_fetch_assoc($get)){
									/*
									if($get_row['request_status'] == 0){
										$statustxt = "Request Sent";
									}
									else if($get_row['request_status'] == 1){
										$statustxt = "Accepted";
									}
									else if($get_row['request_status'] == 2){
										$statustxt = "Rejected";
										<td id="tdStatus<?php echo $get_row['request_ID']?>"><?php echo $statustxt?></td>					
									}
									*/
						?>
									<tr class="black-text">
										<td><?php echo $get_row['checkout_ID']?></td>
										<td><?php echo $get_row['bidder_firstname']." ".$get_row['bidder_middlename']." ".$get_row['bidder_lastname']?></td>
										<td><?php echo $get_row['delivery_housenumber']." ".$get_row['delivery_street']." Street,".$get_row['delivery_barangay']." ".$get_row['delivery_city']." City,".$get_row['delivery_province']?></td>
										<td><?php echo $get_row['itemName']?></td>
										<td><?php echo $get_row['current_price']?></td>
										<td>
										<form action="" method="POST">
											<input type="hidden" name="id" value="<?php echo $get_row['checkout_ID']?>">
											<input type="hidden" name="item" value="<?php echo $get_row['item_ID']?>">
											<button name="send" class="btn black white-text" type="submit"><i class="material-icons left" >check</i>Paid</button>
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
		$id = $_POST['id'];
		$item = $_POST['item'];
		
		$sql = "UPDATE tbl_Checkouts SET checkout_status = 4 WHERE checkout_ID = $id";
		$res = mysql_query($sql) or die("Error in Query: ".mysql_error());

		$sql = "UPDATE tbl_Items SET item_status = 8 WHERE item_ID = $item";
		$res = mysql_query($sql) or die("Error in Query: ".mysql_error());

		$sql = "UPDATE tbl_Auctions SET auction_status = 8 WHERE item_ID = $item";
		$res = mysql_query($sql) or die("Error in Query: ".mysql_error());		

		// listing
		
		echo "
			<script>
			window.location.href = 'transaction_deliver.php';
			</script>
		";
	}
?>