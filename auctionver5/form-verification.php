<?php
	include('connect_to_pms.php');
	$_SESSION['redirect']="account.php";
	if(!isset($_SESSION['userId'])){
	    include('homepageparent.php');
	    echo "<center><h1>Please Log in!</h1></center>";
	    return;
	}
	else{ 
	    $user = $_SESSION['userId'];
	    $get_bidder = mysql_fetch_assoc(mysql_query("SELECT * FROM tbl_Bidders 
                                                       WHERE bidder_ID = $user"));
	    $receiver = $get_bidder['bidder_email'];
	    $status = $get_bidder['status'];
	    include('accessgrantedparent.php');
	    include('../email/samplemail.php');
	    if($status == 1){
	    	echo "<br><br><br><h3><center>ACCOUNT VERIFIED!</center></h3><br>
				<h5><center>You can now enjoy bidding!</center></h5><br>
	    	";
	    	return;
	    }
	}  
?>
	
<div class="container myfont"><br>
<h4><center>ACCOUNT VERIFICATION</center></h4>
<h5><center>Verify your account so you can enjoy bidding to our bidding system</center></h5><br>
<div class="container">
	<form action="verifyEmail.php" method="GET">
		<div class="white row">
			<input type="hidden" name="email" value="<?php echo $receiver?>">
			<input type="hidden" name="user" value="<?php echo $user?>">
			<div class="input-field col">
				<input id="vercode" name="vercode" type="text" maxlength="10">
				<label for="vercode">Verification Code</label>
			</div>
			<div class="input-filed col l12">
				<button class="btn black white-text right" type="submit">Verify</button>
			</div>
		</div>
	</form>
	<form action="" method="POST">
		<div class="row">
			<div class="input-filed col l12">
				Don't have verification code? 
				<button class="btn black white-text" type="submit" name="submit" href="">Resend</button>
			</div>
		</div>
	</form>

<?php
	if(isset($_POST['submit'])){
		function generateRandomString($length = 10) {
			$characters = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
				$charactersLength = strlen($characters);
				$randomString = '';
				for ($i = 0; $i < $length; $i++) {
				    $randomString .= $characters[rand(0, $charactersLength - 1)];
				}
				return $randomString;
		}
		$vercode = generateRandomString();
        $sql = "UPDATE tbl_Bidders SET verification_code = '$vercode' WHERE bidder_ID = $user";
        $res = mysql_query($sql) or die("Error in Query: ".mysql_error());

        $message = "Thank you for your interest in the Pawnshop-Auction System!<br><br>
						Verify your account so you can enjoy bidding!<br><br>
						Your Verification code is <b>$vercode</b><br><br>
		";
		sendEmail($receiver,$message);
		echo "
            <script>
            window.location.href = 'form-verification.php';
            alert('Your Verification Code has been sent to your email!');
            </script>
        ";
	}
?>	