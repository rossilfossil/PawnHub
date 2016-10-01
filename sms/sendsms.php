<?php
	// include ('file_constants.php');

	// $con = mysql_connect($host,$user) or die(mysql_error());
	// mysql_select_db($db) or die("Cannot Select db");	
?>
<!DOCTYPE html>
<html>
<head>
	<title>SEND SMS</title>
</head>
<body>
	<form action = "pantext.php" method = "post">
		SEND TO	: <br>
	<!--	
		<input type = "text" size = "2" name = "numbertext">
		- 09496990737
		<input type = "text" name = "number">
	-->	

		<input type = "number" name = "numnum" placeholder = "639xxxxxxxxx">
		<br><br>
		SENDER : <br>

		<br><br>
		MESSAGE : <br>
		<textarea name = "message"></textarea> 
		<br>
		TEXT CODE : <br>
		<input type = "number" name = "textcount" value = "3001123">
		<br>
		<input type = "submit" name = "submit">		
	</form>
</body>
</html>