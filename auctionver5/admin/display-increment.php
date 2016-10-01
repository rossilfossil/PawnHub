<?php
	$con = mysql_connect('localhost','root') or die(mysql_error());
	mysql_select_db('pms') or die("Cannot Select db");
	$amount = $_POST['amount'];

	$sql = mysql_fetch_assoc(mysql_query("SELECT * FROM tbl_Increments WHERE start_point <= $amount AND end_point >= $amount"));
	if ($sql){	
		$increment = $sql['increment_amount'];
		echo "<input class='black-text' type='number' name='temp' value=$increment DISABLED>
					<label class='active black-text' for='temp'>Bid Increment</label>";
	}
	else{
		echo mysql_error();
	}
?>	