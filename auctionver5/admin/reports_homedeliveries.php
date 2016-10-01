<?php
	include('../connect_to_pms.php');
	include('adminparent.php');
	$date = date("Y-m-d");
	$d = date_parse_from_format("Y-m-d", $date);
	$year = $d["year"];
	$month = $d["month"];
	$monthnames = array();
	$monthend = array();
	$monthnames = ['January','February','March','April','May','June','July','August','September','October','November','December'];
	$monthend = [31,28,31,30,31,30,31,31,30,31,30,31];

	if(!isset($_POST['reportType'])){
		$reportType = 2;
	}
	else{
		$reportType = $_POST['reportType'];
	}

	if(!isset($_POST['pangcheck']) OR $reportType == 2){
		$title = "Deliveries for this month, ".$monthnames[$month-1]." ".$year;
		$start = $year."-".$month."-01";
		$end = $year."-".$month."-31";
		$get2 = mysql_query("SELECT * FROM tbl_delivery_receipts 
			WHERE payment_date >= '$start' AND payment_date <= '$end'
			");
			// if(!mysql_num_rows($get2) ==0){
				$categories = array(); // categories
				$values = array(); // values

				for ($i=0; $i < $monthend[$month-1]; $i++) { 
					$y = 0;
					$m = $i+1;
					$start = $year."-".$month."-".$m;
					$get3 = mysql_query("SELECT * FROM tbl_delivery_receipts 
						WHERE payment_date = '$start'
					");
					$days = $monthnames[$month-1]." ".($i+1);
					array_push($categories,$days);
					while($get_row = mysql_fetch_assoc($get3)){
						$y = $y + 1;
					}
					array_push($values,$y);
				}
			// }	
	}
	else{
			if($reportType==0) { // monthly
			$title = "Monthly Deliveries for ".$year;
			$start = $year."-01-01";
			$end = $year."-12-31";
			$get2 = mysql_query("SELECT * FROM tbl_delivery_receipts 
				WHERE payment_date >= '$start' AND payment_date <= '$end'
			");
			// if(!mysql_num_rows($get2) ==0){
				$categories = array(); // categories
				$values = array(); // values

				for ($i=0; $i < 12; $i++) { 
					$y = 0;
					$m = $i+1;
					$start = $year."-".$m."-01";
					$end = $year."-".$m."-31";
					$get3 = mysql_query("SELECT * FROM tbl_delivery_receipts 
						WHERE payment_date >= '$start' AND payment_date <= '$end'
					");
					array_push($categories,$monthnames[$i]);
					while($get_row = mysql_fetch_assoc($get3)){
						$y = $y + 1;
					}
					array_push($values, $y);
				}
			// }	
		}
		else if($reportType==1) { // annually
			$title = "Annual Deliveries";
			$start = $year."-01-01";
			$end = $year."-12-31";
			$get2 = mysql_query("SELECT * FROM tbl_delivery_receipts 
				WHERE payment_date >= '$start' AND payment_date <= '$end'
			");
			// if(!mysql_num_rows($get2) ==0){
				$categories = array(); // categories
				$values = array(); // values
				$year = $year - 4;
				for ($i=0; $i < 10; $i++) { 
					$y = 0;
					$m = $i+1;
					$start = $year."-01-01";
					$end = $year."-12-31";
					$get3 = mysql_query("SELECT * FROM tbl_delivery_receipts 
						WHERE payment_date >= '$start' AND payment_date <= '$end'
					");
					array_push($categories,$year);
					while($get_row = mysql_fetch_assoc($get3)){
						$y = $y + 1;
					}
					array_push($values, $y);
					$year = $year + 1;
				}
			// }	
		}
		
	}
?>    
	<script src="../../../highcharts/js/highstock.js"></script>
	<script src="../../../highcharts/js/modules/exporting.js"></script>
	<div class="row">
	<h3><center>Deliveries Report</center></h3>
	<div class="container">
		<div class="black divider"></div><br>
		<div class="col l4 s12 m12">
			<div class="row">
				<form action="" method="POST">
					<div class="col s12">
    						<input class="black" type="radio" id="reportType3" name="reportType" value="2" required>
    						<label class="black-text" for="reportType3">Daily</label><BR><BR>
    						<input class="black" type="radio" id="reportType2" name="reportType" value="0" required>
    						<label class="black-text" for="reportType2">Monthly</label><BR><BR>
    						<input class="black" type="radio" id="reportType1" name="reportType" value="1" required>
    						<label class="black-text" for="reportType1">Annually</label><BR><BR>
					</div>
					<div class="col s12">
						
					<button type="submit" name="pangcheck" class="btn black white-text">Generate Report</button>
					</div>
				</form>
			</div>	
		</div>
		<div class="col l8 s12 m12">
		<center>
			
			<div id="graph"></div>
		</center>
		</div>
	</div>
<script>
$(function() {
    $('#graph').highcharts({
        chart: {
            type: 'column'
        },
        title: {
            text: '<?php echo $title?>'
        },
        xAxis: {
            categories: [  
            	<?php
            		foreach ($categories as $value) {
            			echo "'".$value."',";
           		 	}
				?>
				
            ],
            crosshair: true
        },
        yAxis: {
            min: 0,
            title: {
                text: 'Number of Bids'
            }
        },
        tooltip: {
            headerFormat: '<span style="font-size:10px">{point.key}</span><table>',
            pointFormat: '<tr><td style="color:{series.color};padding:0"></td>' +
                '<td style="padding:0"><b> {point.y:.1f} Deliveries</b></td></tr>',
            footerFormat: '</table>',
            shared: true,
            useHTML: true
        },
        plotOptions: {
            column: {
                pointPadding: 0.2,
                borderWidth: 0
            }
        },
        series: [{
            data: [
            <?php
            	foreach ($values as $key => $value) {
            		echo $value.",";
            	}
            ?>
            ]
        }]
    });
});
</script>