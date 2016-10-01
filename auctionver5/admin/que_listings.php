<?php
	include('../connect_to_pms.php');	
	include('adminparent.php');	

?>

<script type="text/javascript" src="Datatables/extensions/buttons/js/dataTables.buttons.js"></script>
<script type="text/javascript" src="Datatables/extensions/buttons/js/buttons.print.js"></script>
<link rel="stylesheet" type="text/css" href="Datatables/extensions/Buttons/css/buttons.dataTables.min.css">
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
</script>

<div class="myfont container">
    <div class="row">
		<div class="col l12">
			<h3><center>Auction Listings</center></h3>
			<div class="black divider"></div>
			<div class="card">
				<table  class="highlight centered" id="tableOutput">
					<thead>
						<th>ID</th>
						<th>Auction Name</th>
						<th>Current Price</th>
						<th>Status</th>
						<th></th>
					</thead>
					<tbody>
						<?php
							$get = mysql_query("SELECT * FROM tbl_Auctions");
							if(!mysql_num_rows($get)==0){
								while($get_row = mysql_fetch_assoc($get)){
									
									if($get_row['auction_status'] == 0){
										$statustxt = "Listed";
									}
									else if($get_row['auction_status'] == 1){
										$statustxt = "Ongoing";
									}
									else if($get_row['auction_status'] == 2){
										$statustxt = "Ended";
									}
									else if($get_row['auction_status'] == 3){
										$statustxt = "Won";
									}
									else if($get_row['auction_status'] == 4){
										$statustxt = "Reauctioned";
									}
									else if($get_row['auction_status'] == 5){
										$statustxt = "Checked Out";
									}
									else if($get_row['auction_status'] == 6){
										$statustxt = "Forfeited";
									}
									else if($get_row['auction_status'] == 7){
										$statustxt = "On Route";
									}
									else if($get_row['auction_status'] == 8){
										$statustxt = "Delivered";
									}
									else if($get_row['auction_status'] == 9){
										$statustxt = "Redeemed	";
									}
									
						?>
									<tr class="black-text">
										<td><?php echo $get_row['auction_ID']?></td>
										<td><?php echo $get_row['auction_name']?></td>
										<td>PHP<?php echo $get_row['current_price']?></td>
										<td><?php echo $statustxt?></td>
										<td><button class="btn black white-text" onclick="viewContent(<?php echo $get_row['auction_ID']?>)">View</button></td>
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