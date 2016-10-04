<?php
require('fpdf/fpdf.php');
require('../fpdi/fpdi.php');


// initiate FPDI
$pdf = new FPDI();

$pdf->addPage();

// initiate query

//include 'file_constants.php';
include 'convert-money-words.php';

include '../connect_to_pms.php';

$receipt = $_SESSION['delivery_receipt'];

$sql0= "SELECT * FROM tbl_delivery_receipts 
         INNER JOIN tbl_Deliveries
         ON tbl_delivery_receipts.delivery_ID = tbl_Deliveries.delivery_ID   
         INNER JOIN tbl_Cities
         ON tbl_Cities.city_ID = tbl_Deliveries.city_ID
         INNER JOIN tbl_Provinces
         ON tbl_Cities.province_ID = tbl_Provinces.province_ID
         INNER JOIN tbl_Checkouts
         ON tbl_Deliveries.checkout_ID = tbl_Checkouts.checkout_ID
         INNER JOIN tbl_Voucher
         ON tbl_Voucher.checkoutId = tbl_Checkouts.checkout_ID
         INNER JOIN tbl_Bidders
         ON tbl_Checkouts.bidder_ID = tbl_Bidders.bidder_ID
         INNER JOIN tbl_Auctions
         ON tbl_Checkouts.auction_ID = tbl_Auctions.auction_ID
        WHERE receipt_ID = $receipt";
$res0 = mysql_query($sql0) or die("Error in Query:" . mysql_error());
            
while($row = mysql_fetch_assoc($res0))
{
        $receiptNo = $row['receipt_ID'];
        $receiptNo = str_pad($receiptNo, 5, 0, STR_PAD_LEFT);
        $customerId = $row['bidder_ID'];
        $paymentDate = date("Y-m-d");
        $paymentDate = date("M jS, Y", strtotime($paymentDate));   
        $amount = $row['current_price']; // + delivery fee
        $deliveryfee = $row['delivery_fee'];
        $purposeOfPayment = "Delivery";
        $refNo = $row['voucherId'];//$row['refNo']; // idk what this is // voucher number daw
        $refNo = str_pad($refNo, 5, 0, STR_PAD_LEFT);
        $houseNo = $row['delivery_housenumber'];
        $street = $row['delivery_street'];
        $barangay = $row['delivery_barangay'];
        $city = $row['city_name'];
        $province =$row['province_name'];
        $lName = $row['bidder_lastname'];
        $fName = $row['bidder_firstname'];
        $mName = $row['bidder_middlename'];
        $auctionid = $row['auction_ID'];
}

// session userId
$userId = $_SESSION['userId'];
$sql2= "SELECT * FROM tbl_user WHERE userId = $userId";
$res2 = mysql_query($sql2) or die("Error in Query:" . mysql_error());
            
while($row = mysql_fetch_assoc($res2))
{
        $ufname = $row['firstName'];
        $umname = $row['middleName'];
        $ulname = $row['lastName'];
}


$cname = $lName . ", " . $fName . " " . $mName;
$uname = $ulname . ", " . $ufname . " " . $umname;
$address = $houseNo . " " . $street . ", " . $barangay . ", " . $city . ", " . $province;


$totalamount = convert_number_to_words($amount); // convert to wors
if (strpos($totalamount,"point zero zero") == true){
    $totalamount = str_replace('point zero zero', '', $totalamount);
}
$dword = convert_number_to_words($deliveryfee);
if (strpos($dword,"point zero zero") == true){
    $dword = str_replace('point zero zero', '', $dword);
}

// initiate data

$pdf->SetFont('Arial','B',14);

$pdf->Text(20,20,'PAWNSHOP AUCTION SYSTEM',0,'C');
$pdf->Text(20,25,'CLIENT\'S COPY',0,'C');
$pdf->Text(20,40,'Date:',0,'C');
$pdf->Text(20,50,'Name :',0,'C');
$pdf->Text(20,55,'Address:',0,'C');
$pdf->Text(130,20,'Reference Number',0,'C');
$pdf->Text(130,25,'Receipt Number',0,'C');

$pdf->SetFont('Arial','B',12);

$pdf->Text(180,20,$receiptNo,0,'C');
$pdf->Text(180,25,$refNo,0,'C');
$pdf->Text(50,40,$paymentDate,0,'C');
$pdf->Text(50,50,$cname,0,'C');
$pdf->Text(50,55,$address,0,'C');

$sql = mysql_query("SELECT * FROM tbl_Items
                    INNER JOIN tbl_item
                    ON tbl_Items.itemId = tbl_Item.itemId
                    INNER JOIN tbl_Auctionitems
                    ON tbl_Items.item_ID = tbl_Auctionitems.item_ID
                    INNER JOIN tbl_Auctions
                    ON tbl_Auctionitems.auction_ID = tbl_Auctions.auction_ID
                    WHERE tbl_Auctionitems.auction_ID = $auctionid");
$pdf->Text(70,70,'Description',0,'C');
$pdf->Text(150,70,'Price',0,'C');
$x = 80;
if(!mysql_num_rows($sql)==0){
    while($getitem = mysql_fetch_assoc($sql)){
        $pdf->Text(70,$x,$getitem['itemName'],0,'C');
        $pdf->Text(150,$x,$getitem['current_price'],0,'C');

        $x = $x + 5;
    }
}   
$x = $x + 5;
$pdf->Text(110,$x,'SubTotal:',0,'C');
$pdf->Text(110,$x+5,'Delivery Fee:',0,'C');
$pdf->Text(110,$x+10,'Total:',0,'C');
$pdf->Text(150,$x,$amount,0,'C');
$pdf->Text(150,$x + 5,$deliveryfee,0,'C');
$pdf->Text(150,$x + 10,$amount+$deliveryfee,0,'C');

$pdf->Output();
?>