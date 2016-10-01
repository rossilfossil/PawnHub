<?php
	include "../connect_to_pms.php";
	include "adminparent.php";
?>
<script type="text/javascript" src="viewItemImage.js"></script>
 <!-- Modal Structure -->
	<div id="imageModal" class="modal">
      <div class="modal-content">
        <h4>Item Details</h4>
        <div class="black divider"></div>
        <div id="viewContent"></div> 	
        <!-- <div class="modal-footer">
          <a href="#!" class=" modal-action modal-close waves-effect waves-black btn-flat">Close</a>
        </div> -->
    		
      </div>
  </div>
      <script type="text/javascript">
    function removePic(a){
          var r = confirm("Are you sure you want to remove this image?");
          if (r == true) {
              window.location = 'removeImage.php?imgid='+a;
          }
    }
    </script>
<script type="text/javascript">

$(document).ready(function(){
    $('#tableOutput').DataTable({
    "bLengthChange": false,
    "pageLength" : 5
    });
})
 /*$(function(){   
          $('#tableOutput').on('click', '.addimg', function(){
             $('#imageModal').openModal();
              var selected = this.id;
              var keyID = $("#id"+selected).text();
              var keyName = $("#name"+selected).text();
              var keyImage = $("#price"+selected).text();
              $("#modalID").val(keyID);
              $("#modalName").val(keyName);
              $("#modalPrice").val(keyImage);
          });
      });   */
</script>
<div class="container">
<h3><center>Items</center></h3>
<div class="black divider"></div>
<div class="card">	
<table id="tableOutput">
	<thead>
		<tr>	
			<th>ID</th>
			<th>Name</th>
			<th>Appraise Value</th>
      <!-- <th>Status</th> -->
      <th>Images</th>
			<th></th>
		</tr>
	</thead>
	<tbody>
		<?php
			$sql = mysql_query("SELECT * FROM tbl_Items
								INNER JOIN tbl_Item
								ON tbl_Items.itemID = tbl_Item.itemID
                ");
                // WHERE item_status = 0 OR item_status = 1
			if (!mysql_num_rows($sql)==0){
				while($get_row = mysql_fetch_assoc($sql)){
          $itemid = $get_row['item_ID'];
          $numimg = mysql_num_rows(mysql_query("SELECT * FROM tbl_Images where item_ID = $itemid AND deleted = 0"))
					?>
					<tr>
						<td id="id<?php echo $get_row['item_ID']?>"><?php echo $get_row['item_ID']?></td>
						<td id="name<?php echo $get_row['item_ID']?>"><?php echo $get_row['itemName']?></td>
						<td id="price<?php echo $get_row['item_ID']?>"><?php echo $get_row['itemWorth']?></td>
            <!-- <td></td> -->
            <td><?php echo $numimg?></td>
						<td><button class="addimg btn black white-text" id="<?php echo $get_row['item_ID']?>" onclick="viewContent(<?php echo $get_row['item_ID']?> )">Images</button></td>
					</tr>
					<?php
				}
			}
		?>
	</tbody>
</table>


<script type="text/javascript">

	$(document).ready(function() {
		Materialize.updateTextFields();
	});
    $('.collapsible').collapsible({
      accordion : false // A setting that changes the collapsible behavior to expandable instead of the default accordion style
    });	

      $(document).ready(function(){
    // the "href" attribute of .modal-trigger must specify the modal ID that wants to be triggered
    $('.modal-trigger').leanModal();
  });

  	  $('.dropdown-button').dropdown({
      inDuration: 300,
      outDuration: 225,
      constrain_width: false, // Does not change width of dropdown to that of the activator
      hover: true, // Activate on hover
      gutter: 0, // Spacing from edge
      belowOrigin: false, // Displays dropdown below the button
      alignment: 'left' // Displays dropdown with edge aligned to the left of button
    }
  );

</script>

<?php
  if(isset($_POST['submit'])){
    $itemid = $_POST['itemid'];
    $target_dir = "../uploads/";
      $target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
      // echo "basename -> ".basename($_FILES["fileToUpload"]["name"]); // FILENAME
      $uploadOk = 1;
      $imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);
      // Check if image file is a actual image or fake image
        $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
        if($check !== false) {
            // echo "File is an image - " . $check["mime"] . ".";
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
        //  echo "Sorry, your file is too large.";
        //  $uploadOk = 0;
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
              // echo "The file ". basename( $_FILES["fileToUpload"]["name"]). " has been uploaded.";
              echo "<script>alert('Photo Uploaded!');</script>
    ";
          } else {
              // echo "Sorry, there was an error uploading your file.";
          }
      }
      $image = basename($_FILES["fileToUpload"]["name"]);
      $sql = "INSERT INTO tbl_Images(item_image,item_ID) values('$image','$itemid')";
      $res = mysql_query($sql) or die("Error in Query: ".mysql_error());

        echo "<script>
      window.location.href = 'itemimage.php';
      </script>
    ";

  }

?>