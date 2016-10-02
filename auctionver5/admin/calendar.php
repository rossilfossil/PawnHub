<?php
	include('../connect_to_pms.php');
	if(!isset($_SESSION['branchId'])){
		include("adminhomeparent.php");
        echo "<br><br><br><br><br><br><br><center><h1>You have no access to this page</h1></center>";
		return;		
	}
	include('adminparent.php');
	$title =  array();
	$start = array();
	$end = array();
	$dafaultdate = date("Y-m-d");
	$get = mysql_query("SELECT * FROM tbl_Auctions WHERE auction_status = 0 OR auction_status = 1");
	$ctr = 0;
	if(!mysql_num_rows($get)==0){
		while($get_row = mysql_fetch_assoc($get)){
			array_push($title,$get_row['auction_name']);
			array_push($start,$get_row['start_date']."T".$get_row['start_time']);
			array_push($end,$get_row['end_date']."T".$get_row['end_time']);
			$ctr++;
		}
	}	

									
?>
<link href='../../fullcalendar-3.0.0/fullcalendar.css' rel='stylesheet' />
<link href='../../fullcalendar-3.0.0/fullcalendar.print.css' rel='stylesheet' media='print' />
<script src='../../fullcalendar-3.0.0/lib/moment.min.js'></script>
<!-- <script src='../../fullcalendar-3.0.0/lib/jquery.min.js'></script> -->
<script src='../../fullcalendar-3.0.0/fullcalendar.min.js'></script>
<script>

	$(document).ready(function() {
		
			$('#calendar').fullCalendar({
			eventStartEditable: false,
			header: {
				left: 'prev,next today',
				center: 'title',
				right: 'month,basicWeek,basicDay',
			},
			defaultDate: '<?php date("Y-m-d")?>',
			navLinks: true, // can click day/week names to navigate views
			editable: true,
			eventLimit: true, // allow "more" link when too many events
			events: [
				<?php 
				for ($i=0; $i < $ctr; $i++) { 
						echo "{
							title:'".$title[$i]."',
							start:'".$start[$i]."',
							end:'".$end[$i]."'
						},
						";
					}
				?>
				
			]
		});
		
	});

 $('.dropdown-button').dropdown({
      inDuration: 300,
      outDuration: 225,
      constrain_width: false, // Does not change width of dropdown to that of the activator
      hover: true, // Activate on hover
      gutter: 0, // Spacing from edge
      belowOrigin: true, // Displays dropdown below the button
      alignment: 'left' // Displays dropdown with edge aligned to the left of button
    }
  );

</script>
<style>
	#calendar {
		max-width: 900px;
		margin: 0 auto;
	}

</style>
</head>
<body>

<div class="white" id='calendar'></div>

