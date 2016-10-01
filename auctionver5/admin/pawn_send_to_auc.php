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
<script type="text/javascript">
	$(document).ready(function(){
    $('#tableOutput').DataTable({
    "bLengthChange": false,
    "pageLength" : 5
    });
})
</script>
<div class="container">
    <div class="row">
		<div class="col l12">
			<h3><center>Pawnshop Items</center></h3>
			<div class="black divider"></div>
			<div class="card">
				<table  class="highlight responsive-table centered" id="tableOutput">
					<thead>
						<th>ID</th>
						<th>Item Name</th>
						<th>Item Type</th>
						<th>Item Status</th>
						<th>Item Worth</th>
						<th>Branch</th>
						<th></th>
					</thead>
					<tbody>
						<?php
							$get = mysql_query("SELECT * FROM tbl_Item"
												);
							if(!mysql_num_rows($get)==0){
								while($get_row = mysql_fetch_assoc($get)){
										$button = "";
									if($get_row['itemStatus'] == 1){
										$statustxt = "In Shop";
										$button = "";
									}
									else if($get_row['itemStatus'] == 2){
										$statustxt = "Redeemed";
										$button = "";
									}
									else if($get_row['itemStatus'] == 3){
										$statustxt = "Forfeited";
										$button = "<button name='submit' class='btn black white-text' type='submit'><i class='material-icons left' >motorcycle</i>Send</button>";
									}
									else if($get_row['itemStatus'] == 4){
										$statustxt = "Auctioned";
										$button = "";
									}
									else if($get_row['itemStatus'] == 5){
										$statustxt = "Lost";
										$button = "";
									}
									else if($get_row['itemStatus'] == 6){
										$statustxt = "Damaged";
										$button = "";
									}
									else if($get_row['itemStatus'] == 7){
										$statustxt = "Stolen";
										$button = "";
									}
									else if($get_row['itemStatus'] == 8){
										$statustxt = "Out Shop";
										$button = "";
									}
									else{
										$statustxt = "---";
										$button = "";
									}
						?>
									<tr>
										<td><?php echo $get_row['itemId']?></td>
										<td><?php echo $get_row['itemName']?></td>
										<td><?php echo $get_row['itemType']?></td>
										<td><?php echo $statustxt?></td>					
										<td><?php echo $get_row['itemWorth']?>php</td>
										<td class="red-text">Current Branch</td>
										<td>
											<form action="" method="POST">	
												<input type="hidden" name="id" value="<?php echo $get_row['itemId']?>">
												<?php echo $button?>
											</form>
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
	if(isset($_POST['submit'])){
		$id = $_POST['id'];
		$branch = $_SESSION['branchId'];

		$sql = "UPDATE tbl_item SET itemStatus = 4 WHERE itemId = $id";
		$res = mysql_query($sql) or die("Error in Query: ".mysql_error());

		$sql = "INSERT INTO tbl_Items(itemId,branchId) values('$id','$branch')";
		$res = mysql_query($sql) or die("Error in Query: ".mysql_error());
		echo "
			<script>
			window.location.href = 'pawn_send_to_auc.php';
			</script>
		";
		
	}
?>