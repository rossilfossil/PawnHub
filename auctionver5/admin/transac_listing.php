<?php
	include('../connect_to_pms.php');
	include('adminparent.php');
	$get = mysql_query("SELECT * FROM tbl_Items
						INNER JOIN tbl_Item
						ON tbl_Items.itemid = tbl_Item.itemid
						WHERE tbl_Items.item_status = 0
	");
	if(mysql_num_rows($get)==0){
		echo "<script>alert('No items available for auction')</script>";
	}
?>
<script type="text/javascript" src="validation.js"></script>
<script type="text/javascript" src="maximumAuctionPeriod.js"></script>
<script type="text/javascript" src="additem.js"></script>
<script type="text/javascript">

$(document).ready(function(){
    $('#tableOutput').DataTable({
    "bLengthChange": false,
    "pageLength" : 5
    });

    $('#itemTable').DataTable({
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
<script type="text/javascript" src="getIncrement.js"></script>
<script type="text/javascript" src="getPricing.js"></script>
<script type="text/javascript" src="getAuctionType.js"></script>
<script type="text/javascript" src="getItem.js"></script>

 <!-- Modal Structure -->
  <div id="itemModal" class="modal">
    <div class="modal-content">
      <h4>Items</h4>
      <div id="itemlist2"></div>
    </div>
    <div class="modal-footer">
      <a href="#!" class=" modal-action modal-close waves-effect waves-green btn-flat">Close</a>
    </div>
  </div>

<!-- <form action="" method="POST">
	<input type="submit" name="back" value="back">
</form>
 --><div class="myfont container">
	
	<div class="row">
	<div class="col l12">
	<h4><center>CREATE LISTING</center></h4>
	<div class="black divider"></div>
	<div class="card-panel  blue-grey lighten-5">
    		<div class="row">
			<h5>ITEM LIST</h5>
			<div class="col s12 center">
    		<?php
    			if(!isset($_SESSION['auctiontype'])){
    				$_SESSION['auctiontype'] = 0; // ordinary
    			}
    			if(isset($_SESSION['auctiontype'])){
    				if($_SESSION['auctiontype'] == 0){
    					?>
    						<input type="radio" id="auctype2" name="auctype" onclick="setAuctionType(0)" checked/>
    						<label class="black-text" for="auctype2">Ordinary Auction</label>
    						&nbsp;
    						<input type="radio" id="auctype1" name="auctype" onclick="setAuctionType(1)" />
    						<label class="black-text" for="auctype1">Showcase Auction</label>
    					<?php
    				}
    				else{
    						?>
    						<input type="radio" id="auctype22" name="auctype2" onclick="setAuctionType(0)"/>
    						<label class="black-text" for="auctype22">Ordinary Auction</label>
    						&nbsp;
    						<input type="radio" id="auctype21" name="auctype2" onclick="setAuctionType(1)" checked/>
    						<label class="black-text" for="auctype2s1">Showcase Auction</label>
    						<?php
    				}	
    			}
    		?>		
    		</div>
    			<div class="input-field col s12 12 l12">
    				<center>	
    					<!-- <a class="btn black white-text modal-trigger" onclick="getItem.js">Add Item</a> -->
						<button class="btn black white-text" onclick="getItem()">SELECT ITEMS</button>
    				</center>	
				</div>
    		</div>
			<div class="row">
				<div id="itemList">
<?php
	if(!empty($_SESSION['item_stack'])){
?>
		<center><h5>Selected Items</h5></center>
		<table id="itemTable">
			<thead>
				<th>ID</th>
				<th>Name</th>
				<th>Appraise Value</th>
				<!-- <th></th> -->
			</thead>		
			<tbody>
		<?php
		foreach($_SESSION['item_stack'] as $value) {
	  		//print $value;
	  		$sql = mysql_fetch_assoc(mysql_query("SELECT * FROM tbl_Items 
	  		  							INNER JOIN tbl_Item
	  		  							ON tbl_Items.itemID = tbl_Item.itemID
	  		  							WHERE item_ID = $value"));
		
		?>
				<tr>
					<td><?php echo $sql['item_ID'];?></td>
					<td><?php echo $sql['itemName'];?></td>
					<td><?php echo $sql['itemWorth'];?></td>	
					<!-- <td><button class="btn black white-text" onclick="removeItem(<?php //echo $sql['item_ID']?>)">remove</button></td> -->		
				</tr>	
		<?php
		} // foreach
	}
		?>		
			</tbody>
		</table>
				</div>
			</div>
			<div class="black divider"></div>
					<form action="" method="POST" enctype="multipart/form-data">
			<div class="row">
			<h5>LISTING DETAILS</h5>
			<br>
    			<div class="input-field col s12">
				<input name="auctionname" id="auctionname" type="text" class="validate" onkeyup = "validateNoSpecs(this.value,'auctionname')" maxlength="25" required>
				<label class="black-text" for="auctionname">Auction Name</label>
				</div>

   				<div class="input-field col s12">
					<textarea name="auctiondesc"  id="auctiondesc" class="materialize-textarea"  required></textarea>
 
					<label class="black-text" for="auctiondesc">&nbsp;Auction Description</label>
				</div>		
			</div>		
			<div class="black divider"></div>
			<div class="row">
				<h5>CATEGORY</h5>
				<br>
				<div class="input-field col s12 m4 l4">
					<select class="browser-default" name='mcat' id='mcat' onchange="setCategory(this.value)" required>
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
				<div class="input-field col s12 m4 l4">
					<select class="browser-default" name='scate' id='scate' onchange="setSubCategory(this.value)" required>
							<option value="" selected disabled>Select Category</option>	
					</select>

					<label class="black-text active" for="itemid">Category</label>
				</div>
				<div class="input-field col s12 m4 l4">
					<select class="browser-default" name='subcat' id='subcat' required>
							<option value="" selected disabled>Select Sub Category</option>	
					</select>
					<label class="black-text active" for="itemid">Sub Category</label>
				</div>
			</div>
			<div class="black divider"></div>
			<div class="row">
			<h5>PRICING</h5>
				<br>
				<!-- <div class="input-field col l4 m4 s12" id="idealPrice">
					<input name="ip" type="text" class="black-text" value="0" DISABLED>
					<label for="ip" class="black-text active">Ideal Price</label>
				</div> -->
	    		<div class="input-field col l4 m4 s12">
					<input name="startingamount" id="sm" type="number" value="0" step="0.01" class="validate" onkeyup="setIncrement(this.value);validateNumberOnly(this.value,'sm')" min="1" required>
					<label class="black-text" for="startingamount">Starting Amount</label>
				</div>
	    		<div id="hiddenincrement" class="input-field col s12 m4 l4">
	    			<input value="0" id="" name="temp" type="number" class="black-text" DISABLED>
					<label class="active black-text" for="temp">Bid Increment</label>
				</div>
			</div>
		<div class="black divider"></div>	
		<div class="row">
			<h5>START</h5>
				<br>
	    	<div class="input-field col l6 m6 s12">
				<input name="startdate" id="startdate" min="<?php echo date('Y-m-d');?>" oninput="onchange=setMaxDate(this.value);document.getElementById('enddate').min=this.value;" type="date" class="validate">
				<label class="black-text active" for="startdate">Start Date</label>
			</div>
	    	<div class="input-field col l6 m6 s12">
				<input name="starttime" id="starttime" type="time" class="validate">
				<label class="black-text active" for="starttime">Start Time</label>
			</div>
		</div>	
		<div class="black divider"></div>	

		<div class="row">
			<h5>END</h5>
				<br>
	    	<div class="input-field col l6 m6 s12">
				<input name="enddate" id="enddate" min="<?php echo date('Y-m-d');?>" onchange="document.getElementById('startdate').max=this.value" type="date" class="validate">
				<label class="black-text active" for="enddate">End Date</label>
			</div>
	    	<div class="input-field col l6 m6 s12">
				<input name="endtime" id="endtime" type="time" class="validate">
				<label class="black-text active" for="endtime">End Time</label>
			</div>
		</div>
	    <!--
		<div class="black divider"></div>	
		<div class="row">
				<h5>LISTING IMAGE</h5>
					<br>&nbsp;
	    		<input type="file" class="" name="fileToUpload" id="fileToUpload" required>
	    
    <div class="file-field input-field">
      <div class="btn btn-small black white-text">
        <span>Upload Photo</span>
        <input type="file" class="file-path validate" name="fileToUpload" id="fileToUpload">
      </div>
      <div class="file-path-wrapper">
	    <!--<input type="text" class="file-path validate" name="fileToUpload" id="fileToUpload">-->
		<br>
		<div class="black divider"></div>	
		<br><br>
      <!--
		</div>
    </div>
	</div>
	    -->
		<div class="modal-footer">
				<button class="btn btn-flat waves-effect waves-light"  type="submit" name="submit">Submit
					<i class="material-icons right">send</i>
				</button>
				<button class="btn btn-flat waves-effect waves-light"  type="reset" name="reset">Clear
					<i class="material-icons right">send</i>
				</button>
				</form>
			</div>
	</form>
</div>	<!--End Card-->
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

	$(document).ready(function(){
		$('#itemTable').DataTable();
	});

</script>
<?php
	if(isset($_POST['submit'])){
		if(!isset($_SESSION['item_stack'])){
			echo "<script>alert('No Items Selected!')</script>";
			return;
		}
		$sql = mysql_fetch_assoc(mysql_query("SELECT * FROM tbl_biddingConstants WHERE bc_ID = 1"));
		$deadlineperiod = $sql['deadline_period'];
		$auctionname = $_POST['auctionname'];
		$auctiondesc = $_POST['auctiondesc'];
		$startingamount = $_POST['startingamount'];
		$startdate = $_POST['startdate'];
		$starttime = $_POST['starttime'];
		$enddate = $_POST['enddate'];
		$endtime = $_POST['endtime'];
		$deadline_date = date("Y-m-d",strtotime("+$deadlineperiod hours",strtotime($enddate)));
		$deadline_time = $endtime;
		$subcat = $_POST['subcat'];
		$sql = mysql_fetch_assoc(mysql_query("SELECT * FROM tbl_Increments WHERE start_point <= $startingamount AND end_point >= $startingamount"));
		$incrementid = $sql['increment_ID'];
		$sql = "INSERT INTO tbl_Auctions(auction_name,auction_description,starting_amount,current_price,start_date,start_time,end_date,end_time,increment_id,subcategory_id,auction_status,deadline_date,deadline_time) values('$auctionname','$auctiondesc','$startingamount','$startingamount','$startdate','$starttime','$enddate','$endtime','$incrementid','$subcat','0','$deadline_date','$deadline_time')";
		$res = mysql_query($sql) or die("Error in Query: ".mysql_error());

		$get = mysql_fetch_assoc(mysql_query("SELECT * FROM tbl_Auctions ORDER BY auction_ID DESC LIMIT 1"));
		$auctionid = $get['auction_ID'];
		foreach ($_SESSION['item_stack'] as $value) {
			$sql = "UPDATE tbl_Items SET item_status = 1 WHERE item_ID = $value";
			$res = mysql_query($sql) or die("Error in Query: ".mysql_error());
			$get = mysql_fetch_assoc(mysql_query("SELECT * FROM tbl_Items WHERE item_ID = $value"));
			$itemID = $get['item_ID'];
			$sql = "INSERT INTO tbl_Auctionitems(auction_ID,item_ID) values('$auctionid','$itemID')";
			$res = mysql_query($sql) or die("Error in Query: ".mysql_error());
		}
		unset($_SESSION['item_stack']);
		echo "<script>
		Materialize.toast('Listing Added!',4000,'black');

		</script>
		";
		}
//	}

		if(isset($_POST['back'])){

		echo "<script>
		Materialize.toast('Listing Added!',4000,'black')
		window.location = 'auctionlistings.php';
		</script>
		";			
		}
		// put 2 sec timer here
?>