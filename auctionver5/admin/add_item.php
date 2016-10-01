<?php
	include "../connect_to_pms.php";
	if (!isset($_SESSION['item_stack'])){
		$_SESSION['item_stack'] = array();
	}

	$item = $_POST['itemID'];

	if(!in_array($item, $_SESSION['item_stack'])){			// checks if the value exists in the array	
		if(isset($_SESSION['auctiontype'])){
			if($_SESSION['auctiontype'] == 0){ 				// if ordinary auction
				unset($_SESSION['item_stack']);
				$_SESSION['item_stack'] = array();
				array_push($_SESSION['item_stack'], $item);
			}
			else if($_SESSION['auctiontype'] == 1){	
				array_push($_SESSION['item_stack'], $item);
			} 
		}
		else{	
			array_push($_SESSION['item_stack'], $item); 		// adds a value in an array
		}
	}	
	else{
		if(($key = array_search($item, $_SESSION['item_stack'])) !== false) {
    	unset($_SESSION['item_stack'][$key]);
    	if (empty($_SESSION['item_stack']))
    		unset($_SESSION['item_stack']);
		}
	}
	if(!empty($_SESSION['item_stack'])){	
	?>
		<center><h5>Selected Items</h5></center>
		<table id="itemTable">
			<thead>
				<th>ID</th>
				<th>Name</th>
				<th>Appraise Value</th>
			</thead>		
			<tbody>
		<?php
		foreach($_SESSION['item_stack'] as $value) {
	  		$sql = mysql_fetch_assoc(mysql_query("SELECT * FROM tbl_Items 
	  		  							INNER JOIN tbl_Item
	  		  							ON tbl_Items.itemID = tbl_Item.itemID
	  		  							WHERE item_ID = $value"));
		
		?>
				<tr>
					<td><?php echo $sql['item_ID'];?></td>
					<td><?php echo $sql['itemName'];?></td>
					<td><?php echo $sql['itemWorth'];?></td>	
				</tr>	
		<?php
		} // foreach
	} // if not empty stack
		?>		
			</tbody>
		</table>
		<script type="text/javascript">
			$(document).ready(function(){
    			$('#itemTable').DataTable({
    			"bLengthChange": false,
    			"pageLength" : 5
    			});
		})
		</script>