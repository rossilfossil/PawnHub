<?php
	// include "connect_to_pms.php";
	$datenow = date("Y-m-d");
	$timenow = date("G:i:s");
	$get=mysql_query("SELECT * FROM tbl_Auctions WHERE auction_status = 0");
	if(!mysql_num_rows($get)==0){
		while($get_row=mysql_fetch_assoc($get)){
			$id = $get_row['auction_ID'];
			$datecheck = $get_row['start_date'];
			$timecheck = $get_row['start_time'];
			if(strtotime($datecheck) <= strtotime(date("Y-m-d"))){
				echo date("G:i:s").">=".$timecheck;
				echo strtotime(date("G:i:s")).">=".strtotime($timecheck);
				var_dump(strtotime($timecheck) <= strtotime(date("G:i:s")));
				if(strtotime($timecheck) <= strtotime(date("G:i:s"))){
					$sql = "UPDATE tbl_Auctions SET auction_status = 1 WHERE auction_ID = $id";
					$res = mysql_query($sql) or die("Error in Query: ".mysql_error());
				}	
				//else{
				//	return;
				//}
			}
			//else{
			//	return;
			//}
		}	
	}
	//else{
	//	return;
	//}