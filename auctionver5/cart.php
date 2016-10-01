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
<!-- <script type="text/javascript" src="admin/viewAuction.js"></script> -->
	
<link rel="	lesheet" type="text/css" href="admin/DataTables/media/css/jquery.dataTables.css"/>
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
  <div id="viewModal" class="modal">
    <div class="modal-content">
    <h4>Auction Details</h4>
    <div class="black divider"></div><br>
      <div id="viewContent"></div>
    </div>
    <div class="modal-footer">
      <a href="#!" class=" modal-action modal-close waves-effect waves-green btn-flat">Close</a>
    </div>
  </div>
<div class="container myfont">
  <br>
<h4><center>ITEMS RECENTLY WON</center></h4>
<div class="card">
  <table class="highlight responsive-table centered" id="tableOutput">
  <thead>
    <!-- <th>ID</th> -->
    <th>Auction Name</th>
    <th>Auction Description</th>
    <!-- <th>Starting Amount</th> -->
    <th>Current Price</th>
    <th>Start Date</th>
    <th>End Date</th>
    <!-- <th>Auction Status</th> -->
    <th></th>
    <th></th>
  </thead>
  <tbody>
          <?php
              $get = mysql_query("SELECT * FROM tbl_Auctions
                        WHERE auction_status = 2
            			");
            // FIX THIS, dapat lalabas lang ung specific auction na nibidan ko - checked
            // KASO ang lumalabas ay ang kung sino ang UNANG nagbid, 
            // SO kahit nagbid ako, eh pangalawa ako, hindi parin magdidisplay sakin  
            if(!mysql_num_rows($get)==0){
              while($get_row = mysql_fetch_assoc($get)){
                $auction_ID = $get_row['auction_ID'];
                $get2 = mysql_query("SELECT * FROM tbl_Bids
                        WHERE auction_ID = $auction_ID
                        AND bidder_ID = $user
                  ");
                if(!mysql_num_rows($get2) ==0){
                
                ?>
                <tr>
                  <!-- <td id="tdID<?php //echo $get_row['auction_id']?>"><?php //echo $get_row['auction_ID']?></td> -->
                  <td id="tdAuctionName<?php echo $get_row['auction_id']?>"><?php echo $get_row['auction_name']?></td>
                  <td id="tdDescription<?php echo $get_row['auction_id']?>"><?php echo $get_row['auction_description']?></td>
                  <td id="tdStartingAmount<?php echo $get_row['auction_id']?>"><?php echo $get_row['starting_amount']?></td>
                  <!-- <td id="tdCurrentPrice<?php //echo $get_row['auction_id']?>"><?php //echo $get_row['current_price']?></td> -->
                  <td id="tdStartDate<?php echo $get_row['auction_id']?>"><?php echo $get_row['start_date']?></td>
                  <td id="tdEndDate<?php echo $get_row['auction_id']?>"><?php echo $get_row['end_date']?></td>
                  <!-- <td id="tdStatus<?php echo $get_row['auction_id']?>"> -->
        					<?php 
				        		// if ($get_row['auction_status'] == 1){	
              //         echo "Ongoing";
              //       }
              //       else{
              //         echo "Ended";
              //       }
                  ?>
                  <!-- </td> -->
                  <td>
                    <form action="" method="POST">
                      <input type="hidden" name="auctionid" value="<?php echo $get_row['auction_ID']?>">
                      <button type="submit" name="cancel" class="btn black white-text" onclick="cancelCheckout(<?php echo $get_row['auction_ID']?>)">Cancel</button>
                    </form>
                  </td>
                  <td>
<!--                   <div class="col">  
                      <button class="btn black white-text" onclick="viewContent(<?php //echo $get_row['auction_ID']?>)">View</button>
                        </div> -->

                    <form action="" method="POST">
                      <input type="hidden" name="auctionid" value="<?php echo $get_row['auction_ID'] ?>">
                      <div class="col push-s3"><input class="btn black" type="submit" name="checkout" value="CHECKOUT"></div>
                    </form>
                  </td>
                </tr>
                <?php
              }
            }
          }
          ?>
  </tbody>
</table>


<?php 
  if(isset($_POST['checkout'])){
    $_SESSION['auction_id'] = $_POST['auctionid'];
    $_SESSION['checkoutconfirmation'] = 1;
    echo "
      <script>
        window.location.href = 'checkout.php';
      </script>";
  }


  else if(isset($_POST['cancel'])){
    $_SESSION['auction_id'] = $_POST['auctionid'];
    echo "
      <script>
        var r = confirm('Are you sure you wanted to cancel your checkout?');
        if (r == true) {
            window.location = 'cancelCheckout.php'
        }
      </script>";
  }
?>