<?php
	include('../connect_to_pms.php');
	include('adminparent.php');
	$sql = mysql_fetch_assoc(mysql_query("SELECT * FROM tbl_biddingConstants WHERE bc_ID = 1"));
	$deadlineperiod = $sql['deadline_period'];
	$auctionperiod = $sql['auction_period'];
	$deadlineperiod = $deadlineperiod/24;
	$auctionperiod = $auctionperiod/24;

?>
<div class="myfont container">
    <div class="row">
		<div class="col s12">
			<h4><center>TRANSACTION PERIODS</center></h4>
			<div class="black divider"></div>
			<div class="card">
				<form action="" method="POST">
					<div class="row" style="margin-left:.2%;">		
						<div class="input-field col l4 m6 s12">
							<!-- DEADLINE PERIOD (in days) -->
							<input name="deadlineperiod" id="deadlineperiod" type="number" value="<?php echo $deadlineperiod?>" class="validate" onkeyup="validateNumberOnly(this.value,'deadlineperiod')" min="1" max="30" step="1"  required>
							<label class="black-text" for="deadlineperiod">Deadline Period (in days)</label>
						</div>
					</div>
					<div class="row" style="margin-left:.2%;">		
						<div class="input-field col l4 m6 s12">
							<!-- DEADLINE PERIOD (in days) -->
							<input name="auctionperiod" id="auctionperiod" type="number" value="<?php echo $auctionperiod?>" class="validate" onkeyup="validateNumberOnly(this.value,'auctionperiod')" min="1" max="30" step="1"  required>
							<label class="black-text" for="auctionperiod">Maximum Auction Period (in days)</label>
						</div>
					</div>
					<div class="row" style="margin-left:.2%;">		
						<div class="input-field col l4 m6 s12">
							<!-- DEADLINE PERIOD (in days) -->
							<input name="maxitems" id="maxitems" type="number" value="<?php echo $auctionperiod?>" class="validate" onkeyup="validateNumberOnly(this.value,'auctionperiod')" min="1" max="30" step="1"  required>
							<label class="black-text" for="maxitems">Maximum Items per Auction</label>
						</div>
					</div>
					<div class="row">
						<div class="input-field col s12">
							<input class="btn black white-text" type="submit" name="submit" value="Update">
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>		

<?php
	if(isset($_POST['submit'])){
		$deadlineperiod = $_POST['deadlineperiod'];
		$deadlineperiod = $deadlineperiod*24;
		$auctionperiod = $_POST['auctionperiod'];
		$auctionperiod = $auctionperiod*24;

		$sql = "UPDATE tbl_biddingConstants SET deadline_period = $deadlineperiod, auction_period = $auctionperiod WHERE bc_ID = 1";
		// var_dump($sql);
		$res = mysql_query($sql) or die("Error in Query: ".mysql_error());
		echo "
			<script>
			alert('Period Updated!');
			window.location.href = 'uti_period.php';
			</script>
		";
	}
?>