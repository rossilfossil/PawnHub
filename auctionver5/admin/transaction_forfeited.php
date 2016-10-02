
<?php
	include"../connect_to_pms.php";
	if(!isset($_SESSION['branchId'])){
		include("adminhomeparent.php");
        echo "<br><br><br><br><br><br><br><center><h1>You have no access to this page</h1></center>";
		return;		
	}
	include"adminparent.php";
	$today = date("Y-m-d");
?>
<script type="text/javascript" src="viewAuction.js"></script>
<script type="text/javascript" src="maximumAuctionPeriod.js"></script>

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
 <!-- Modal Structure -->
	<div id="reauctionModal" class="modal">
	    <div class="modal-content">
         	<form action="" method="POST" enctype="multipart/form-data">
			<h4>Reauction</h4>
			<div class="black divider"></div>
			<div class="row">
				<div class="col s12">	
	         		<input type="hidden" name="modalID" id="modalID" required>
				</div>
				<div class="col m6 l6 s12">	
	         		<label for="modalName">Auction Name</label>
	         		<input type="text" name="modalName" id="modalName" required>
	         	</div>
				<div class="col m6 l6 s12">		
	         		<label for="modalDesc">Auction Description</label>
	         		<input type="text" name="modalDesc" id="modalDesc" required>
				</div>
			</div>		
			<div class="row">
				<div class="col s12">
         			<label for="modalPrice">Price</label>
         			<input type="number" name="modalPrice" step="0.01" id="modalPrice" required>
				</div>	
			</div>
			<div class="row">
				<div class="col s12 m6 l6">
         			<label for="modalSDate">Start Date</label>
					<input type="date" id="modalDate" name="modalSDate" class="validate" min="<?php echo $today?>" oninput="onchange=setMaxDate(this.value);document.getElementById('enddate').min=this.value" required>
				</div>
				<div class="col s12 m6 l6">
         			<label for="modalSTime">Start Time</label>
					<input type="time" id="modalTime" name="modalSTime" class="validate" required>
				</div>
			</div>
			<div class="row">
				<div class="col s12 m6 l6">	
         			<label for="enddate">End Date</label>
					<input type="date" id="enddate" name="enddate" class="validate" min="<?php echo $today?>" onchange="document.getElementById('modalDate').max=this.value" required>         	
				</div>
				<div class="col s12 m6 l6">
					<label for="modalETime">End Time</label>
					<input type="time" id="modalETime" name="modalETime" class="validate" required>
				</div>
			</div>			
			
         	<button class="btn black white-text" type="submit" name="submit">Submit</button>
         	</form>
         	<!--
			<div class="modal-footer">
      			<a href="#!" class=" modal-action modal-close waves-effect waves-green btn-flat">Agree</a>
    		</div>
    		-->
    	</div>
    </div>
