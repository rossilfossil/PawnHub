<?php
	include('../connect_to_pms.php');
	include('adminparent.php');
    include "../schedulechecker.php";
?>

<div class="black" style="width:20%; height:90%; ">



<a class="btn blue-grey darken-3 white-text" target="frame"  style="width:100%;height:20%;" href="que_auc_items.php"><br>Auction Items</a><br><br>



</div>

<div class='finder-window white' style = ' position: absolute; left: 24%; top: 15%; height: 80%; width:73%;overflow-y:hidden;overflow-x:hidden;background:none'>
<div class='sidebar white' style = ' top:0%;height: 200%; width: 100%;border-radius: 0px;'>
</div>
</div>

<iframe name="frame"  src="que_auc_items.php" style=" position: absolute; left: 24%; top: 15%; height: 80%; width:73%;">
	</iframe>
</body>
