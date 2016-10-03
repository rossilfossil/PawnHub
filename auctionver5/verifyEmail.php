<?php
	include_once("connect_to_pms.php");
	$user = $_GET['user'];
	$email = $_GET['email'];
	$vercode = $_GET['vercode'];

	$get = mysql_query("SELECT * FROM tbl_Bidders WHERE bidder_ID = $user AND bidder_email = '$email' AND verification_code = '$vercode' AND status='0'");
	if(!mysql_num_rows($get)==0){
		while($get_row = mysql_fetch_assoc($get)){
				echo "update";	
				$sql = "UPDATE tbl_Bidders SET status = 1 WHERE bidder_ID = $user AND bidder_email = '$email' AND verification_code = '$vercode' AND status='0'";
    			$res = mysql_query($sql) or die("Error in Query: ".mysql_error());
				echo "
					<script>
					window.location.href = 'form-verification.php';
					alert('Account Verified!');
					</script>
				";
		} // endwhile
	} // endif	
	else{
		echo "
					<script>
					window.location.href = 'form-verification.php';
					alert('Invalid Verification Code!');
					</script>
				";
	}
?>