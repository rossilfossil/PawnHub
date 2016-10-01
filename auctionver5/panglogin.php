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
