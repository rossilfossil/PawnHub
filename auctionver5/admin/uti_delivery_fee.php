<?php
	include('../connect_to_pms.php');
	if(!isset($_SESSION['branchId'])){
		include("adminhomeparent.php");
        echo "<br><br><br><br><br><br><br><center><h1>You have no access to this page</h1></center>";
		return;		
	}
	include('adminparent.php');
?>
<script type="text/javascript" src="validation.js"></script>
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

<script type="text/javascript">
      $(function(){   
          $('#tableOutput').on('click', '.edit', function(){
             $('#editModal').openModal();
              var selected = this.id;
              var keyID = $("#tdID"+selected).text();
              var keyName = $("#tdName"+selected).text();
              var keyFee = $("#tdFee"+selected).text();
              $("#edit_ID").val(keyID);
              $("#edit_name").val(keyName);
              $("#edit_fee").val(keyFee);
          });
      });   
</script>
<div class="myfont container">
    <div class="row">
		<div class="col l12">
			<h4><center>REGIONAL DELIVERY FEES</center></h4>
			<div class="black divider"></div>
			<div class="card">
				<table  class="highlight centered" id="tableOutput">
					<thead>
						<th>ID</th>
						<th>Region Name</th>
						<th>Delivery Fee</th>
						<th></th>
					</thead> 	
					<tbody>
						<?php
							$get = mysql_query("SELECT * FROM tbl_Regions");
							if(!mysql_num_rows($get)==0){
								while($get_row = mysql_fetch_assoc($get)){
						?>
									<tr class="black-text">
										<td id="tdID<?php echo $get_row['region_ID']?>"><?php echo $get_row['region_ID']?></td>
										<td id="tdName<?php echo $get_row['region_ID']?>"><?php echo $get_row['region_name']?></td>
										<td id="tdFee<?php echo $get_row['region_ID']?>"><?php echo $get_row['delivery_fee']?></td>
										<td><button id="<?php echo $get_row['region_ID']?>" name="edit" class="edit btn black white-text"><i class="material-icons">edit</i></button></td>
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

		<div class="modal" id="editModal">
			<div class="modal-content">
				<div class="modal-header center">
					<h5>Edit Category</h5>
				</div>
				<div class="divider black"></div>
					<div class="container">
						<div class="row">		
    						<div class="input-field col s12 m4 l4">
							<input type="text" class="black-text" name="edit_name" id="edit_name" disabled>
							</div>
						</div>
				<form action="" method="POST" enctype="multipart/form-data">
					<input type="hidden" id="edit_ID" name="edit_ID">
						<div class="row">
							<div class="input-field col l12">
								<input name="edit_fee" id="edit_fee" type="number" pattern ="[0-9.]+" step="0.01" min="0" value="0" class="validate" onkeyup = "validateNumberOnly(this.value,'edit_fee')" REQUIRED>
								<label for="edit_fee" class="active">Delivery Fee</label>
							</div>
						</div>
					</div> 
			</div>
			<div class="modal-footer">
				<button class="btn black white-text" type="submit" name="submitedit">Submit
					<i class="material-icons right">send</i>
				</button>
				<button class="btn black white-text" type="reset" name="reset">Clear
					<i class="material-icons right">send</i>
				</button>
				</form>
			</div>
		</div>
		<!-- END EDIT MODAL -->		
<?php
	if(isset($_POST['submitedit'])){
		$edit_fee = $_POST['edit_fee'];
		$edit_ID = $_POST['edit_ID'];
		$sql = "UPDATE tbl_Regions SET delivery_fee = '$edit_fee' WHERE region_ID = $edit_ID";
		$res = mysql_query($sql) or die("Error in Query: ".mysql_error());
		echo "
			<script>
      		alert('Delivery Fee Edited!');
			window.location.href = 'uti_delivery_fee.php';
			</script>
		";
	}
?>