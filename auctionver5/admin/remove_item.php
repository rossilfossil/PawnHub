<?php
	include "../connect_to_pms.php";
	if (!isset($_SESSION['item_stack'])){
		$_SESSION['item_stack'] = array();
	}

	$item = $_POST['itemID'];

	if(($key = array_search($item, $_SESSION['item_stack'])) !== false) {
    	unset($_SESSION['item_stack'][$key]);
    	if (empty($_SESSION['item_stack']))
    		unset($_SESSION['item_stack']);
	}

	?>
	<center><h5>Selected Items</h5></center>
	<table>
		<thead>
			<th>ID</th>
			<th>Name</th>
			<th>Price</th>
		</thead>		
		<tbody>
	<?php
	if(!empty($_SESSION['item_stack'])){	
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
		</tr>	
	<?php
	} // foreach
	} // if
	?>		
		</tbody>
	</table>