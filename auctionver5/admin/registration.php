<?php
	session_start();
	mysql_connect('localhost','root') OR DIE (mysql_error());
	mysql_select_db ('db_auction') OR DIE ("Unable to select db" .mysql_error());
	include('homepageparent.php');
?>
<h3 class="center">Bidder Registration</h3>
	<div class="divider"></div>
	<form method="POST" action="customer/register">
		<input type="hidden" name="_token" value="{{ csrf_token() }}">
		<div class="row">
    		<div class="input-field col s4">
				<input name="firstname" id="firstname" type="text" class="validate" REQUIRED>
				<label for="firstname">First Name</label>
			</div>
    		<div class="input-field col s4">
				<input name="middlename" id="middlename" type="text" class="validate">
				<label for="middlename">Middle Name</label>
			</div>
    		<div class="input-field col s4">
				<input name="lastname" id="lastname" type="text" class="validate" REQUIRED>
				<label for="lastname">Last Name</label>
			</div>
		</div>
		<div class="row">
			<div class="input-field col s6">
				<input name="contact" id="contact" type="text" class="validate" maxlength="11" REQUIRED>
				<label for="contact">Contact Number</label>
			</div>
			<div class="input-field col s6">
				<input name="email" id="email" type="email" class="validate" REQUIRED>
				<label for="email">Email Address</label>
			</div>
		</div>
		<div class="row">
			<div class="input-field col s6">
				<input name="username" id="username" type="text" class="validate" REQUIRED>
				<label for="username">Username</label>
			</div>
			<div class="input-field col s6">
				<input name="password" id="password" type="password" class="validate" REQUIRED>
				<label for="password">Password</label>
			</div>
		</div>
		<div class="row">
			<button class="btn waves-effect waves-light" type="submit" name="submit">Submit
				<i class="material-icons right">send</i>
			</button>
			<button class="btn waves-effect waves-light" type="reset" name="reset">Clear
				<i class="material-icons right">send</i>
			</button>
		</div>
	</form>