<?php
    include('connect_to_pms.php');
    $_SESSION['redirect']="account.php";
    if(!isset($_SESSION['userId'])){
        include('homepageparent.php');
        echo "<center><h1>Please Log in!</h1></center>";
        return;
    }
    else{ 
        $user = $_SESSION['userId'];
        include('accessgrantedparent.php');
    }
?>
	
<link rel="stylesheet" type="text/css" href="admin/DataTables/media/css/jquery.dataTables.css"/>
<link rel="stylesheet" type="text/css" href="admin/DataTables/media/css/jquery.dataTables.min.css"/>
<script type="text/javascript" src="admin/DataTables/media/js/jquery.dataTables.js"></script>
<script type="text/javascript" src="admin/DataTables/media/js/jquery.dataTables.min.js"></script>
<script type="text/javascript">
$(document).ready(function(){
    $('#tableOutput').DataTable({
    "bLengthChange": false,
    "pageLength" : 5
    });
})
</script>

<div class="container myfont">
  <br>
<h4><center>LISTINGS YOU'VE JOINED</center></h4>
<div class="card">
  <table class="highlight responsive-table centered" id="tableOutput">
  <thead>
    <!-- <th>ID</th> -->
    <th>Auction Name</th>
    <th>Auction Description</th>
    <!-- <th>Item Name</th> -->
    <!-- <th>Starting Amount</th> -->
    <th>Current Price</th>
    <th>Start Date</th>
    <th>End Date</th>
    <th>Auction Status</th>
    <th>Action</th>
  </thead>
  <tbody>
          <?php
              $get = mysql_query("SELECT * FROM tbl_Auctions");
            if(!mysql_num_rows($get)==0){
              while($get_row = mysql_fetch_assoc($get)){
                $auction_ID = $get_row['auction_ID'];
                $get2 = mysql_query("SELECT * FROM tbl_Bids
                        WHERE auction_ID = $auction_ID
                        AND bidder_ID = $user
                  ");
                if(!mysql_num_rows($get2) ==0){
                  
                // }
                // else{
                
                ?>
                <tr>
                  <!-- <td id="tdID<?php //echo $get_row['auction_id']?>"><?php //echo $get_row['auction_ID']?></td> -->
                  <td id="tdAuctionName<?php echo $get_row['auction_id']?>"><?php echo $get_row['auction_name']?></td>
                  <td id="tdDescription<?php echo $get_row['auction_id']?>"><?php echo $get_row['auction_description']?></td>
<!--                   <td id="tdItemName<?php //echo $get_row['auction_id']?>"><?php //echo $get_row['itemName']?></td>-->
                  <!-- <td id="tdStartingAmount<?php //echo $get_row['auction_id']?>"><?php //echo $get_row['starting_amount']?></td> -->
                  <td id="tdCurrentPrice<?php echo $get_row['auction_id']?>">P<?php echo $get_row['current_price']?></td>
                  <td id="tdStartDate<?php echo $get_row['auction_id']?>"><?php echo date("M jS, Y", strtotime($get_row['start_date']))." ".date("g:i:s a", strtotime($get_row['start_time']));?></td>
                  <td id="tdendDate<?php echo $get_row['auction_id']?>"><?php echo date("M jS, Y", strtotime($get_row['end_date']))." ".date("g:i:s a", strtotime($get_row['end_time']));?></td>
                  <td id="tdStatus<?php echo $get_row['auction_id']?>">
					<?php 
						if ($get_row['auction_status'] == 1){	
							echo "Ongoing";
						}
            else if ($get_row['auction_status'] == 5){ 
              echo "Checkout";
            }
            else if ($get_row['auction_status'] == 6){ 
              echo "Forfeited";
            }
						else{
							echo "Ended";
						}
					?></td>
                  <td>
                  <form action="" method="POST">
                    <input type="hidden" name="auctionid" value="<?php echo $get_row['auction_ID']?>">
                    <div class="col push-s3"><input class="btn black" type="submit" name="bid" value="VIEW"></div>
                  </form>
                </tr>
                <?php
              }
            }
          }
          ?>
  </tbody>
</table>


<?php
  if(isset($_POST['bid'])){
    $_SESSION['auction_id'] = $_POST['auctionid'];
    echo "
      <script>
        window.location.href = 'listing.php';
      </script>";
  }
?>

