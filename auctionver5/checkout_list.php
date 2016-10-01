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
    
<link rel=" lesheet" type="text/css" href="admin/DataTables/media/css/jquery.dataTables.css"/>
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
<h4><center>CHECK OUTS</center></h4>
<div class="black divider"></div>
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
    <th>Status</th>
    <!-- <th>Action</th> -->
    <th></th>
  </thead>
  <tbody>
          <?php
              $get = mysql_query("SELECT * FROM tbl_Checkouts
                                    INNER JOIN tbl_Auctions
                                    ON tbl_Checkouts.auction_ID = tbl_Auctions.auction_ID
                                    INNER JOIN tbl_Voucher
                                    ON tbl_Checkouts.checkout_ID = tbl_Voucher.checkoutId
                                    WHERE bidder_ID = $user
                        ");
            // FIX THIS, dapat lalabas lang ung specific auction na nibidan ko - checked
            // KASO ang lumalabas ay ang kung sino ang UNANG nagbid, 
            // SO kahit nagbid ako, eh pangalawa ako, hindi parin magdidisplay sakin  
            if(!mysql_num_rows($get)==0){
              while($get_row = mysql_fetch_assoc($get)){
                ?>
                <tr>
                  <!-- <td id="tdID<?php //echo $get_row['auction_id']?>"><?php //echo $get_row['auction_ID']?></td> -->
                  <td id="tdAuctionName<?php echo $get_row['checkout_ID']?>"><?php echo $get_row['auction_name']?></td>
                  <td id="tdDescription<?php echo $get_row['checkout_ID']?>"><?php echo $get_row['auction_description']?></td>
                  <!-- <td id="tdStartingAmount<?php // echo $get_row['checkout_ID']?>"><?php // echo $get_row['starting_amount']?></td> -->
                  <td id="tdCurrentPrice<?php echo $get_row['checkout_ID']?>"><?php echo $get_row['current_price']?></td>
                  <td id="tdStartDate<?php echo $get_row['checkout_ID']?>"><?php echo date("M jS, Y", strtotime($get_row['start_date']))." ".date("g:i:s a", strtotime($get_row['start_time']));?></td>
                  <td id="tdendDate<?php echo $get_row['checkout_ID']?>"><?php echo date("M jS, Y", strtotime($get_row['end_date']))." ".date("g:i:s a", strtotime($get_row['end_time']));?></td>
                  <td id="tdStatus<?php echo $get_row['checkout_ID']?>">
                    <?php 
                        $button = "";
                        if ($get_row['checkout_status'] == 0){   
                            echo "Pending";
                            $button = '<button class="btn black white-text">EDIT</button>';
                        }
                        else if ($get_row['checkout_status'] == 1){   
                            echo "Ready";
                        }
                        else if ($get_row['checkout_status'] == 2){   
                            echo "On Route";
                        }
                        else if ($get_row['checkout_status'] == 3){   
                            echo "Delivered";
                        }
                        else if ($get_row['checkout_status'] == 4){   
                            echo "Redeemed";
                        }
                        else if ($get_row['checkout_status'] == 5){   
                            echo "Forfeited";
                        }
                    ?></td>
                  <!-- <td><?php // echo $button?></td> -->
<!--                   <div class="col">  
                      <button class="btn black white-text" onclick="viewContent(<?php //echo $get_row['auction_ID']?>)">View</button>
                        </div> -->
                  <td>
                    <form action="" method="POST">
                        <input type="hidden" name="voucher" value="<?php echo $get_row['voucherId']?>">
                        <div class="col push-s3"><input class="btn black" type="submit" name="bid" value="Print"></div>
                    </form>
                  </td>
                </tr>
                <?php
              }
            }
          ?>
  </tbody>
</table>


<?php
  if(isset($_POST['bid'])){
    $_SESSION['voucher'] = $_POST['voucher'];
    echo "
      <script>
                    window.open('form-auction-voucher.php','_blank');
      </script>";
  }
?>