<?php
	session_start();
	unset($_SESSION['sess_user']);
	unset($_SESSION['userId']);
	echo "
		<script>
		window.location.href = '../auctionver5';
		alert('Logging Out');
		</script>
	";
	session_destroy();
?>