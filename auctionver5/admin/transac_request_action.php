<?php
	include('../connect_to_pms.php');
	include('adminparent.php');
?>

<div class="container">
    <div class="row">
		<div class="col l12">
			<h3><center>Pending Requests</center></h3>
			<div class="black divider"></div>
			<div class="card">
				<table  class="highlight responsive-table centered" id="tableOutput">
					<thead>
						<th>ID</th>
						<th>Request Name</th>
						<th>Item</th>
						<th>Ideal Price</th>
						<th>Branch</th>
						<th>Action</th>
					</thead>
					<tbody>
						<?php
							$get = mysql_query("SELECT * FROM tbl_Requests
												INNER JOIN tbl_item
												ON tbl_Requests.itemId = tbl_item.itemId
												INNER JOIN tbl_branch
												ON tbl_Requests.branchId = tbl_branch.branchId 
												WHERE request_status = 0");
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
										<td id="tdID<?php echo $get_row['request_ID']?>"><?php echo $get_row['request_ID']?></td>
										<td id="tdName<?php echo $get_row['request_ID']?>"><?php echo $get_row['request_name']?></td>
										<td id="tdItem<?php echo $get_row['request_ID']?>"><?php echo $get_row['itemName']?></td>
										<td id="tdPrice<?php echo $get_row['request_ID']?>"><?php echo $get_row['ideal_price']?></td>
										<td id="tdBranch<?php echo $get_row['request_ID']?>"><?php echo $get_row['branchName']?></td>
										<td>
										<form action="" method="POST">
											<input type="hidden" name="id" value="<?php echo $get_row['request_ID']?>">
											<button name="accept" class="btn black white-text" type="submit"><i class="material-icons" >check</i></button>
											<button name="reject" class="btn black white-text" type="submit"><i class="material-icons" >close</i></button>
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
	if(isset($_POST['accept'])){
		$id = $_POST['id'];
		$sql = "UPDATE tbl_Requests SET request_status = 1 WHERE request_ID = $id";
		$res = mysql_query($sql) or die("Error in Query: ".mysql_error());
		echo "
			<script>
			window.location.href = 'transac_request_action.php';
			</script>
		";
	}


	if(isset($_POST['reject'])){
		$id = $_POST['id'];
		$sql = "UPDATE tbl_Requests SET request_status = 2 WHERE request_ID = $id";
		$res = mysql_query($sql) or die("Error in Query: ".mysql_error());
		echo "
			<script>
			window.location.href = 'transac_request_action.php';
			</script>
		";
	}

?>