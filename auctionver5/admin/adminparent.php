<!DOCTYPE html>
<html>
<head>
	<title>PMS - Auction System</title>
	<link href="https://fonts.googleapis.com/css?family=Lato:100" rel="stylesheet" type="text/css">
  	<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
	<link href="../../icon/material-design-icons-2.2.0/iconfont/material-icons.css" rel="stylesheet">
	<link rel="stylesheet" type="text/css" href="../css/style.css"> 
	<link rel="stylesheet" type="text/css" href="../css/materialize.css">	
	<link rel="stylesheet" type="text/css" href="../css/materialize.min.css">	
	<script type="text/javascript" src = "../js/jquery-2.1.1.min.js"></script>
	<script type="text/javascript" src = "../js/jquery.js"></script>
	<script type="text/javascript" src = "../js/materialize.js"></script>
	<script type="text/javascript" src = "../js/materialize.min.js"></script>

	<link rel="stylesheet" type="text/css" href="../css/mycss.css">


<script type="text/javascript" src="DataTables/media/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="DataTables/media/js/jquery.dataTables.js"></script>
<link rel="stylesheet" type="text/css" href="DataTables/media/css/jquery.dataTables.min.css"/>
<link rel="stylesheet" type="text/css" href="DataTables/media/css/jquery.dataTables.css"/>
</head>
<script type="text/javascript" src="validation.js"></script>
<body class="myfont" style="background: url('../homepage/bg.jpg') no-repeat fixed;background-size:cover;">
	<header class="navbar-fixed">
		<nav>
			<div class="nav-wrapper black ">
				<img src = '../homepage/logo.png' class = 'brand-logo' height="60" width="60"> </img>
				<!-- <a href="#" data-activates="mobile-demo" class="button-collapse"><i class="material-icons">menu</i>MENUHAHAAHAH</a> -->
				<ul id="nav-mobile" class="right hide-on-med-and-down">
					<a href='dashboard.php'><label class="sys"> PAWNSHOP AUCTION SYSTEM</label> </a>
					<li><a href="dashboard.php">Dashboard</a></li>
					<li><a href="#!" class="dropdown-button" data-beloworigin="true" data-activates="dropdown_maintenance">Maintenance</a></li>
					<li><a href="#!" class="dropdown-button" data-beloworigin="true" data-activates="dropdown_transaction">Transaction</a></li>
					<li><a href="#!" class="dropdown-button" data-beloworigin="true" data-activates="dropdown_queries">Queries</a></li>
					<li><a href="#!" class="dropdown-button" data-beloworigin="true" data-activates="dropdown_utilities">Utilities</a></li>
					<li><a href="#!" class="dropdown-button" data-beloworigin="true" data-activates="dropdown_reports">Reports</a></li>
					<li><a href="../admin/logout.php">Logout</a></li>
				</ul>
				<ul id="dropdown_maintenance" class="dropdown-content">
  					<li><a class="black-text" href="maintenance_maincategory.php">Main Category</a></li>
					<li><a class="black-text" href="maintenance_category.php">Category</a></li>
					<li><a class="black-text" href="maintenance_subcategory.php">Sub Category</a></li>
					<li class="divider"></li>
					<li><a class="black-text" href="maintenance_increment.php">Bid Increment</a></li>
				</ul>
				<ul id="dropdown_transaction" class="dropdown-content">
					<li><a class="black-text" href="itemimage.php">Item Image</a></li>
					<li class="divider"></li>
  					<li><a class="black-text" href="auctionlistings.php">Auction Listings</a></li>
					<!-- <li><a class="black-text" href="#!">Extend Listing</a></li> -->
					<li class="divider"></li>
					<li><a class="black-text" href="transaction_branch.php">Branch Deliveries</a></li>
					<li><a class="black-text" href="transaction_deliver.php">Home Deliveries</a></li>
					<li class="divider"></li>
					<li><a class="black-text" href="transaction_forfeited.php">Forfeited Auctions</a></li>
				</ul>
				<ul id="dropdown_queries" class="dropdown-content">
					<li><a class="black-text" href="que_bidders.php">Bidder Summaries</a></li>
					<li><a class="black-text" href="que_auc_items.php">Auction Items</a></li>
					<li><a class="black-text" href="que_listings.php">Auction Listings</a></li>
				</ul>
				<ul id="dropdown_utilities" class="dropdown-content">
					<li><a class="black-text" href="uti_delivery_fee.php">Regional Delivery Fees</a></li>
					<li><a class="black-text" href="uti_period.php">Transaction Periods</a></li>
				</ul>
				<ul id="dropdown_reports" class="dropdown-content">
					<li><a class="black-text" href="reports_allbids.php">Bids</a></li>
					<li><a class="black-text" href="reports_homedeliveries.php">Deliveries</a></li>
				</ul>
			</div>		
		</nav>
	</header>       
<script type="text/javascript">

	$(document).ready(function() {
		Materialize.updateTextFields();
	});
    $('.collapsible').collapsible({
      accordion : false // A setting that changes the collapsible behavior to expandable instead of the default accordion style
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