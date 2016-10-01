<?php
	include("../connect_to_pms.php");
	include("adminparent.php");
	$numbids = mysql_num_rows(mysql_query("SELECT * FROM tbl_Bids"));

?>
<script type="text/javascript">
	  $(document).ready(function(){
    $('#tableOutput').dataTable({
    "bLengthChange": false,
    "pageLength" : 5,
    "order": [[0,"DESC"]]
    });
})
</script>
<div class="container">
<center><h4>LIVE FEED</h4></center>
<div class="black divider"></div>
<div class="row">
	
		<div class="white col s12">
				<table id="tableOutput" class="highlight centered">
					<thead>
						<th>ID</th>
						<th>Bidder</th>
						<th>Bid</th>
						<th>Listing</th>
					</thead>
					<tbody>
						<div id="tableContent">
						<?php
							$sql = mysql_query("SELECT * FROM tbl_Bids
												INNER JOIN tbl_Auctions
												ON tbl_Auctions.auction_ID = tbl_Bids.auction_ID
												INNER JOIN tbl_Bidders
												ON tbl_Bidders.bidder_ID = tbl_Bids.bidder_ID
												ORDER BY bid_ID DESC");
							if(!mysql_num_rows($sql) == 0){
								while($get_row = mysql_fetch_assoc($sql)){
									?>
										<tr>
											<td><?php echo $get_row['bid_ID']; ?></td>
											<td><?php echo $get_row['bidder_firstname']; ?></td>
											<td><?php echo $get_row['bid_amount']; ?></td>
											<td><?php echo $get_row['auction_name']; ?></td>
										</tr>
									<?php
								}
							}
						?>	
						</div>
					</tbody>
				</table>
			</div>
<script type="text/javascript" src="bidCount.js"></script>
<script>
function myTimer(bids) {
	ctr = bids
	bidCount(ctr)
    // alert(ctr);
    	//alert('hihi');
        // window.open('hehez.html','_blank')
        // window.open('hehez.html',"","width=1000,height=1000")
		//clearTimeout(myVar);
	setInterval(myTimer(ctr), 10000);
}
myTimer(<?php echo $numbids?>)
</script>