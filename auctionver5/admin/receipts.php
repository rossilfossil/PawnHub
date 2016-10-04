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
									
										$statustxt = "Pending";
										$button = '<button name="send" value="0" class="btn black white-text" type="submit"><i class="material-icons" >print</i></button>';
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
		
			// print receipt
			// open new tab
			// print from delivery receipts
		$_SESSION['delivery_receipt'] = $receipt;
		echo "<script>
				window.open('form-auction-receipt.php','_blank');
			</script>";

		echo "
			<script>
			window.location.href = 'receipts.php';
			</script>
		";
		
	}
?>