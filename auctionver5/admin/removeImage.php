<?php
	include("../connect_to_pms.php");
	$id = $_GET['imgid'];
	$sql = "UPDATE tbl_Images SET deleted =  1 WHERE image_ID = $id ";
	$res = mysql_query($sql) or die("Error in Query:" . mysql_error());
	echo "<script>
			alert('Image has been removed');
			window.location.href = 'itemimage.php';
		</script>
	";
?>