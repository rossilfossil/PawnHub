<?php
	include"../connect_to_pms.php";
	if(!isset($_SESSION['branchId'])){
		include("adminhomeparent.php");
        echo "<br><br><br><br><br><br><br><center><h1>You have no access to this page</h1></center>";
		return;		
	}
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

      $(function(){   
          $('#tableOutput').on('click', '.edit', function(){
             $('#editModal').openModal();
              var selected = this.id;
              var keyID = $("#tdID"+selected).text();
              var keyName = $("#tdName"+selected).text();
              var keyMCName = $("#tdMCName"+selected).text();
              $("#edit_ID").val(keyID);
              $("#edit_mcname").val(keyName);
              $("#edit_mcat").val(keyMCName);
              $("#edit_fileToUpload").val(keyImage);
          });
      });   
</script>

<div class="myfont container">
	<div class="row">
		<div class="col l12">
			<h4><center>CATEGORY</center></h4>
			<div class="divider black"></div>
			<div class="card">
				<a class="right modal-trigger black btn z-depth-3" href="#addModal"><i class="material-icons left">add</i>Add Category</a>
				<table class="highlight centered" id="tableOutput">
					<thead>
						<th>ID</th>
						<th>Main Category</th>
						<th>Category</th>
						<!--<th>Status</th>-->
						<th>Action</th>
					</thead>
					<tbody>		
                		<?php
							$get = mysql_query("SELECT * FROM tbl_Categories
												INNER JOIN tbl_Main_Categories
												ON tbl_Categories.main_category_ID = tbl_Main_Categories.main_category_ID 
												WHERE tbl_Categories.deleted = 0
												");
							if(!mysql_num_rows($get)==0){
								while($get_row = mysql_fetch_assoc($get)){
						?>
									<tr class="black-text">
										<td id="tdID<?php echo $get_row['category_ID']?>"><?php echo $get_row['category_ID']?></td>
										<td id="tdMCName<?php echo $get_row['category_ID']?>"><?php echo $get_row['main_category_name']?></td>
										<td id="tdName<?php echo $get_row['category_ID']?>"><?php echo $get_row['category_name']?></td>
										<!--<td>SWITCH</td>-->
										<td width="20%">
											<div class="col s6">	
												<button id="<?php echo $get_row['category_ID']?>" value="<?php echo $get_row['category_ID']?>" name="edit" class="edit black btn white-text"><i class="material-icons" >edit</i></button>
											</div>
											<form action="" method="POST">	
												<input type="hidden" name="id" value="<?php echo $get_row['category_ID']?>">
											    <button id="delete" name="delete" type="submit" class="black btn white-text"><i class="material-icons">delete</i></button></td>
											</form>
										</div>
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
					<h5>Add Category</h5>
				</div>
				<div class="divider black"></div>
				<form action="" method="POST" enctype="multipart/form-data">
					<div class="container">
						<br>
						<div class="row">		
    						<div class="input-field col s12">
								<select class = "browser-default" name = 'mcat' id='mcat' REQUIRED>
									<option value = "" selected disabled>Select Main Category:</option>
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
								<label class="black-text active" for="itemid">Main Category</label>
							</div>
						</div>
						<div class="row">
							<div class="input-field col l12">
								<input name="cname" id="cname" type="text" class="validate" pattern = "[A-Za-z0-9 ]+" onkeyup = "validateTextOnly(this.value,'cname')" REQUIRED>
								<label for="cname">Category Name</label>
							</div>
						</div>
					</div> 
			</div>
			<div class="modal-footer">
				<button class="btn btn-flat waves-effect waves-light"  type="submit" name="submit">Submit
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

					<div class="container">


						<br><br>
						<div class="row">		
    						<div class="input-field col s12">
							<input type="text" value=" " class="black-text" name="edit_mcat" id="edit_mcat" disabled>
								<label for="edit_mcat" class="active">Main Category Name</label>
							</div>
						</div>
				<form action="" method="POST" enctype="multipart/form-data">

						<div class="row">
							<div class="input-field col l12">
								<input type="hidden" id="edit_ID" name="edit_ID">
								<input name="edit_mcname" id="edit_mcname" type="text" value=" " pattern = "[A-Za-z0-9 ]+" class="black-text validate" onkeyup = "validateTextOnly(this.value,'edit_mcname')" REQUIRED>
								<label for="edit_mcname" class="active">Category Name</label>
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
		$mcat = $_POST['mcat'];
		$sql = "INSERT INTO tbl_categories(main_category_ID,category_name) values('$mcat','$cname')";
		$res = mysql_query($sql) or die("Error in Query: ".mysql_error());
		echo "
			<script>
			alert('Category Added!');
			window.location.href = 'maintenance_category.php';
			</script>
		";
	}

	if(isset($_POST['submitedit'])){
		$edit_mcname = ucwords(strtolower(trim($_POST['edit_mcname'])));
		$edit_ID = $_POST['edit_ID'];
		$sql = "UPDATE tbl_Categories SET category_name = '$edit_mcname' WHERE category_ID = $edit_ID";
		$res = mysql_query($sql) or die("Error in Query: ".mysql_error());
		echo "
			<script>
			alert('Category Edited!');
			window.location.href = 'maintenance_category.php';
			</script>
		";
	}


	if(isset($_POST['delete'])){
		$id = $_POST["id"];
		$sql = "UPDATE tbl_Categories SET  deleted =  1 WHERE  category_ID = $id ";
		$res = mysql_query($sql) or die("Error in Query:" . mysql_error());
		echo "
			<script>
			alert('Category Deleted!');
			window.location.href = 'maintenance_category.php';
			</script>
		";
	}
?>