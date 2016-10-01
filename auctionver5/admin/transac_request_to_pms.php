<?php
	include('../connect_to_pms.php');
	include('adminparent.php');
?>

<div class="container">
    <div class="row">
		<div class="col l12">
			<h3><center>Requests</center></h3>
			<div class="black divider"></div>
			<div class="card">
    			<a class="right modal-trigger black btn z-depth-3" href="#addModal"><i class="material-icons left">add</i>Create New Request</a>
				<table  class="highlight responsive-table centered" id="tableOutput">
					<thead>
						<th>ID</th>
						<th>Request Name</th>
						<th>Item</th>
						<th>Ideal Price</th>
						<th>Branch</th>
						<th>Status</th>
					</thead>
					<tbody>
						<?php
							$get = mysql_query("SELECT * FROM `tbl_Requests` 
												INNER JOIN tbl_item
												ON tbl_Requests.itemId = tbl_item.itemId
												INNER JOIN tbl_branch
												ON tbl_Requests.branchId = tbl_branch.branchId
												WHERE request_type = 1"
												);
							if(!mysql_num_rows($get)==0){
								while($get_row = mysql_fetch_assoc($get)){
									if($get_row['request_status'] == 0){
										$statustxt = "Request Sent";
									}
									else if($get_row['request_status'] == 1){
										$statustxt = "Accepted";
									}
									else if($get_row['request_status'] == 2){
										$statustxt = "Rejected";
									}
									else if($get_row['request_status'] == 3){
										$statustxt = "On Route to Branch";
									}
									else if($get_row['request_status'] == 4){
										$statustxt = "Received";
									}
									else{
										$statustxt = "No Idea";
									}
						?>
									<tr class="black-text">
										<td id="tdID<?php echo $get_row['request_ID']?>"><?php echo $get_row['request_ID']?></td>
										<td id="tdName<?php echo $get_row['request_ID']?>"><?php echo $get_row['request_name']?></td>
										<td id="tdItem<?php echo $get_row['request_ID']?>"><?php echo $get_row['itemName']?></td>
										<td id="tdPrice<?php echo $get_row['request_ID']?>"><?php echo $get_row['ideal_price']?></td>
										<td id="tdBranch<?php echo $get_row['request_ID']?>"><?php echo $get_row['branchName']?></td>
										<td id="tdStatus<?php echo $get_row['request_ID']?>"><?php echo $statustxt?></td>					
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
			<!-- ADD MODAL -->
		<div class="modal" id="addModal">
			<div class="modal-content">
				<div class="modal-header center">
					<h5>Create Request</h5>
				</div>
				<div class="divider black"></div>
				<form action="" method="POST" enctype="multipart/form-data">
					<div class="container">
						<div class="row">
							<div class="input-field col l12">
								<input type="text" name="requestname" id="requestname" REQUIRED>
								<label for="requestname" class="black-text">Request Name</label>
							</div>
						</div>
						<div class="row">
							<div class="input-field col l12">
								<select class="browser-default" name="item" REQUIRED>
									<option value="" selected disabled>Select Item</option>	
									<?php
										$get = mysql_query("SELECT * FROM tbl_Items
											INNER JOIN tbl_Auctions
											ON tbl_Auctions.item_ID = tbl_Items.item_ID
											INNER JOIN tbl_Checkouts
											ON tbl_Checkouts.auction_ID = tbl_Auctions.auction_ID
											WHERE tbl_Auctions.auction_status = 5 AND
											tbl_Items.item_status = 4
											");
										// CLAIM_PREFERENCE
										// WHERE item_status = won
										if(!mysql_num_rows($get)==0){
											while($get_row = mysql_fetch_assoc($get)){
											?><option value = "<?php echo $get_row['itemId']; ?>"><?php echo $get_row['auction_name']; ?></option>
										<?php
										}
										}
									?>
								</select>
								ITEM ID DAPAT SA tbl_item hindi sa tbl_items!!!
							</div>
						</div>
						<div class="row">
							<div class="input-field col l12">
								<input type="number" name="idealprice" id="idealprice" min="0">
								<label for="idealprice" class="black-text">Ideal Price</label>
								<p class="red-text">*automatic depende sa current price ni item</p>
							</div>	
						</div>
						<div class="row">
							<div class="input-field col l12">
								<select class="browser-default" name="branch" REQUIRED>
									<option value="" selected disabled>Select Branch</option>	
									<?php
										$get = mysql_query("SELECT * FROM tbl_branch");
										// WHERE item_status = won
										if(!mysql_num_rows($get)==0){
											while($get_row = mysql_fetch_assoc($get)){
											?><option value = "<?php echo $get_row['branchId']; ?>"><?php echo $get_row['branchName']; ?>
											</option>
										<?php
											}
										}
									?>
								</select>
								<p>* DEPENDE SA PICK UPS</p>
							</div>
						</div>
					</div>
			</div>
			<div class="modal-footer">
				<button class="btn black white-text" type="submit" name="submit">Submit
					<i class="material-icons right">send</i>
				</button>
				<button class="btn black white-text" type="reset" name="reset">Clear
					<i class="material-icons right">send</i>
				</button>
				</form>
			</div>
		</div>
		<!-- END ADD MODAL -->	
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
	if(isset($_POST['submit'])){
		$requestname = trim($_POST['requestname']);
		$item = $_POST['item']; 
		// AUCTION ITEM TO HINDI PAWNSHOP ITEM DAMNIT
		echo $item;
		$idealprice = $_POST['idealprice'];
		$branch = $_POST['branch'];
		
		$sql = "INSERT INTO tbl_Requests(request_name,itemId,ideal_price,branchId,request_type) values('$requestname','$item','$idealprice','$branch','1')";
		$res = mysql_query($sql) or die("TError in Query: ".mysql_error());

		// UPDATE item_status from tbl_item (pawnshop item)


		$get = mysql_fetch_assoc(mysql_query("SELECT * FROM tbl_Checkouts 
												INNER JOIN tbl_Auctions
												ON tbl_Checkouts.auction_ID = tbl_Auctions.auction_ID
												INNER JOIN tbl_Items
												ON tbl_Auctions.item_ID = tbl_Items.item_ID
												WHERE tbl_Items.item_status = 4
											"));

		// sets the checkout_status to REQUEST SENDED
		$checkout = $get['checkout_ID'];
		$sql = "UPDATE tbl_Checkouts SET checkout_status = 1 WHERE checkout_ID = $checkout";
		$res = mysql_query($sql) or die("Error in Query: ".mysql_error());

		// sets the item_status to REQUEST SENDED
		$sql = "UPDATE tbl_Items SET item_status = 5 WHERE item_ID = $item";
		$res = mysql_query($sql) or die("SError in Query: ".mysql_error());
/*
		echo "
			<script>
			window.location.href = 'transac_request_to_pms.php';
			</script>
		";
*/		
	}

?>