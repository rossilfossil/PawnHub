<?php
  include('../connect_to_pms.php');
  if(!isset($_SESSION['branchId'])){
    include("adminhomeparent.php");
        echo "<br><br><br><br><br><br><br><center><h1>You have no access to this page</h1></center>";
    return;   
  }
  include"adminparent.php";
	
  
?>
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
              var keyStartPoint = $("#tdStartPoint"+selected).text();
              var keyEndPoint = $("#tdEndPoint"+selected).text();
              var keyAmount = $("#tdAmount"+selected).text();
              $("#edit_ID").val(keyID);
              $("#edit_startpoint").val(keyStartPoint);
              $("#edit_endpoint").val(keyEndPoint);
              $("#edit_amount").val(keyAmount);
          });
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

<div class="container">
    <div class="row">
      <div class="col l12">
          <h4><center>INCREMENT</center></h4>
          <div class="black divider"></div>


<div class="card">
    <a class="right modal-trigger black btn z-depth-3" href="#addModal"><i class="material-icons left">add</i>Add Increment</a>
       <table class="highlight centered" id="tableOutput">
        <thead>
          <th>ID</th>
          <th>Start</th>
          <th>End</th>
          <th>Increment</th>
          <th>Action</th>
        </thead>
        <tbody>
                <?php
                  $get = mysql_query("SELECT * FROM tbl_Increments WHERE deleted = 0 ORDER BY start_point");
                  if(!mysql_num_rows($get)==0){
                    while($get_row = mysql_fetch_assoc($get)){
                      $minstart = $get_row['end_point'];
                      $mininc = $get_row['increment_amount'];
                      ?>
                      <tr class="black-text">
                        <td id="tdID<?php echo $get_row['increment_ID']?>"><?php echo $get_row['increment_ID']?></td>
                        <td id="tdStartPoint<?php echo $get_row['increment_ID']?>"><?php echo $get_row['start_point']?></td>
                        <td id="tdEndPoint<?php echo $get_row['increment_ID']?>"><?php echo $get_row['end_point']?></td>
                        <td id="tdAmount<?php echo $get_row['increment_ID']?>"><?php echo $get_row['increment_amount']?></td>
                        <td width="20%">
                          <div class="col s6">  
                            <button id="<?php echo $get_row['increment_ID']?>" value="<?php echo $get_row['increment_ID']?>" name="edit" class="edit black btn white-text"><i class="material-icons" >edit</i></button>
                          </div>
                            <form action="" method="POST">
                              <input type="hidden" name="id" value="<?php echo $get_row['increment_ID']?>">
                              <button id="delete" name="delete" type="submit" class="black btn white-text"><i class="material-icons" onclick="">delete_forever</i></button></td>
                          </form>     
                      </tr>
                      <?php
                    }
                  }
                ?>
        </tbody>
</table>
</div>      
	
<div class="modal modal-width1" id="addModal">
	<div class="modal-content">
  <div class="modal-header center">
    <h5>Add Increment</h5>
  </div>
  <div class="divider"></div>
	<form action="" method="POST">
      <div class="container">
        <br>
  <div class="row">
      <div class="input-field col s4">
        <input name="startpoint" id="startpoint" step="0.01" type="number" min = "<?php echo $minstart+1?>" onchange = "document.getElementById('endpoint').min = parseInt(this.value)+1"class="validate" onkeyup = "validateNumberOnly(this.value,'startpoint')" REQUIRED>
        <label for="startpoint">Start Point</label>
      </div>
      <div class="input-field col s4">
        <input name="endpoint" id="endpoint" step="0.01" type="number" min = "<?php echo $minstart+1?>"  onchange = "document.getElementById('startpoint').max = this.value" class="validate" onkeyup = "validateNumberOnly(this.value,'endpoint')" REQUIRED>
        <label for="endpoint">End Point</label>
      </div>
      <div class="input-field col s4">
        <input name="amount" id="amount" step="0.01" type="number" min = "<?php echo $mininc?>" class="validate" onkeyup = "validateNumberOnly(this.value,'amount')" REQUIRED>
        <label for="amount">Amount</label>
    </div>
    </div>
  </div>  
  </div>
  <div class="modal-footer">
      <button class="btn btn-flat waves-effect waves-light" type="submit" name="submit">Submit
        <i class="material-icons right">send</i>
      </button>
      <button class="btn btn-flat waves-effect waves-light" type="reset" name="reset">Clear
        <i class="material-icons right">send</i>
      </button>
  </form>
    </div>
  </div>

