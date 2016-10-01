<?php
    include('../connect_to_pms.php');
	if(isset($_SESSION['branchId'])){
		echo "
				<script>
				window.location.href = 'dashboard.php';
				</script>
			";		
	}
?>
<?php
	include("adminhomeparent.php");
?>
<!DOCTYPE html>

  <!-- Modal Structure -->
	<br><br>
	<center>
		<div class="modal-width1 myfont black-text">
			<div class="card-panel blue-grey lighten-3">
			<h5><center><b> ADMIN LOGIN</b></h5>
			   <div class="container">
				<form method="POST" action="">
					<div class="row">
						<label for="enterUsername" class="black-text">Username</label>
						<input name="enterUsername" class="validate center" id="enterUsername" type="text" class="validate" minlength="5" maxlength="20">
					</div>
					<div class="row">
						<label for="enterPassword" class="black-text">Password</label>
						<input name="enterPassword" class="validate center" id="enterPassword" type="password" class="validate" minlength="5" maxlength="20">
					</div>
					<div class="row">
						<button class="btn black waves-effect waves-light" type="submit" name="submit">Submit
							
						</button>
					&nbsp;
						<button class="btn black waves-effect waves-light" type="reset" name="reset">Clear
						</button>
					</div>
				</form>
			</div>
		
		</div>
	</center>
	</div> 

</body>
</html>   



<?php
	if(isset($_POST['submit'])){
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

				$redirect = "dashboard.php";
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


<script type="text/javascript">
	$(document).ready(function() {
		Materialize.updateTextFields();
	});
</script>