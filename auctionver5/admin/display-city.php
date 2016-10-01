<?php

	include('../connect_to_pms.php');
	$typeId = $_POST['amount'];
	$resultTxt = "";
	$sql = "SELECT * FROM tbl_Cities WHERE province_ID = $typeId";
	$res = mysql_query($sql) or die("Error in Query:" . mysql_error());
		
	$ctr = 1;	
	if(!mysql_num_rows($res)==0){	
		while($row = mysql_fetch_assoc($res)){	
			$brandId = $row['city_ID'];
			$brandName = $row['city_name'];
			if($ctr == 1){
				$resultTxt = $brandId . "+" . $brandName; 
			}	
			else{
				$resultTxt = $resultTxt . "/" .$brandId . "+" . $brandName; 
			}
			$ctr++;
		}
	}
	echo $resultTxt;