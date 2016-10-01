<?php
	include('../connect_to_pms.php');
	include('adminparent.php');
	if(isset($_SESSION['branchId'])){	
		$branch = $_SESSION['branchId'];
	}
	else{
		echo "<h3><center>Please Login!</center></h3>";
		return;
	}
	//
//cdn.datatables.net/buttons/1.2.2/js/dataTables.buttons.min.js
//cdn.datatables.net/buttons/1.2.2/js/buttons.print.min.js
?>
<!-- <script type="text/javascript" src="https://cdn.datatables.net/buttons/1.2.2/js/dataTables.buttons.min.js"></script> -->
<!-- <script type="text/javascript" src="https://cdn.datatables.net/buttons/1.2.2/js/buttons.print.min.js"></script> -->
<script type="text/javascript" src="Datatables/extensions/buttons/js/dataTables.buttons.js"></script>
<script type="text/javascript" src="Datatables/extensions/buttons/js/buttons.print.js"></script>
<link rel="stylesheet" type="text/css" href="Datatables/extensions/Buttons/css/buttons.dataTables.min.css">
<!-- <script type="text/javascript" src="Datatables/extensions/Buttons/css/buttons.dataTables.css"></script> -->
<!-- <script type="text/javascript" src="Datatables/media/css/jquery.dataTables.css"></script> -->




<div class="container">
	<div class="row">
		<div class="col s12">
			<h3><center>Bidder Summaries</center></h3>
			<div class="black divider"></div>
			<div class="card">
				<table id="tableOutput" class="highlight centered">
					<thead>
						<th>ID</th>
						<th>Bidder Name</th>
						<th>Region</th>
						<th>Province</th>
						<th>City</th>
						<th>Address</th>
						<!-- <th>Birthdate</th> -->
						<th>Contact Number</th>
						<th>Email</th>
					</thead>
					<tbody>
						<?php
							$get = mysql_query("SELECT * FROM tbl_Bidders
												INNER JOIN tbl_Cities
												ON tbl_Bidders.bidder_city = tbl_Cities.city_ID
                                                INNER JOIN tbl_provinces
                                                ON tbl_cities.province_ID = tbl_provinces.province_ID
                                                INNER JOIN tbl_regions
                                                On tbl_provinces.region_ID = tbl_regions.region_ID");
							if(!mysql_num_rows($get)==0){
								while($get_row = mysql_fetch_assoc($get)){							
						?>
									<tr>
										<td><?php echo $get_row['bidder_ID']?></td>
										<td><?php echo $get_row['bidder_lastname'].",".$get_row['bidder_firstname']." ".$get_row['bidder_middlename']?></td>
										<td><?php echo $get_row['region_name']?></td>
										<td><?php echo $get_row['province_name']?></td>
										<td><?php echo $get_row['city_name']?></td>
										<td><?php echo $get_row['bidder_barangay']?></td>
										<!-- <td>aint got none</td> -->
										<td><?php echo $get_row['bidder_contact']?></td>
										<td><?php echo $get_row['bidder_email']?></td>
									</tr>
						<?php
								} // while
							} // if	
						?>
					</tbody>
				</table>
			</div>
		</div>
	</div>
	<script type="text/javascript">
		$(document).ready(function(){
		    $('#tableOutput').DataTable({
		    "bLengthChange": false,
    		"pageLength" : 5,
    		dom: 'Bfrtip',
        		buttons: [
            		'print'
        		]
		    });
		})
	</script>