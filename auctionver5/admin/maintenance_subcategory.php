<?php
	include('../connect_to_pms.php');
	include"adminparent.php";
	
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


<script type="text/javascript" src="getCategory.js"></script>
<script type="text/javascript">
      $(function(){   
          $('#tableOutput').on('click', '.edit', function(){
             $('#editModal').openModal();
              var selected = this.id;
              var keyID = $("#tdID"+selected).text();
              var keyName = $("#tdName"+selected).text();
              var keyMCName = $("#tdMCName"+selected).text();
              var keySubName = $("#tdSubName"+selected).text();
              $("#edit_ID").val(keyID);
              $("#edit_mcname").val(keyName);
              $("#edit_mcat").val(keyMCName);
              $("#edit_subname").val(keySubName);
          });
      });   
</script>
<div class="myfont container">
	<div class="row">
		<div class="col l12">
			<h4><center>SUB CATEGORY</center></h4>
			<div class="divider black"></div>
			<div class="card">
				<a class="right modal-trigger black btn z-depth-3" href="#addModal"><i class="material-icons left">add</i>Add Sub Category</a>
				<table class="highlight centered" id="tableOutput">
					<thead>
						<th>ID</th>
						<th>Main Category</th>
						<th>Category</th>
						<th>Sub Category</th>
						<!--<th>Status</th>-->
						<th>Action</th>
					</thead>
					<tbody>		
                		<?php
							$get = mysql_query("SELECT * FROM tbl_Subcategories
												INNER JOIN tbl_Categories
												ON tbl_Subcategories.category_ID = tbl_Categories.category_ID
												INNER JOIN tbl_Main_Categories
												ON tbl_Categories.main_category_ID = tbl_Main_Categories.main_category_ID
												WHERE tbl_Subcategories.deleted = 0");
							if(!mysql_num_rows($get)==0){
								while($get_row = mysql_fetch_assoc($get)){
						?>
									<tr class="black-text">
										<td id="tdID<?php echo $get_row['subcategory_ID']?>"><?php echo $get_row['subcategory_ID']?></td>
										<td id="tdMCName<?php echo $get_row['subcategory_ID']?>"><?php echo $get_row['main_category_name']?></td>
										<td id="tdName<?php echo $get_row['subcategory_ID']?>"><?php echo $get_row['category_name']?></td>
										<td id="tdSubName<?php echo $get_row['subcategory_ID']?>"><?php echo $get_row['subcategory_name']?></td>
										<!--<td>SWITCH</td>-->
										<td width="20%">
										<div class="col s6">
											<button id="<?php echo $get_row['subcategory_ID']?>" value="<?php echo $get_row['subcategory_ID']?>" name="edit" class="edit black btn white-text"><i class="material-icons" >edit</i></button>
										</div>
										<form action="" method="POST">	
											<input type="hidden" name="id" value="<?php echo $get_row['subcategory_ID']?>">
										    <button id="delete" name="delete" type="submit" class="black btn white-text"><i class="material-icons" onclick="">delete</i></button></td>
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
		<!-- ADD MODAL -->
		<div class="modal modal-width1" id="addModal">
			<div class="modal-content">
				<div class="modal-header center">
					<h5>Add Subcategory</h5>
				</div>
				<div class="divider black"></div>
				<form action="" method="POST" enctype="multipart/form-data">
					<div class="container">
						<br>
						<div class="row">		
    						<div class="input-field col s12">
								<select class="browser-default" name='mcat' id='mcat' onchange="setCategory(this.value)" REQUIRED>
									<option value="" selected disabled>Select Main Category</option>
									<?php
										$get = mysql_query("SELECT * FROM tbl_Main_Categories WHERE deleted = 0");
										if(!mysql_num_rows($get)==0){
											while($get_row = mysql_fetch_assoc($get)){
											?><option value = "<?php echo $get_row['main_category_ID']; ?>"><?php echo $get_row['main_category_name']; ?></option>
										<?php
											}
										}
									?>	
								</select>
								<select id="subcat" hidden></select>
								<label class="black-text active" for="itemid">Main Category</label>
							</div>
							<div class="input-field col s12">
								<select class="browser-default" name='scate' id='scate' REQUIRED>
										<option value="" selected disabled>Select Category</option>	
								</select>
								<label class="black-text active" for="scate">Category</label>

							</div>
						</div>
						<div class="row">
							<div class="input-field col l12">
								<input name="cname" id="cname" type="text" pattern = "[A-Za-z0-9 ]+" class="validate" onkeyup = "validateTextOnly(this.value,'cname')" REQUIRED>
								<label for="cname">Subcategory Name</label>
							</div>
						</div>
					</div> 
			</div>
			<div class="modal-footer">
				<button class="btn btn-flat waves-effect waves-light" type="submit" name="submit">Submit
					<i class="material-icons right">send</i>
				</button>
				<button class="btn btn-flat waves-effect waves-light"  type="reset" name="reset">Clear
					<i class="material-icons right">send</i>
				</button>
				</form>
			</div>
		</div>
		<!-- END ADD MODAL -->
		<!-- EDIT MODAL -->
		<div class="modal modal-width1" id="editModal">
			<div class="modal-content">
				<div class="modal-header center">
					<h5>Edit Category</h5>
				</div>
				<div class="divider black"></div>
				<form action="" method="POST" enctype="multipart/form-data">
					<div class="container">
					<input type="hidden" id="edit_ID" name="edit_ID">
					<br><br>
						<div class="row">		
    						<div class="input-field col s12">
							<input type="text" value=" " class="black-text" name="edit_mcat" id="edit_mcat" disabled>
								<label for="edit_mcat" class="active">Main Category Name</label>
							</div>
						</div>
						<div class="row">
							<div class="input-field col s12">
								<input name="edit_mcname" id="edit_mcname" type="text" value=" " class="black-text validate" disabled>
								<label for="edit_mcname" class="active">Category Name</label>
							</div>
						</div>
						<div class="row">
							<div class="input-field col l12">
								<input name="edit_subname" id="edit_subname" type="text" value=" " pattern = "[A-Za-z0-9 ]+" onkeyup = "validateTextOnly(this.value,'edit_subname')" class="black-text validate" required>
								<label for="edit_subname" class="active">SubCategory Name</label>
							</div>
						</div>
					</div> 
			</div>
			<div class="modal-footer">
				<button class="btn btn-flat waves-effect waves-light"  type="submit" name="submitedit">Submit
					<i class="material-icons right">send</i>
				</button>
				<button class="btn btn-flat waves-effect waves-light"  type="reset" name="reset">Clear
					<i class="material-icons right">send</i>
				</button>
				</form>
			</div>
		</div>
		<!-- END EDIT MODAL -->		
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
		$cname = ucwords(strtolower(trim($_POST['cname'])));
		$mcat = $_POST['scate'];
		$sql = "INSERT INTO tbl_subcategories(category_ID,subcategory_name,deleted) values('$mcat','$cname',0)";
		$res = mysql_query($sql) or die("Error in Query: ".mysql_error());
		echo "
			<script>
			alert('Subcategory Added!');
			window.location.href = 'maintenance_subcategory.php';
			</script>
		";
	}

	if(isset($_POST['submitedit'])){
		$edit_mcname = ucwords(strtolower(trim($_POST['edit_subname'])));
		$edit_ID = $_POST['edit_ID'];
		$sql = "UPDATE tbl_Subcategories SET subcategory_name = '$edit_mcname' WHERE subcategory_ID = $edit_ID";
		$res = mysql_query($sql) or die("Error in Query: ".mysql_error());
		echo "
			<script>
			alert('Subcategory Edited!');
			window.location.href = 'maintenance_subcategory.php';
			</script>
		";
	}

	if(isset($_POST['delete'])){
		$id = $_POST["id"];
		$sql = "UPDATE tbl_Subcategories SET deleted =  1 WHERE subcategory_ID = $id ";
		$res = mysql_query($sql) or die("Error in Query:" . mysql_error());

		echo "
			<script>
			alert('Subcategory Deleted!');
			window.location.href = 'maintenance_subcategory.php';
			</script>
		";
		
	}
?>