<script type="text/javascript">
$(document).ready(function(){
    $('#tableOutput').DataTable({
    "bLengthChange": false,
    "pageLength" : 5,
    "order": [[0,"DESC"]]	
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
          $('#tableOutput').on('click', '.reauction', function(){
             $('#reauctionModal').openModal();
              var selected = this.id;
              var keyID = $("#id"+selected).text();
              var keyName = $("#name"+selected).text();
              var keyImage = $("#price"+selected).text();
              $("#modalID").val(keyID);
              $("#modalName").val(keyName);
              $("#modalPrice").val(keyImage);
          });
      });   

 // function wat(){
 	// document.getElementById('viewContent').innerHTML = "shit";
 	// $('#viewModal').openModal();
 // }
</script>

<div class="myfont container">
    <div class="row">
		<div class="col l12">
			<h4><center>FORFEITED AUCTIONS</center></h4>
			<div class="black divider"></div>
			<div class="card">
				<table  class="highlight centered" id="tableOutput">
					<thead>
						<th>ID</th>
						<!-- <th>Current Winner</th> -->
						<th>Auction Name</th>
						<th>Price</th>
						<th>Deadline</th>
						<th></th>
					</thead>
					<tbody>
						<?php
							$get = mysql_query("SELECT * FROM tbl_Auctions
													WHERE auction_status = 3 OR auction_status = 6
												");
							if(!mysql_num_rows($get)==0){
								while($get_row = mysql_fetch_assoc($get)){
						?>
									<tr class="black-text">
										<td id="id<?php echo $get_row['auction_ID']?>"><?php echo $get_row['auction_ID']?></td>
										<!-- <td></td>										 -->
										<td  id="name<?php echo $get_row['auction_ID']?>"><?php echo $get_row['auction_name']?></td>										
										<td id="price<?php echo $get_row['auction_ID']?>"><?php echo $get_row['current_price']?></td>
										<td id="deadlinedate<?php echo $get_row['auction_ID']?>"><?php echo date("M jS, Y", strtotime($get_row['deadline_date']))." ".date("g:i:s a", strtotime($get_row['deadline_time']))?></td>

										<td>
										<!-- <form action="" method="POST"> -->
											<input type="hidden" name="aucid" value="<?php echo $get_row['auction_ID']?>">
											<button class="btn black white-text" onclick="viewContent(<?php echo $get_row['auction_ID']?>)">View</button>
											<!-- <button class="btn black white-text" onclick="">2nd</button> -->
											<button class="reauction btn black white-text" id="<?php echo $get_row['auction_ID']?>">Reauction</button>
										<!-- </form> -->
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

<?php
	if(isset($_POST['submit'])){
		$id = $_POST['modalID']; // id ng dating auction
		$sql = mysql_fetch_assoc(mysql_query("SELECT * FROM tbl_biddingConstants WHERE bc_ID = 1"));
		$deadlineperiod = $sql['deadline_period'];
		$auctionname = $_POST['modalName'];
		$auctiondesc = $_POST['modalDesc'];
		$startingamount = $_POST['modalPrice'];
		$startdate = $_POST['modalSDate'];
		$starttime = $_POST['modalSTime'];
		$enddate = $_POST['enddate'];
		$endtime = $_POST['modalETime'];
		$deadline_date = date("Y-m-d",strtotime("+$deadlineperiod hours",strtotime($enddate)));
		$deadline_time = $endtime;
		$getsubcat = mysql_fetch_assoc(mysql_query("SELECT * FROM tbl_Auctions WHERE auction_ID = $id"));
		$subcat = $getsubcat['subcategory_ID']; 

		$sql = mysql_fetch_assoc(mysql_query("SELECT * FROM tbl_Increments WHERE start_point <= $startingamount AND end_point >= $startingamount"));
		$incrementid = $sql['increment_ID'];
		$sql = "INSERT INTO tbl_Auctions(auction_name,auction_description,starting_amount,current_price,start_date,start_time,end_date,end_time,increment_id,subcategory_id,auction_status,deadline_date,deadline_time) values('$auctionname','$auctiondesc','$startingamount','$startingamount','$startdate','$starttime','$enddate','$endtime','$incrementid','$subcat','0','$deadline_date','$deadline_time')";
		$res = mysql_query($sql) or die("Error in Query: ".mysql_error());
		// var_dump($sql);
		// echo "<BR>";
		$get = mysql_fetch_assoc(mysql_query("SELECT * FROM tbl_Auctions ORDER BY auction_ID DESC LIMIT 1"));
		$auctionid = $get['auction_ID']; // latest

		$get = mysql_query("SELECT * FROM tbl_auctionitems WHERE auction_ID = $id");
			while ($get_row = mysql_fetch_assoc($get)) {
				// echo"AGAGAGANA NA TO";
				$itemid = $get_row['item_ID']; // got the item id
				$sql = "UPDATE tbl_Items SET item_status = 1 WHERE item_ID = $itemid";
				$res = mysql_query($sql) or die("Error in Query: ".mysql_error());
				// var_dump($sql);
				// echo "<BR>";
				$sql1 = "INSERT INTO tbl_Auctionitems(auction_ID,item_ID) values('$auctionid','$itemid')";
				$res= mysql_query($sql1) or die("Error in Query: ".mysql_error());
				// var_dump($sql1);
				// echo "<BR>";
			}
		$sql = "UPDATE tbl_Auctions SET auction_status = 4 WHERE auction_ID = $id";
	 	$res = mysql_query($sql) or die("Error in Query: ".mysql_error());
		// var_dump($sql);
	}
?>