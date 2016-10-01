<?php
	include("../connect_to_pms.php");
	include("adminparent.php");
	$numitems = mysql_num_rows(mysql_query("SELECT * FROM tbl_Items
													INNER JOIN tbl_Item
													ON tbl_Items.itemId = tbl_Item.itemId
													INNER JOIN tbl_branch
													ON tbl_Items.branchId = tbl_Branch.branchId
												"));
	$numbidders = mysql_num_rows(mysql_query("SELECT * FROM tbl_Bidders
	 												INNER JOIN tbl_Cities
	 												ON tbl_Bidders.bidder_city = tbl_Cities.city_ID
	                                                 INNER JOIN tbl_provinces
	                                                 ON tbl_cities.province_ID = tbl_provinces.province_ID
	                                                 INNER JOIN tbl_regions
	                                                 On tbl_provinces.region_ID = tbl_regions.region_ID"));
	$numlistings = mysql_num_rows(mysql_query("SELECT * FROM tbl_Auctions"));
	$numforfeited = mysql_num_rows(mysql_query("SELECT * FROM tbl_Auctions WHERE auction_status = 3 OR auction_status = 6"));
	$numdeliveries = mysql_num_rows(mysql_query("SELECT * FROM tbl_Checkouts WHERE claim_preference = 0"));
	$numbranch = mysql_num_rows(mysql_query("SELECT * FROM tbl_Checkouts WHERE claim_preference = 1"));




	$aucname = "";
	$latest = mysql_query("SELECT * FROM tbl_Auctions WHERE auction_status = 0");
	if(!mysql_num_rows($latest) == 0){
		$get_time = mysql_fetch_assoc(mysql_query("SELECT * FROM tbl_Auctions WHERE auction_status = 0  ORDER BY start_date, start_time"));
		$aucname = $get_time['auction_name'];
		$stopid = $get_time['auction_ID'];
		$stop = $get_time['start_time'];
		$stopex = $stop;
		$stopex = explode(':', $stop);
		$stophour = $stopex[0];
		$stopmin   = $stopex[1];
		$stopsec  = $stopex[2];
		$enddate = $get_time['start_date'];
		$enddateex = $enddate;
		$enddateex = explode('-', $enddateex);
		$endyear = $enddateex[0];
		$endmonth   = $enddateex[1];
		$endday  = $enddateex[2];	
	}
?>
  <script>
  $(document).ready(function(){
    $('#tableOutput').dataTable({
    "bLengthChange": false,
    "pageLength" : 5,
    "order": [[0,"DESC"]]
    });
})

  function DisplayTimeDate(ctr){
if (!document.all && !document.getElementById)
return
timeElement=document.getElementById? document.getElementById("curTime"): document.all.tick2
var CurrentDate=new Date()
var hours=CurrentDate.getHours()
var minutes=CurrentDate.getMinutes()
var seconds=CurrentDate.getSeconds()
var DayNight="PM"
if (hours<12) DayNight="AM";
if (hours>12) hours=hours-12;
if (hours==0) hours=12;
if (minutes<=9) minutes="0"+minutes;
if (seconds<=9) seconds="0"+seconds;

//added by yours truly
if(hours < 10) hours = '0'+hours;
var currentTime=hours+":"+minutes+":"+seconds+" "+DayNight;

timeElement.innerHTML=currentTime
dateElement=document.getElementById? document.getElementById("curDate"): document.all.tick2
var d = new Date(),
months = ['January','February','March','April','May','June','July','August','September','October','November','December'],
days = ['Sunday','Monday','Tuesday','Wednesday','Thurday','Friday','Saturday'];
var currentDate = days[d.getDay()]+' , '+months[d.getMonth()]+' '+d.getDate() + ' ' +d.getFullYear(); 
dateElement.innerHTML= currentDate;
setTimeout("DisplayTimeDate()",1000)
}

window.onload =  DisplayTimeDate

</script>

<script type="text/javascript" src="auctionstart.js"></script>
<script type="text/javascript" src="viewAuction.js"></script>
<script type="text/javascript" src="bidCount.js"></script>

<!-- Modal Structure -->
  <div id="viewModal" class="modal">
    <div class="modal-content">
    <h4>Auction Details</h4>
    <div class="black divider"></div><br>
      <div id="viewContent"></div>
    </div>
    <div class="modal-footer">
      <a href="#!" class=" modal-action modal-close waves-effect waves-green btn-flat">Close</a>
    </div>
  </div>
<div class="container">
	<div class="row">
		<h4 id = 'curTime' class="black-text">time</h4>
		<h5 id = 'curDate' class="black-text">date</h5>
	</div>
	<div class="row">
		<div class="col l4 s12">
			<div class="row">
				<div class="grey  col s12">
					<a class="black-text" href="que_listings.php"><h5>Listings <?php echo $numlistings?></h5></a>
				</div>
			</div>
			<div class="row">
				<div class="grey  col s12">
					<a class="black-text" href="que_auc_items.php"><h5>Items <?php echo $numitems?></h5></a>
				</div>
			</div>
			<div class="row">
				<div class="grey  col s12">
					<a class="black-text" href="que_bidders.php"><h5>Bidders <?php echo $numbidders?></h5></a>
				</div>
			</div>
			<div class="row">
				<div class="grey  col s12">
					<a class="black-text" href="transaction_forfeited.php"><h5>Forfeited Listings <?php echo $numforfeited?></h5></a>
				</div>
			</div>
			<div class="row">
				<div class="grey  col s12">
					<a class="black-text" href="transaction_deliver.php"><h5>Home Deliveries <?php echo $numdeliveries?></h5></a>
				</div>
			</div>
			<div class="row">
				<div class="grey  col s12">
					<a class="black-text" href="transaction_branch.php"><h5>Branch Deliveries <?php echo $numbranch?></h5></a>
				</div>
			</div>
		</div>
		<div class="grey col l7 push-l1 s12">
			<div class="row center">
				<a href="calendar.php" class="btn black white-text">Calendar</a>
			</div>
			<div class="row">
				<h5>Next Auction Starts in</h5>
				<div id ="jsalarm_ct" class="black white-text center" style="font-size:30px;">No Auctions Listed</div>
			</div>
			<div class="row">
				<div class="input-field col s12">
					<div><h5>
				<?php
					if($aucname != ""){
				?>
					Auction Name :
				<?php
					}
				?>
					</h5></div>
					<div id="AuctionName"><?php echo $aucname?></div>
				</div>
			</div>	
			<div class="right row">		
				<div class="col s12">
					<div id="View">
					<?php
						if($aucname != ""){
					?>
						<button class="btn black white-text" onclick="viewContent(<?php echo $stopid?>)">View</button>
					<?php	
						}
					?>	
					</div>
				</div>	
			</div>
		</div>
	</div>
	<script type="text/javascript">
	var before="AUCTION ENDS"
	var current=" NO AUCTIONS LISTED"
	var montharray=new Array("Jan","Feb","Mar","Apr","May","Jun","Jul","Aug","Sep","Oct","Nov","Dec")

	function countdown(yr,m,d,hr,min,sec,id){
	theid = id;	
	if (id == -1){
		// ends countdown
		return
	}
	theyear=yr;themonth=m;theday=d;thehr=hr;themin=min;thesec=sec
	var today=new Date()
	var todayy=today.getYear()
	if (todayy < 1000)
		todayy+=1900
		var todaym=today.getMonth()
		var todayd=today.getDate()
		var todayh=today.getHours()
		var todaymin=today.getMinutes()
		var todaysec=today.getSeconds()
		var todaystring=montharray[todaym]+" "+todayd+", "+todayy+" "+todayh+":"+todaymin+":"+todaysec
		futurestring=montharray[m-1]+" "+d+", "+yr+" "+hr+":"+min+":"+sec
		dd=Date.parse(futurestring)-Date.parse(todaystring)
		dday=Math.floor(dd/(60*60*1000*24)*1)
		dhour=Math.floor((dd%(60*60*1000*24))/(60*60*1000)*1)
		dmin=Math.floor(((dd%(60*60*1000*24))%(60*60*1000))/(60*1000)*1)
		dsec=Math.floor((((dd%(60*60*1000*24))%(60*60*1000))%(60*1000))/1000*1)
		if((dday==0&&dhour==0&&dmin==0&&dsec==0) || (dday<0&&dhour<0&&dmin<0&&dsec<0)) {
			document.getElementById("jsalarm_ct").innerHTML= "<h6><center>" + current +"</center></h6>"
			auctionStart(theid);
		}
	else
		document.getElementById("jsalarm_ct").innerHTML= "<center> " + dday+ " : "+dhour+" : "+dmin+" : "+dsec+"" + "<h6> DAYS &nbsp;&nbsp; HRS&nbsp;&nbsp; MINS &nbsp;&nbsp; SECS </h6> </center>"
		setTimeout("countdown(theyear,themonth,theday,thehr,themin,thesec,theid)",1000)
	}
		countdown(<?php echo $endyear?>,<?php echo $endmonth?>,<?php echo $endday?>,<?php echo $stophour?>,<?php echo $stopmin?>,<?php echo $stopsec?>,<?php echo $stopid?>)
	</script>
	<script>
