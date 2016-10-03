<?php
    include('connect_to_pms.php');
	// check if logged in, if yes, redirect to home.php
	include('homepageparent.php');
	include('../email/samplemail.php');
?>
<script type="text/javascript" src="admin/getCity.js"></script>
<script type="text/javascript" src="admin/validation.js"></script>
<link rel="stylesheet" type="text/css" href="css/mycss.css">		

<div class="container grey lighten-2 myfont reg-width">
<h4 class="center myfont"><br>BIDDER REGISTRATION</h4>
	<div class="divider "></div>
	<center>
	<form action="" method="POST">
			<div class="row myfont row-width1">
    		<div class="input-field col l4 m4 s12">
				<input name="firstname" id="firstname" type="text" class="validate" onkeyup = "validateTextOnly(this.value,'firstname')" REQUIRED>
				<label for="firstname">First Name</label>
			</div>
    		<div class="input-field col l4 m4 s12">
				<input name="middlename" id="middlename" type="text" class="validate" onkeyup = "validateTextOnly(this.value,'middlename')" >
				<label for="middlename">Middle Name</label>
			</div>
    		<div class="input-field col l4 m4 s12">
				<input name="lastname" id="lastname" type="text" class="validate"  onkeyup = "validateTextOnly(this.value,'lastname')" REQUIRED>
				<label for="lastname">Last Name</label>
			</div>
		</div>
		<div class="row row-width1">
			<div class="input-field col l4 m4 s12">
				<input name="housenumber" id="housenumber" type="text" class="validate" onkeyup = "validateNoSpecs(this.value,'housenumber')" REQUIRED>
				<label for="housenumber">House Number</label>
			</div>
			<div class="input-field col l4 m4 s12">
				<input name="street" id="street" type="text" class="validate" onkeyup = "validateTextOnly(this.value,'street')" REQUIRED>
				<label for="street">Street</label>
			</div>
			<div class="input-field col l4 m4 s12">
				<input name="barangay" id="barangay" type="text" class="validate" onkeyup = "validateTextOnly(this.value,'barangay')"REQUIRED>
				<label for="barangay">Barangay</label>
			</div>

		</div>
		<div class="row row-width1">
			<div class="input-field col s12 m6 l6">
				<select class="browser-default" name='province' id='province' onchange="setCity(this.value)" REQUIRED>
					<option value = "" selected disabled>Select Province:</option>
					<?php
						$get = mysql_query("SELECT * FROM tbl_Provinces ORDER BY province_name ASC");
						if(!mysql_num_rows($get)==0){
							while($get_row = mysql_fetch_assoc($get)){
							?><option value = "<?php echo $get_row['province_ID']; ?>"><?php echo $get_row['province_name']; ?></option>
						<?php
							}
						}
					?>
				</select>
				<label class="black-text active" for="itemid">Province</label>
			</div>
			<div class="input-field col s12 m6 l6">
				<select class="browser-default" name='city' id='delivery_city' REQUIRED>
						<option value="" selected disabled>Select City</option>	
				</select>

				<label class="black-text active" for="itemid">City</label>
			</div>
		</div>
		<div class="row row-width1">
			<div class="input-field col l6 m6 s12">
				<input name="contact" id="contact" type="text" class="validate" maxlength="11" onkeyup = "validateNumberOnly(this.value,'contact')" REQUIRED>
				<label for="contact">Contact Number</label>
			</div>
			<div class="input-field col l6 m6 s12">
				<input name="email" id="email" type="email" class="validate" REQUIRED>
				<label for="email">Email Address</label>
			</div>
		</div>
		<div class="row row-width1">
			<div class="input-field col l4 m4 s12">
				<input name="username" id="username" type="text" class="validate" minlength="8" maxlength="20" REQUIRED>
				<label for="username">Username</label>
			</div>
			<div class="input-field col l4 m4 s12">
				<input name="password1" id="password1" type="password" class="validate" minlength="8" maxlength="20" REQUIRED>
				<label for="password">Password</label>
			</div>
			<div class="input-field col l4 m4 s12">
				<input name="password" id="password" type="password" class="validate" minlength="8" maxlength="20" REQUIRED>
				<label for="password">Confirm Password</label>
			</div>
		</div>

		
		<div class="row row-width1" >
		<div class="col l3">

			<button class="btn black white-text waves-effect waves-light" type="submit" name="submit">Register
				<i class="material-icons right">send</i>
			</button>
			</div>
			<div class="col l3">
			<button class="btn black white-text waves-effect waves-light" type="reset" name="reset">Clear
				<i class="material-icons right">send</i>
			</button>
			</div>
			
		</div>
		
	</form>
	<br>
</center>
   <script>

	var password = document.getElementById("password1");
	var confirm_password = document.getElementById("password");

	function validatePassword(){
		if(password.value != confirm_password.value) {
			confirm_password.setCustomValidity("Passwords Don't Match");
		} else {
			confirm_password.setCustomValidity('');
		}
	}

password1.onchange = validatePassword;
password.onkeyup = validatePassword;
    </script>

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
            $firstname = addslashes(htmlspecialchars(ucwords(strtolower(trim($_POST['firstname'])))));
            $middlename = addslashes(htmlspecialchars(ucwords(strtolower(trim($_POST['middlename'])))));
            $lastname = addslashes(htmlspecialchars(ucwords(strtolower(trim($_POST['lastname'])))));
            $province = trim($_POST['province']);
            $city = trim($_POST['city']);
            $barangay = ucwords(strtolower(trim($_POST['barangay'])));
            $street = ucwords(strtolower(trim($_POST['street'])));
            $housenumber = ucwords(strtolower(trim($_POST['housenumber'])));
            $contact = trim($_POST['contact']);
            $email = trim($_POST['email']);
            $username = trim($_POST['username']);
            $password = trim($_POST['password']);    
            $regdate = date("Y-m-d");
            $regtime = date("G:i:s");
            $vercode = generateRandomString();
			$sql = "INSERT INTO tbl_Bidders(bidder_firstname,bidder_middlename,bidder_lastname,bidder_province,bidder_city,bidder_barangay,bidder_street,bidder_housenumber,bidder_contact,bidder_email,bidder_username,bidder_password,registration_date,registration_time,verification_code,status) values('$firstname','$middlename','$lastname','$province','$city','$barangay','$street','$housenumber','$contact','$email','$username','$password','$regdate','$regtime','$vercode','0')";
			// var_dump($sql);
			$res = mysql_query($sql) or die("Error in Query: ".mysql_error());
			$message = "Thank you for your interest in the Pawnshop-Auction System!<br><br>
						Verify your account so you can enjoy bidding<br><br>
						Your Verification code is <b>$vercode</b><br><br>

			";
			sendEmail($receiver,$message);

			$get = mysql_fetch_assoc(mysql_query("SELECT * FROM tbl_Bidders ORDER BY bidder_ID DESC LIMIT 1"));
			$id = $get['bidder_ID'];
			$name = $get['bidder_username'];


			$_SESSION['userId'] = $id;
			$_SESSION['userName'] = $name;
			if(isset($_SESSION['redirect'])){
				$redirect = $_SESSION['redirect'];
			}
			else{
				$redirect = "home.php";
			}
			echo "
					<script>
					window.location.href = '$redirect';
					alert('Welcome');
					</script>
			";
		}
	?>
	<script type="text/javascript">
	  	$('.modal-trigger').leanModal({
			dismissible: true, // Modal can be dismissed by clicking outside of the modal
			opacity: .5, // Opacity of modal background
			in_duration: 300, // Transition in duration
			out_duration: 200, // Transition out duration
    	});
	</script>