<?php
	$con = mysql_connect('localhost','root') or die(mysql_error());
	mysql_select_db('pms') or die("Cannot Select db");
	$a=$_POST['a'];
	$b=$_POST['b'];
	$c=$_POST['c'];
	$search=$_POST['x'];
	$extrastring ="";
	$status =" WHERE auction_status = 1";
	if($search==" " OR $search==""){	
		if($a!=0){
			$extrastring = " WHERE tbl_Main_categories.main_category_ID = $a";
			$status =" AND auction_status = 1";
		}
		if($b!=0){
			$extrastring = $extrastring." AND tbl_categories.category_ID = $b";
		}
		if($c!=0){
			$extrastring = $extrastring." AND tbl_subcategories.subcategory_ID = $c";
		}
	}
	else{
	// if($search!=" " OR $search!=""){
		$extrastring = $extrastring." WHERE tbl_auctions.auction_name LIKE '$search%'";
		$status = " AND auction_status = 1";
	}

			$get=mysql_query("SELECT * FROM tbl_Auctions
								INNER JOIN tbl_subcategories
								ON tbl_auctions.subcategory_ID = tbl_subcategories.subcategory_ID
								INNER JOIN tbl_categories
								ON tbl_subcategories.category_ID = tbl_categories.category_ID
								INNER JOIN tbl_main_categories
								ON tbl_categories.main_category_ID = tbl_main_categories.main_category_ID
				".$extrastring."".$status);
			if (mysql_num_rows($get)==0){
				echo "<center><h1>No Auctions Listed</h1></center>";
			}
			else {
				while($get_row=mysql_fetch_assoc($get)){
					$auc = $get_row['auction_ID'];
					$sql=mysql_query("SELECT * FROM tbl_Images
											INNER JOIN tbl_Items
											ON tbl_Images.item_ID = tbl_items.item_ID
											INNER JOIN tbl_Auctionitems
											ON tbl_Auctionitems.item_ID = tbl_Items.item_ID
											WHERE tbl_Auctionitems.auction_ID = $auc LIMIT 1
										");
					$get2=mysql_fetch_assoc($sql);
					if(mysql_num_rows($sql)!=0){
						$pic = $get2['item_image'];
					}
					else{
						$pic = "default.png";
					}
					$buttontext = "Bid Ended";
					if ($get_row['auction_status'] == 1){
							$buttontext = "Bid Now";		
					}	
					$bidders = mysql_num_rows(mysql_query("SELECT DISTINCT bidder_ID FROM tbl_Bids WHERE auction_ID = $auc"));
	?>						
					<div class="col s12 m6 l4">
  						<div class="card somehowsmall">
							<div class="card-image">
								<img class="activator" style="height:250px" src="uploads/<?php echo $pic?>">
							</div>
							<div class="card-content"> <!-- mb_strimwidth($get_row['auction_name'], 0, 10, "...") ; -->
								<span class="card-title activator grey-text text-darken-4"><?php echo mb_strimwidth($get_row['auction_name'], 0, 20, '...')?><i class="material-icons right">more_vert</i></span>
								<div class="row">	
									<div class="col s2"><?php echo "₱". $get_row['current_price']?></div>
									<form action="" method="POST">
										<input type="hidden" name="auctionid" value="<?php echo $get_row['auction_ID']?>">
										<div class="col push-s3"><input class="btn black" type="submit" name="bid" value="<?php echo $buttontext?>"></div>
									</form>
								</div>
							</div>
							<div class="card-reveal">
								<span class="card-title grey-text text-darken-4"><?php echo $get_row['auction_name']?><i class="material-icons right">close</i></span>
								<p><?php echo $get_row['auction_description']?></p>
								<p><b>Time Left</b>:
								<?php
									//Convert to date
									$datestr=$get_row['end_date']." ".$get_row['end_time'];//Your date
									$date=strtotime($datestr);//Converted to a PHP date (a second count)

									//Calculate difference
									$diff=$date-time();//time returns current time in seconds
									$days=floor($diff/(60*60*24));//seconds/minute*minutes/hour*hours/day)
									$hours=round(($diff-$days*60*60*24)/(60*60));

									//Report
									echo "$days days $hours hours"

								?>
								</p>
								<p><b>Current Price:</b> <?php echo $get_row['current_price']?>php</p>
								<p><b>Start Price:</b> <?php echo $get_row['starting_amount']?>php</p>
								<p><b>Auction Category: </b><?php echo $get_row['subcategory_name']?></p>
								<p><b>Starting Date:</b> 
									<?php echo date("M jS, Y", strtotime($get_row['start_date']));
									?>
								</p>
								<p><b>Bidders:</b> <?php echo $bidders?></p>
							</div>
						</div>	
					</div>
	<?php
				} //endwhile
			} //endelse
	?>
	</div>
</div>
<script type="text/javascript">
  $(".button-collapse").sideNav();
</script>