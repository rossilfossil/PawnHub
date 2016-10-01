<?php
	session_start();
	$_SESSION['auctiontype'] = $_POST['type'];
	if(isset($_SESSION['item_stack'])){	
       	unset($_SESSION['item_stack']);
	}

?>