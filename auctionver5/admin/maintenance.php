<?php
	include('../connect_to_pms.php');
	include('adminparent.php');
    include "../schedulechecker.php";
?>

<!--	
<div class="black" style="width:20%; height:90%; ">



<a class="btn blue-grey darken-3 white-text" target="frame"  style="width:100%;height:20%;" href="maintenance_maincategory.php"><br>Main Category</a><br><br>
<a class="btn blue-grey darken-3 white-text" target="frame"  style="width:100%;height:20%;" href="maintenance_category.php"><br>Category</a><br><br>
<a class="btn blue-grey darken-3 white-text" target="frame"  style="width:100%;height:20%;" href="maintenance_subcategory.php"><br>Subcategory</a><br><br>
<a class="btn blue-grey darken-3 white-text" target="frame"  style="width:100%;height:20%;" href="maintenance_increment.php"><br>Increment</a><br>


</div>

<div class='finder-window white' style = ' position: absolute; left: 24%; top: 15%; height: 80%; width:73%;overflow-y:hidden;overflow-x:hidden;background:none'>
<div class='sidebar white hide-on-med' style = ' top:0%;height: 200%; width: 100%;border-radius: 0px;'>
</div>
</div>

<iframe name="frame"  src="maintenance_maincategory.php" style=" position: absolute; left: 24%; top: 15%; height: 80%; width:73%;">
	</iframe>
</body>