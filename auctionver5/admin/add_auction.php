<?php
	session_start();
	mysql_connect('localhost','root') OR DIE (mysql_error());
	mysql_select_db ('db_auction') OR DIE ("Unable to select db" .mysql_error());
	include('adminparent.php');
?>
<script type="text/javascript" src="getIncrement.js"></script>
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
</script>
<div class="container">

<a class="waves-effect waves-light btn modal-trigger" href="#addModal">Modal</a>




  <table class="highlight responsive-table centered" id="tableOutput">
  <thead>
    <th>ID</th>
    <th>Auction Name</th>
    <th>Auction Description</th>
    <th>Item Name</th>
    <th>Starting Amount</th>
    <th>Current Price</th>
    <th>Start Date</th>
    <th>End Date</th>
    <th>Auction Status</th>
    <th>Action</th>
  </thead>
  <tbody>
          <?php
            $get = mysql_query("SELECT * FROM tbl_Auctions
            					INNER JOIN tbl_Items
            					ON tbl_Auctions.item_id = tbl_Items.item_id
            			");
            if(!mysql_num_rows($get)==0){
              while($get_row = mysql_fetch_assoc($get)){
                ?>
                <tr>
                  <td id="tdID<?php echo $get_row['auction_id']?>"><?php echo $get_row['auction_id']?></td>
                  <td id="tdAuctionName<?php echo $get_row['auction_id']?>"><?php echo $get_row['auction_name']?></td>
                  <td id="tdDescription<?php echo $get_row['auction_id']?>"><?php echo $get_row['auction_description']?></td>
                  <td id="tdItemName<?php echo $get_row['auction_id']?>"><?php echo $get_row['item_name']?></td>
                  <td id="tdStartingAmount<?php echo $get_row['auction_id']?>"><?php echo $get_row['starting_amount']?></td>
                  <td id="tdCurrentPrice<?php echo $get_row['auction_id']?>"><?php echo $get_row['current_price']?></td>
                  <td id="tdStartDate<?php echo $get_row['auction_id']?>"><?php echo $get_row['start_date']?></td>
                  <td id="tdEndDate<?php echo $get_row['auction_id']?>"><?php echo $get_row['end_date']?></td>
                  <td id="tdStatus<?php echo $get_row['auction_id']?>">
					<?php 
						if ($get_row['auction_status'] == 1){	
							echo "Ongoing";
						}
						else if($get_row['auction_status'] == 2){
							echo "Ended";
						}
					?></td>
                  <td><button id="<?php echo $get_row['auction_id']?>" value="<?php echo $get_row['increment_id']?>" name="edit" class="edit black btn white-text"><i class="material-icons" >edit</i></button>
                        <button id="delete" name="delete" class="black btn white-text"><i class="material-icons" onclick="">delete_forever</i></button></td>
                </tr>
                <?php
              }
            }
          ?>
  </tbody>
</table>

<div class="modal" id="addModal">
<div class="modal-content">
	<form action="" method="POST">
	<div class="row">
    	<div class="input-field col s4">
			<input name="auctionname" id="auctionname" type="text" class="validate" REQUIRED>
			<label class="black-text" for="auctionname">Auction Name</label>
		</div>
	</div>
	<div class="row">
    	<div class="input-field col s4">
			<textarea name="auctiondesc" id="auctiondesc" REQUIRED></textarea>
			<label class="black-text" for="auctiondesc">Auction Description</label>
		</div>
	</div>
	<div class="row">
    	<div class="input-field col s4">
			<input name="startingamount" id="startingamount" type="number" class="validate" onkeyup="setIncrement(this.value)" REQUIRED>
			<label class="black-text" for="startingamount">Starting Amount</label>
		</div>
    	<div id="hiddenincrement" class="input-field col s4">
		</div>
	</div>
	<!--
	<div class="row">
    	<div class="input-field col s4">
			<input name="starttime" id="starttime" type="time" class="validate">
			<label class="black-text active" for="starttime">Starting Time</label>
		</div>
    	<div class="input-field col s4">
			<input name="startdate" id="startdate" type="date" class="validate">
			<label class="black-text active" for="startdate">Starting Date</label>
		</div>
	</div>
	-->
	<div class="row">
    	<div class="input-field col s4">
			<input name="endtime" id="endtime" type="time" class="validate">
			<label class="black-text active" for="endtime">End Time</label>
		</div>
    	<div class="input-field col s4">
			<input name="enddate" id="enddate" type="date" class="validate">
			<label class="black-text active" for="enddate">End Date</label>
		</div>
	</div>
	<div class="row">
    	<div class="input-field col s4">
			<select class = "browser-default" name = 'itemid' id='itemid' REQUIRED>
				<option value = "" selected>Select Item:</option>
					<?php
						$get = mysql_query("SELECT * FROM tbl_Items WHERE item_status = 0");
						if(!mysql_num_rows($get)==0){
							while($get_row = mysql_fetch_assoc($get)){
								?><option value = "<?php echo $get_row['item_ID']; ?>"><?php echo $get_row['item_name']; ?></option>
								<?php
							}
						}
					?>
			</select>
			<label class="black-text active" for="itemid">Item Name</label>
		</div>
	</div>
	<br><br>
	<div class="row">
			<button class="btn waves-effect waves-light" type="submit" name="submit">Submit
				<i class="material-icons right">send</i>
			</button>
			<button class="btn waves-effect waves-light" type="reset" name="reset">Clear
				<i class="material-icons right">send</i>
			</button>
	</div>	
	</form>
</div>
</div>




<div class="modal" id="editModal">
<div class="modal-content">
	<form action="" method="POST">
	<input type="text" id="edit_ID" name="edit_ID">
	<div class="row">
    	<div class="input-field col s4">
			<input name="edit_auctionname" id="edit_auctionname" type="text" class="validate" REQUIRED>
			<label class="black-text" for="edit_auctionname">Auction Name</label>
		</div>
	</div>
	<div class="row">
    	<div class="input-field col s4">
			<textarea name="edit_auctiondesc" id="edit_auctiondesc" REQUIRED></textarea>
			<label class="black-text" for="edit_auctiondesc">Auction Description</label>
		</div>
	</div>
	<div class="row">
    	<div class="input-field col s4">
			<input name="edit_startingamount" id="edit_startingamount" type="number" class="validate" onkeyup="setIncrement(this.value)" REQUIRED>
			<label class="black-text" for="edit_startingamount">Starting Amount</label>
		</div>
    	<div id="hiddenincrement" class="input-field col s4">
		</div>
	</div>
	<!--
	<div class="row">
    	<div class="input-field col s4">
			<input name="starttime" id="starttime" type="time" class="validate">
			<label class="black-text active" for="starttime">Starting Time</label>
		</div>
    	<div class="input-field col s4">
			<input name="startdate" id="startdate" type="date" class="validate">
			<label class="black-text active" for="startdate">Starting Date</label>
		</div>
	</div>
	-->
	<div class="row">
    	<div class="input-field col s4">
			<input name="edit_endtime" id="edit_endtime" type="time" class="validate">
			<label class="black-text active" for="edit_endtime">End Time</label>
		</div>
    	<div class="input-field col s4">
			<input name="edit_enddate" id="edit_enddate" type="date" class="validate">
			<label class="black-text active" for="edit_enddate">End Date</label>
		</div>
	</div>
	<div class="row">
    	<div class="input-field col s4">
			<select class = "browser-default" name = 'edit_itemid' id='edit_itemid' REQUIRED>
				<option value = "" selected>Select Item:</option>
					<?php
						$get = mysql_query("SELECT * FROM tbl_Items WHERE item_status = 0");
						if(!mysql_num_rows($get)==0){
							while($get_row = mysql_fetch_assoc($get)){
								?><option value = "<?php echo $get_row['item_ID']; ?>"><?php echo $get_row['item_name']; ?></option>
								<?php
							}
						}
					?>
			</select>
			<label class="black-text active" for="edit_itemid">Item Name</label>
		</div>
	</div>
	<br><br>
	<div class="row">
			<button class="btn waves-effect waves-light" type="submit" name="submitedit">Submit
				<i class="material-icons right">send</i>
			</button>
			<button class="btn waves-effect waves-light" type="reset" name="reset">Clear
				<i class="material-icons right">send</i>
			</button>
	</div>	
	</form>
</div>
</div>


<script type="text/javascript">
	$(document).ready(function() {
		Materialize.updateTextFields();
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
		$auctionname = $_POST['auctionname'];
		$auctiondesc = $_POST['auctiondesc'];
		$startingamount = $_POST['startingamount'];
		$startdate = date('Y-m-d');
		$starttime = date('G:i:s');
		$enddate = $_POST['enddate'];
		$endtime = $_POST['endtime'];
		$itemid = $_POST['itemid'];
		$sql = mysql_fetch_assoc(mysql_query("SELECT * FROM tbl_Increments WHERE start_point <= $startingamount AND end_point >= $startingamount"));
		$incrementid = $sql['increment_ID'];
		$sql = "INSERT INTO tbl_Auctions(auction_name,auction_description,starting_amount,current_price,start_date,start_time,end_date,end_time,item_id,increment_id) values('$auctionname','$auctiondesc','$startingamount','$startingamount','$startdate','$starttime','$enddate','$endtime','$itemid','$incrementid')";
		$res = mysql_query($sql) or die("Error in Query: ".mysql_error());
		$sql = "UPDATE tbl_Items SET item_status = 1 WHERE item_ID = $itemid";
		$res = mysql_query($sql) or die("Error in Query: ".mysql_error());
		echo "Auction Added!";
	}
?>