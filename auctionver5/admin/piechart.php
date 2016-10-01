<?php
echo"wat";
?>
<div id="chartcontainer"></div>
<script type="text/javascript" src="jscharts.js"></script>
<script type="text/javascript">
	var myData = new Array(['Successful',11], ['Unsuccessful', 1], ['Forfeited', 3]);
	var colors = ['#898A89', '#767776', '#676767'];
	var myChart = new JSChart('chartcontainer', 'bar');
	myChart.setDataArray(myData);
	myChart.colorizePie(colors);
	myChart.setTitleColor('#FFFFFF');
	myChart.setPieUnitsColor('#000000');
	myChart.setPieValuesColor('#000000');
	myChart.draw();
</script>