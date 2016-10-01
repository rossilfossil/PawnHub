<?php

	include('../connect_to_pms.php');
	$typeId = $_POST['amount'];
	$resultTxt = "";
	$sql = "SELECT * FROM tbl_Subcategories WHERE category_ID = $typeId AND deleted = 0";
	$res = mysql_query($sql) or die("Error in Query:" . mysql_error());
		
	$ctr = 1;	
	if(!mysql_num_rows($res)==0){	
		while($row = mysql_fetch_assoc($res)){	
			$brandId = $row['subcategory_ID'];
			$brandName = $row['subcategory_name'];
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