<div class="modal modal-width1" id="editModal">
  <div class="modal-content">
 <div class="modal-header center">
    <h5>Edit Increment</h5>
  </div>
  <div class="divider"></div>  
  <form action="" method="POST">
  <input type="hidden" id="edit_ID" name="edit_ID">

  <br>
  <div class="row">
      <div class="input-field col s4">
      <input name="edit_startpoint" id="edit_startpoint" step="0.01" type="number" value=" " min="0" onchange = "document.getElementById('edit_endpoint').min = parseInt(this.value)+1" class="validate" onkeyup = "validateNumberOnly(this.value,'edit_startpoint')" REQUIRED>
      <label class="active" for="startpoint">Start Point</label>
    </div>
      <div class="input-field col s4">
      <input name="edit_endpoint" id="edit_endpoint" step="0.01" type="number" value=" " min="1" onchange = "document.getElementById('edit_startpoint').max = this.value" class="validate" onkeyup = "validateNumberOnly(this.value,'edit_endpoint')" REQUIRED>
      <label class="active" for="endpoint">End Point</label>
    </div>
      <div class="input-field col s4">
      <input name="edit_amount" id="edit_amount" step="0.01" type="number" value=" " min="1" class="validate" onkeyup = "validateNumberOnly(this.value,'edit_amount')" REQUIRED>
      <label class="active" for="amount">Amount</label>
    </div>
  </div>  
  </div>
      <div class="modal-footer">
      <button class="btn btn-flat waves-effect waves-light" type="submit" name="submitedit">Submit
        <i class="material-icons right">send</i>
      </button>
      <button class="btn btn-flat waves-effect waves-light" type="reset" name="reset">Clear
        <i class="material-icons right">send</i>
      </button>
    </div>
  </form>
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
    }
  );
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
		$startpoint = $_POST['startpoint'];
		$endpoint = $_POST['endpoint'];
		$amount = $_POST['amount'];
		$sql = "INSERT INTO tbl_Increments(start_point,end_point,increment_amount) values('$startpoint','$endpoint','$amount')";
		$res = mysql_query($sql) or die("Error in Query: ".mysql_error());
    echo "
      <script>
      alert('Bid Increment Added!');
      window.location.href = 'maintenance_increment.php';
      </script>
    ";
	}


  if(isset($_POST['submitedit'])){
    $id = $_POST['edit_ID'];
    $startpoint = $_POST['edit_startpoint'];
    $endpoint = $_POST['edit_endpoint'];
    $amount = $_POST['edit_amount'];
    $sql = "UPDATE tbl_Increments SET start_point = '$startpoint', end_point = '$endpoint', increment_amount = '$amount' WHERE increment_ID = '$id'";
    $res = mysql_query($sql) or die("Error in Query: ".mysql_error());

    echo "
      <script>
      alert('Bid Increment Edited!');
      window.location.href = 'maintenance_increment.php';
      </script>
    ";
  }


  if(isset($_POST['delete'])){
    $id = $_POST["id"];
    $sql = "UPDATE tbl_Increments SET  deleted =  1 WHERE  increment_ID = $id ";
    $res = mysql_query($sql) or die("Error in Query:" . mysql_error());
    echo "
      <script>
      alert('Bid Increment Deleted!');
      window.location.href = 'maintenance_increment.php';
      </script>
    ";
  }
?>