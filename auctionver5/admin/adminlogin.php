<?php
	
    include('../connect_to_pms.php');

	if(isset($_POST['submit']))
	{
		$user = $_POST['enterUsername'];
		$pass = $_POST['enterPassword'];
		$id = "";
		$dbusername = "";
		$dbpassword = "";
		$query = mysql_query("SELECT * FROM tbl_user WHERE username = '".$user."' AND password = '".$pass."'" );
		$numrows = mysql_num_rows($query);
		if($numrows != 0)
		{
			while($row = mysql_fetch_assoc($query))
			{
				$dbusername = $row['username'];
				$dbpassword = $row['password'];
				$id = $row['userId'];
				$branch = $row['branchId'];
			}

			if($user == $dbusername && $pass == $dbpassword)
			{
				$_SESSION['userId'] = $id;
				$_SESSION['branchId'] = $branch;

				if(isset($_SESSION['redirect'])){
					$redirect = $_SESSION['redirect'];
				}
				else{
					$redirect = "transac_request.php";
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
					window.location.href = 'adminlogin.php';
					alert('Invalid Username or Password');
					</script>
				";
		}
}
?>