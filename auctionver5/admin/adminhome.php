<!DOCTYPE html>
<html>
<head>
	<title>PMS - Auction System</title>
	<link href="https://fonts.googleapis.com/css?family=Lato:100" rel="stylesheet" type="text/css">
	<link href="material-design-icons-2.2.0/iconfont/material-icons.css" rel="stylesheet">
	<link rel="stylesheet" type="text/css" href="../css/style.css"> 
	<link rel="stylesheet" type="text/css" href="../css/materialize.css">	
	<link rel="stylesheet" type="text/css" href="../css/materialize.min.css">	
	<script type="text/javascript" src = "../js/jquery-2.1.1.min.js"></script>
	<script type="text/javascript" src = "../js/jquery.js"></script>
	<script type="text/javascript" src = "../js/materialize.js"></script>
	<script type="text/javascript" src = "../js/materialize.min.js"></script>
	<meta name="csrf-token" content="{{ csrf_token() }}" />

	<link rel="stylesheet" type="text/css" href="../css/mycss.css">		
</head>
<body class=" blue-grey lighten-1">
	<header>
		<nav>
			<div class="nav-wrapper black">
				<img src = '../homepage/logo.png' class = 'navIcon' style = 'top:15%;left:1%;'> </img>
				<a href='../admin/adminhome.php' > <label class="sys"> PAWNSHOP AUCTION SYSTEM</label> </a>
				<ul id="nav-mobile" class="right hide-on-med-and-down">
					<li><a class="modal-trigger" href="#modal1" data-target="modal1">ADMIN LOGIN</a></li>
					
				</ul>
			</div>
		</nav>
	</header>
  <!-- Modal Structure -->
	<div id="modal1" class="modal modal-width1 ">

		<div class="modal-content myfont ">

			<h5><center><b>LOGIN</b></h5></center>			
			   <div class="container " >
				<form method="POST" action="adminlogin.php">
					<div class="row black-">
						<label for="enterUsername">Username</label>
						<input name="enterUsername" id="enterUsername" type="text" class="validate">
					</div>
					<div class="row">
						<label for="enterPassword">Password</label>
						<input name="enterPassword" id="enterPassword" type="password" class="validate">
					</div>
					<div class="row">
						<button class="btn black waves-effect waves-light" type="submit" name="submit">Submit
							<i class="material-icons right">send</i>
						</button>
					
						<button class="btn black waves-effect waves-light" type="reset" name="reset">Clear
							<i class="material-icons right">send</i>
						</button>
					</div>
				</form>
			</div>
		</div>
	</div>    
<script type="text/javascript">
	$(document).ready(function() {
		Materialize.updateTextFields();
	});
</script>