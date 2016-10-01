<?php
	include"../connect_to_pms.php";
	include"adminparent.php";
	
?>
<script type="text/javascript" src="validation.js"></script>
<script type="text/javascript">

$(document).ready(function(){
    $('#tableOutput').dataTable({
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
              var keyImage = $("#tdImage"+selected).text();
              $("#edit_ID").val(keyID);
              $("#edit_mcname").val(keyName);
              $("#edit_fileToUpload").val(keyImage);
          });
      });   
</script>
<div class="myfont container">
	<div class="row">
		<div class="col l12">
			<h4><center>MAIN CATEGORY</center></h4>
			<div class="divider black"></div>
			<div class="card">
				<a class="right modal-trigger black btn z-depth-3" href="#addModal"><i class="material-icons left">add</i>Add Main Category</a>
				
				<table class="highlight responsive-table centered" id="tableOutput">
					<thead>
						<th>ID</th>
						<!--<th>Image</th>-->
						<th>Name</th>
						<!--<th>Status</th>-->
						<th>Action</th>
					</thead>
					<tbody>		
                		<?php
							$get = mysql_query("SELECT * FROM tbl_Main_Categories WHERE deleted = 0");
							if(!mysql_num_rows($get)==0){
								while($get_row = mysql_fetch_assoc($get)){
						?>				
									<tr class="black-text">
										<td id="tdID<?php echo $get_row['main_category_ID']?>" width="10%"><?php echo $get_row['main_category_ID']?></td>
									<!--
										<td id="tdImage<?php // echo $get_row['main_category_ID']?>"><img class="activator" style="height:100px" src="../category/<?php // echo $get_row['main_category_image']?>"></td>
									-->
										<td id="tdName<?php echo $get_row['main_category_ID']?>"><?php echo $get_row['main_category_name']?></td>
										<!--<td>SWITCH</td>-->
										<td width="20%">
												<div class="col s6">
													<button id="<?php echo $get_row['main_category_ID']?>" value="<?php echo $get_row['main_category_ID']?>" name="edit" class="edit black btn white-text"><i class="material-icons" >edit</i></button>
												</div>
												<form action="" method="POST">	
													<input type="hidden" name="id" value="<?php echo $get_row['main_category_ID']?>">
											    	<button id="delete" name="delete" type="submit" class="black btn white-text"><i class="material-icons">delete</i></button>
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
		<!-- ADD MODAL --><center>
		<div class="modal modal-width1" id="addModal">
			<div class="modal-content">
				<div class="modal-header center">
					<h5>Add Main Category</h5>
				</div>
				<div class="divider black"></div>
				<form action="" method="POST" enctype="multipart/form-data">
					<div class="container">
						<br><br>
			<!-- 			
						<div class="row">
							<div class="input-field col l12">

								<input type="file" class="" name="fileToUpload" id="fileToUpload" REQUIRED>
								<label for="fileToUpload" class="active black-text"><h6>Main Category Image</h6></label>
							</div>
						</div>
			-->			
						<div class="row">
							<div class="input-field col l12">
								<input name="mcname" id="mcname" type="text" class="validate" pattern = "[A-Za-z0-9 ]+" onkeyup = "validateTextOnly(this.value,'mcname')" REQUIRED>
								<label for="mcname">Main Category Name</label>
							</div>
						</div>
					</div> 
			</div>
			
			<div class="modal-footer center">
				&nbsp;
				<button class="btn btn-flat waves-effect waves-light"  type="submit" name="submit">Submit
					<i class="material-icons right">send</i>
				</button>
				&nbsp;

				<button class="btn btn-flat waves-effect waves-light"  type="reset" name="reset">Clear
					<i class="material-icons right">send</i>
				</button>

				<!-- &nbsp; -->

				
				</form>
			</div>
			
		</div>
</center>
	
		<!-- END ADD MODAL -->
		<!-- EDIT MODAL -->
		<div class="modal modal-width1" id="editModal">
			<div class="modal-content">
				<div class="modal-header center">
					<h5>Edit Main Category</h5>
				</div>
				<div class="divider black"></div>
				<form action="" method="POST" enctype="multipart/form-data">
					<div class="container">

					<input type="hidden" id="edit_ID" name="edit_ID">

					<br>
					<!--
						<div class="row">
							<div class="input-field col l12">
								<input type="file" class="" name="edit_fileToUpload" id="edit_fileToUpload" REQUIRED>
								<label for="edit_fileToUpload" class="active black-text">Main Category Image</label>
							</div>
						</div>
				-->	
						<div class="row">
							<div class="input-field col l12">
								<input name="edit_mcname" id="edit_mcname" type="text" class="validate" pattern = "[A-Za-z0-9 ]+" value=" " onkeyup = "validateNoSpecs(this.value,'edit_mcname')" REQUIRED>
								<label for="edit_mcname" class="active"><h6>Main Category Name</h6></label>
							</div>
						</div>
					</div> 
			</div>
			<div class="modal-footer">
				<button class="btn btn-flat waves-effect waves-light"  type="submit" name="submitedit">Submit
					<i class="material-icons right">send</i>
				</button>
				<button class="btn btn-flat waves-effect waves-light" type="reset" name="reset">Clear
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
		$mcname = ucwords(strtolower(trim($_POST['mcname'])));
		/*		//if(isset($_POST["fileToUpload"])) {
			$target_dir = "../category/";
			$target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
			// echo "basename -> ".basename($_FILES["fileToUpload"]["name"]); // FILENAME
			$uploadOk = 1;
			$imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);
			// Check if image file is a actual image or fake image
    		$check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
    		if($check !== false) {
        		echo "File is an image - " . $check["mime"] . ".";
        		$uploadOk = 1;
    		} else {
        		echo "File is not an image.";
        		$uploadOk = 0;
    		}

			// Check if file already exists
			if (file_exists($target_file)) {
    			echo "Sorry, file already exists.";
    			$uploadOk = 0;
			}
			// Check file size
			
			//if ($_FILES["fileToUpload"]["size"] > 500000) {
    		//	echo "Sorry, your file is too large.";
    		//	$uploadOk = 0;
			//}
				
			// Allow certain file formats
			if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"&& $imageFileType != "gif" ) {
    			echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
    			$uploadOk = 0;
			}
			// Check if $uploadOk is set to 0 by an error
			if ($uploadOk == 0) {
    			echo "Sorry, your file was not uploaded.";
			// if everything is ok, try to upload file
			} else {
    			if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
        			echo "The file ". basename( $_FILES["fileToUpload"]["name"]). " has been uploaded.";
    			} else {
        			echo "Sorry, there was an error uploading your file.";
        			return;
    			}
			}
		$image = basename($_FILES["fileToUpload"]["name"]);
		*/
		$image = "NULL"; // remove image for a while
		$sql = "INSERT INTO tbl_main_categories(main_category_name,main_category_image) values('$mcname','$image')";
		$res = mysql_query($sql) or die("Error in Query: ".mysql_error());
		echo "
			<script>
			alert('Main Category Added!');
			window.location.href = 'maintenance_maincategory.php';
			</script>
		";
	}

	if(isset($_POST['submitedit'])){
		$edit_mcname = ucwords(strtolower(trim($_POST['edit_mcname'])));
		$edit_ID = $_POST['edit_ID'];
		$sql = "UPDATE tbl_Main_Categories SET main_category_name = '$edit_mcname' WHERE main_category_ID = $edit_ID";
		$res = mysql_query($sql) or die("Error in Query: ".mysql_error());
		echo "
			<script>
			alert('Main Category Edited!');
			window.location.href = 'maintenance_maincategory.php';
			</script>
		";
	}

	if(isset($_POST['delete'])){
		$id = $_POST["id"];
		$sql = "UPDATE tbl_Main_Categories SET  deleted =  1 WHERE  main_category_ID = $id ";
		$res = mysql_query($sql) or die("Error in Query:" . mysql_error());
		echo "
			<script>
			alert('Main Category Deleted!');
			window.location.href = 'maintenance_maincategory.php';
			</script>
		";
	}
?>