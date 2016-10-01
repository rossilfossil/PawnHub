<?php
	include("../connect_to_pms.php");
	$get = mysql_query("SELECT * FROM tbl_Items
						INNER JOIN tbl_Item
						ON tbl_Items.itemid = tbl_Item.itemid
						WHERE tbl_Items.item_status = 0
	");
	if(mysql_num_rows($get)==0){
		echo "<center><h3>No Items available for auction</h3></center>";
	}
	else{
?>
				<table class="highlight responsive-table centered" id="itemTable">
					<thead>
						<th></th>
						<th>ID</th>
						<!--<th>Image</th>-->
						<!-- <th>Category</th> -->
						<th>Name</th>
						<!--<th>Status</th>-->
					</thead>
					<tbody>		
								<?php
								while($get_row = mysql_fetch_assoc($get)){
						?>				
									<tr class="black-text">
										<td width="20%">
											<?php
												if($_SESSION['auctiontype']==1){
													if(!isset($_SESSION['item_stack'])){
														?>
															<input type="checkbox" name="test<?php echo $get_row['item_ID']?>" id="test<?php echo $get_row['item_ID']?>" onclick="addItem(<?php echo $get_row['item_ID']?>)" >
														<?php	
													}
													else if(in_array($get_row['item_ID'],$_SESSION['item_stack'])){
														?>
															<input type="checkbox" name="test<?php echo $get_row['item_ID']?>" id="test<?php echo $get_row['item_ID']?>" onclick="addItem(<?php echo $get_row['item_ID']?>)" CHECKED>
														<?php
														}
													else{
														?>
															<input type="checkbox" name="test<?php echo $get_row['item_ID']?>" id="test<?php echo $get_row['item_ID']?>" onclick="addItem(<?php echo $get_row['item_ID']?>)">
														<?php
													}
													?>
												<label for="test<?php echo $get_row['item_ID']?>"></label>

													<?php
												}else{

													if(!isset($_SESSION['item_stack'])){
														?>
															<input type="radio" name="itemradio" id="test2<?php echo $get_row['item_ID']?>" onclick="addItem(<?php echo $get_row['item_ID']?>)" >
															<label for="test2<?php echo $get_row['item_ID']?>"></label>
														<?php	
													}
													else if(in_array($get_row['item_ID'],$_SESSION['item_stack'])){
														?>
															<input type="radio" name="itemradio" id="test2<?php echo $get_row['item_ID']?>" onclick="addItem(<?php echo $get_row['item_ID']?>)" CHECKED>
															<label for="test2<?php echo $get_row['item_ID']?>"></label>
														<?php
														}
													else{
														?>
															<input type="radio" name="itemradio" id="test2<?php echo $get_row['item_ID']?>" onclick="addItem(<?php echo $get_row['item_ID']?>)">
															<label for="test2<?php echo $get_row['item_ID']?>"></label>
														<?php
													}
												}	
												?>
												<label for="test2<?php echo $get_row['item_ID']?>"></label>

											</div>
										</td>
										<td id="tdID<?php echo $get_row['item_ID']?>" width="10%"><?php echo $get_row['item_ID']?></td>
										<!-- <td>category</td> -->
										<td id="tdName<?php echo $get_row['item_ID']?>"><?php echo $get_row['itemName']?></td>
									</tr>
						<?php
									} // while
								} // else
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

	$(document).ready(function(){
		$('#itemTable').DataTable();
	});

</script>