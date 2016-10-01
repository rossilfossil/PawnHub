<!DOCTYPE html>
<html>
<head>
	<title>PMS -Auction System</title>
	<link href="https://fonts.googleapis.com/css?family=Lato:100" rel="stylesheet" type="text/css">
	<link href="../../icon/material-design-icons-2.2.0/iconfont/material-icons.css" rel="stylesheet">
  	<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
	<link rel="stylesheet" type="text/css" href="css/style.css"> 
	<link rel="stylesheet" type="text/css" href="css/materialize.css">	
	<link rel="stylesheet" type="text/css" href="css/materialize.min.css">	
	<script type="text/javascript" src = "js/jquery-2.1.1.min.js"></script>
	<script type="text/javascript" src = "js/jquery.js"></script>
	<script type="text/javascript" src = "js/materialize.js"></script>
	<script type="text/javascript" src = "js/materialize.min.js"></script>
	<meta name="csrf-token" content="{{ csrf_token() }}" />		
	<link rel="stylesheet" type="text/css" href="css/mycss.css">
</head>
<body class="myfont" style="background: url('../../capstone/image/BG.jpg') no-repeat fixed;background-size:cover;">

	<header class="navbar-fixed">
		<nav>
			<div class="nav-wrapper black">
				<img src = 'homepage/logo.png' class = 'brand-logo' height="60" width="60"> </img>
				<a href="#" data-activates="side-nav" class="right button-collapse"><i class="material-icons">menu</i></a>
				<ul id="nav-mobile" class="right hide-on-med-and-down">
					<a href='../AuctionVer5' > <label class="sys"> PAWNSHOP AUCTION SYSTEM</label> </a>
					<li><a href="../AuctionVer5"><i class="material-icons left">home</i>Home</a></li>
					<!-- <li><a href="bids.php"><i class="material-icons left">account_circle</i>My Bids</a></li> -->
					<li><a href="#!" class="dropdown-button" data-beloworigin="true" data-activates="dropdown_options"><i class="material-icons left">account_circle</i>My Account</a></li>
					<li><a href="cart.php"><i class="material-icons left">shopping_cart</i>Cart</a></li>
					<li><a href="logout.php">Logout</a></li>
				</ul>
				<ul class="right side-nav" id="side-nav">
					<li><a href="sass.html">Sass</a></li>
					<li><a href="badges.html">Components</a></li>
					<li><a href="collapsible.html">Javascript</a></li>
					<li><a href="mobile.html">Mobile</a></li>
				</ul>
				<ul id="dropdown_options" class="dropdown-content">
					<li><a class="black-text" href="account.php">Customer Information</a></li>
					<li><a class="black-text" href="bids.php">My Bids</a></li>
					<li><a class="black-text" href="checkout_list.php">My Checkouts</a></li>
				</ul>
			</div>		
		</nav>
	</header>    
<script type="text/javascript">
	$(document).ready(function() {
		Materialize.updateTextFields();
	});

  	$('.modal-trigger').leanModal({
      dismissible: true, // Modal can be dismissed by clicking outside of the modal
      opacity: .5, // Opacity of modal background
      in_duration: 300, // Transition in duration
      out_duration: 200, // Transition out duration
    }
  );


  	$(document).ready(function(){
  		$('.button-collapse').sideNav();	
	});

	$(document).ready(function(){
		$('.slider').slider({full_width: true});
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