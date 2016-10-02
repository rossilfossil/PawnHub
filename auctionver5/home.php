<?php
    include('connect_to_pms.php');

    $_SESSION['redirect']="home.php";
	if(!isset($_SESSION['userName'])){
        include('homepageparent.php');
    }
    else{ 
        $user = $_SESSION['userName'];
        include('accessgrantedparent.php');
    }
    include "schedulechecker.php";
    include "enddatechecker.php";
    include "admin/deadline_checker.php";
?>
<script type="text/javascript" src="getCategory.js"></script>
<script type="text/javascript" src="admin/getCity.js"></script>
<script type="text/javascript" src="browse.js"></script>
<ul id="slide-out" class="side-nav">
 	<center><h4>BROWSE</h4></center>
	<select class="browser-default" name='mcat' id='mcat' onchange="setCategory(this.value);document.getElementById('1111').value=this.value;document.getElementById('2222').value='';document.getElementById('3333').value=''" REQUIRED>
		<option value = "" selected >Select Main Category:</option>
		<?php
			$get = mysql_query("SELECT * FROM tbl_Main_Categories WHERE deleted = 0");
			if(!mysql_num_rows($get)==0){
				while($get_row = mysql_fetch_assoc($get)){
				?><option value = "<?php echo $get_row['main_category_ID']; ?>"><?php echo $get_row['main_category_name']; ?></option>
			<?php
				}
			}
		?>
	</select>
	<select class="browser-default" name='scate' id='scate' onchange="setSubCategory(this.value);document.getElementById('2222').value=this.value">
			<option value="" selected>Select Category</option>	
	</select>

	<select class="browser-default" name='subcat' id='subcat' onchange="document.getElementById('3333').value=this.value">
			<option value="" selected>Select Sub Category</option>	
	</select>
	<center>
		
	<button type="" name="browse" class="btn black white-text center" onclick="browse()">Search</button>
	</center>
	<li><input type="hidden" id="1111"></li>
	<li><input type="hidden" id="2222"></li>
	<li><input type="hidden" id="3333"></li>
</ul>
<script type="text/javascript">
	function browse(){
		var cat1 = document.getElementById('1111').value;
		var cat2 = document.getElementById('2222').value;
		var cat3 = document.getElementById('3333').value;
		browseItem(cat1,cat2,cat3," ");
	}
</script>
<div class="row">
<div class="input-field col l2 m5 s12">
	<a href="#" data-activates="slide-out" class="btn btn-flat white-text button-collapse "><i class="material-icons left">menu</i>Browse</a>
</div>
<div class="input-field col l3 m5 s12 right">	
	<i class="material-icons prefix white-text">search</i>
	<input id="icon_telephone" type="text" class="validate white-text" onkeyup="browseItem(0,0,0,this.value)">
	<label for="icon_telephone white-text">Search</label>
</div>
</div>
<div class="container">
	<div id="container" class="row">		
		<script type="text/javascript">
			browseItem(0,0,0," ");
		</script>
	</div>
</div>
<script type="text/javascript">
	  // Initialize collapse button
  $(".button-collapse").sideNav();
  // Initialize collapsible (uncomment the line below if you use the dropdown variation)
  //$('.collapsible').collapsible();
</script>
<?php
	if(isset($_POST['bid'])){
		$_SESSION['auction_id'] = $_POST['auctionid'];
		echo "
			<script>
				window.location.href = 'listing.php';
			</script>";
	}
?>