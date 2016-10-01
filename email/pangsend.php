<?php

include "samplemail.php";

?>
<!DOCTYPE html>
<html>
<head>
	<title></title>
</head>
<body>
<form action="" method="POST">
		<input type="text" name="email">
		<input type="submit" name="submit" value="submit">
</form>

</body>
</html>

<?php

		if(isset($_POST['submit'])){

			$receiver = $_POST['email'];
			sendEmail($receiver);
		}
		// put 2 sec timer here
		// CHIKKA API SHORTCODE 29290 06214
		// CLIENT ID 6d0a6634c848f34afe600d42422ffc412823da15983149d9e5a768470ea3867c
		// SECRET KEY 3527adda68064dce2daa352a7d05ab219a7eea4336da8f355eb6c2b28309d6a1
?>

