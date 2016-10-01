<?php
	include('../connect_to_pms.php');
	include('adminparent.php');
    include "../schedulechecker.php";
?>

<div class="black" style="width:20%; height:90%; ">



<a class="btn blue-grey darken-3 white-text" target="frame"  style="width:100%;height:20%;" href="transac_listing.php"><br>Auction Listings</a><br><br>
<a class="btn blue-grey darken-3 white-text" target="frame"  style="width:100%;height:20%;"  href="transaction_branch.php"><br>Branch Deliveries</a><br><br>
<a class="btn blue-grey darken-3 white-text" target="frame"  style="width:100%;height:20%;" href="transaction_deliver.php"><br>Address Deliveries</a><br><br>


</div>

<div class='finder-window white' style = ' position: absolute; left: 24%; top: 15%; height: 80%; width:73%;overflow-y:hidden;overflow-x:hidden;background:none'>
<div class='sidebar white' style = ' top:0%;height: 200%; width: 100%;border-radius: 0px;'>
</div>
</div>

<iframe name="frame"  src="transac_listing.php" style=" position: absolute; left: 24%; top: 15%; height: 80%; width:73%;">
	</iframe>
</body>


