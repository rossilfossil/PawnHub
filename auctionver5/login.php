<?php
	
    include('connect_to_pms.php');

	if(isset($_POST['submit']))
	{
		$user = $_POST['enterUsername'];
		$pass = $_POST['enterPassword'];
		$id = "";
		$dbusername = "";
		$dbpassword = "";
		$query = mysql_query("SELECT * FROM tbl_Bidders WHERE bidder_username = '".$user."' AND  bidder_password = '".$pass."'" );
		$numrows = mysql_num_rows($query);
		if($numrows != 0)
		{
			while($row = mysql_fetch_assoc($query))
			{
				$dbusername = $row['bidder_username'];
				$dbpassword = $row['bidder_password'];
				$id = $row['bidder_ID'];
				$name = $row['bidder_username'];
			}

			if($user == $dbusername && $pass == $dbpassword)
			{
				$_SESSION['sess_user'] = $user;
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
					alert('Successfully Logged In');
					</script>
				";
			}
		}
		else
		{
			echo "
					<script>
					window.location.href = 'index.php';
					alert('Invalid Username or Password');
					</script>
				";
		}
}
?>