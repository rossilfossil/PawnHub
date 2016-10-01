<?php
	include('../connect_to_pms.php');
	include('adminparent.php');
	if(isset($_SESSION['branchId'])){	
		$branch = $_SESSION['branchId'];
	}
	else{
		echo "<h3><center>Please Login!</center></h3>";
		return;
	}
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
							$get = mysql_query("SELECT * FROM tbl_Requests
												INNER JOIN tbl_item
												ON tbl_Requests.itemId = tbl_item.itemId
												INNER JOIN tbl_branch
												ON tbl_Requests.branchId = tbl_branch.branchId
												WHERE request_type = 0"
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
										$statustxt = "On Route to Auction";
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
								<input type="text" name="requestname" id="requestname">
								<label for="requestname" class="black-text">Request Name</label>
							</div>
						</div>
						<div class="row">
							<div class="input-field col l12">
								<select class="browser-default" name="item" REQUIRED>
									<option value="" selected disabled>Select Item</option>	
									<?php
										$get = mysql_query("SELECT * FROM tbl_item");
										if(!mysql_num_rows($get)==0){
											while($get_row = mysql_fetch_assoc($get)){
											?><option value = "<?php echo $get_row['itemId']; ?>"><?php echo $get_row['itemName']; ?></option>
										<?php
											}
										}
									?>
								</select>
							</div>
						</div>
						<div class="row">
							<div class="input-field col l12">
								<input type="number" name="idealprice" id="idealprice" min="0">
								<label for="idealprice" class="black-text">Ideal Price</label>
								<p class="red-text">*automatic depende sa appraisal amount ni item</p>
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
		$idealprice = $_POST['idealprice'];
		$sql = "INSERT INTO tbl_Requests(request_name,itemId,ideal_price,branchId,request_type) values('$requestname','$item','$idealprice','$branch','0')";
		$res = mysql_query($sql) or die("Error in Query: ".mysql_error());

		// UPDATE item_status from tbl_item (pawnshop item)

		echo "
			<script>
			window.location.href = 'transac_request.php';
			</script>
		";
	}

?>