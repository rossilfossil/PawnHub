<!DOCTYPE html>
<html>
<head>
	<title>PMS - Auction System</title>
	<link href="https://fonts.googleapis.com/css?family=Lato:100" rel="stylesheet" type="text/css">
  	<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
	<link href="../../icon/material-design-icons-2.2.0/iconfont/material-icons.css" rel="stylesheet">
	
	
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
		<nav class="navbar-fixed">
			<div class="nav-wrapper black ">
				<img src = 'homepage/logo.png' class = 'brand-logo' height="60" width="60"> </img>
				<ul id="nav-mobile" class="right hide-on-med-and-down">
				<a href='../AuctionVer5' > <label class="sys"> PAWNSHOP AUCTION SYSTEM</label> </a>
					<li><a class="modal-trigger" href="#modal1" data-target="modal1">Login</a></li>
					<li><a href="registration.php">Register</a></li>
				</ul>
			</div>
		</nav>
	</header>
  <!-- Modal Structure -->
	<div id="modal1" class="modal modal-width1 ">
		<div class="modal-content myfont ">
			<h5><center><b>LOGIN</b></h5></center>			
			   <div class="container " >
				<form method="POST" action="login.php">
					<div class="row black-">
						<label for="enterUsername">Username</label>
						<input name="enterUsername" id="enterUsername" type="text" class="center validate" minlength="8" maxlength="20">
					</div>
					<div class="row">
						<label for="enterPassword">Password</label>
						<input name="enterPassword" id="enterPassword" type="password" class="center validate" minlength="8" maxlength="20">
					</div>
					<div class="row">
						<div class="col l6 m6 s12">	
							<button class="btn black waves-effect waves-light" type="submit" name="submit">Submit
								<i class="material-icons right">send</i>
							</button>
						</div>	
						<div class="col l6 m6 s12">
							<button class="btn black waves-effect waves-light" type="reset" name="reset">Clear
								<i class="material-icons right">send</i>
							</button>
						</div>	
					</div>
				</form>
			</div>
		</div>
	</div>    




<script type="text/javascript">

  	$('.modal-trigger').leanModal({
      dismissible: true, // Modal can be dismissed by clicking outside of the modal
      opacity: .5, // Opacity of modal background
      in_duration: 300, // Transition in duration
      out_duration: 200, // Transition out duration
    })
    
	$(document).ready(function() {
		Materialize.updateTextFields();
	});

	
	$(document).ready(function(){
		$('.slider').slider({full_width: true});
	});


	
</script>