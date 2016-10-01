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
<script type="text/javascript" src="viewAuction.js"></script>


<script type="text/javascript" src="Datatables/extensions/buttons/js/dataTables.buttons.js"></script>
<script type="text/javascript" src="Datatables/extensions/buttons/js/buttons.print.js"></script>
<link rel="stylesheet" type="text/css" href="Datatables/extensions/Buttons/css/buttons.dataTables.min.css">
<div class="myfont container">
    <div class="row">
		<div class="col l12">
			<h3><center>Auction Items</center></h3>
			<div class="black divider"></div>
			<div class="card">
				<table  class="highlight responsive-table centered" id="tableOutput">
					<thead>
						<th>ID</th>
						<th>Item Type</th>
						<th>Item Description</th>
						<th>Appraise Value</th>
						<th>Branch</th>
						<th>Item Status</th>
						<!-- <th></th> -->
					</thead>
					<tbody>
						<?php
							$get = mysql_query("SELECT * FROM tbl_Items
												INNER JOIN tbl_Item
												ON tbl_Items.itemId = tbl_Item.itemId
												INNER JOIN tbl_branch
												ON tbl_Items.branchId = tbl_Branch.branchId
											");
							if(!mysql_num_rows($get)==0){
								while($get_row = mysql_fetch_assoc($get)){
									$button = "";
									if($get_row['item_status'] == 0){
										$statustxt = "In Warehouse";
									}
									else if($get_row['item_status'] == 1){
										$statustxt = "In Auction";
										// $button = "<button name='submit' class='btn black white-text' type='submit'><i class='material-icons left' >motorcycle</i>Send</button>";
									}
									else if($get_row['item_status'] == 2){
										$statustxt = "Won";
								//		$button = "<button name='submit' class='btn black white-text' type='submit'><i class='material-icons left' >motorcycle</i>Send</button>";
									}
									else if($get_row['item_status'] == 3){
										$statustxt = "In Ended Auction";
									}
									else if($get_row['item_status'] == 4){
										$statustxt = "Checked Out";
									}
									else if($get_row['item_status'] == 5){
										$statustxt = "Forfeited";
									}
									else if($get_row['item_status'] == 6){
										$statustxt = "On Route";
									}
									else if($get_row['item_status'] == 7){
										$statustxt = "Delivered";
									}
									else{
										$statustxt = "---";
									}

									if($get_row['itemType']==1){
										$itemtype = "Jewelry";
									}
									else{
										$itemtype = "General";
									}
						?>
									<tr>
										<td><?php echo $get_row['itemId']?></td>
										<td><?php echo $itemtype?></td>
										<td><?php echo $get_row['itemName']?></td>
										<td>P <?php echo $get_row['itemWorth']?></td>
										<td><?php echo $get_row['branchName']?></td>
										<td><?php echo $statustxt?></td>
										<!-- <td></td> -->
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


$(document).ready(function(){
    $('#tableOutput').DataTable({
    "bLengthChange": false,
    "pageLength" : 5,

    		dom: 'Bfrtip',
        		buttons: [
            		'print'
        		]
    });
})
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