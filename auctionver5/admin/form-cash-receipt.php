<?php
require('fpdf/fpdf.php');
require('../fpdi/fpdi.php');


// initiate FPDI
$pdf = new FPDI();

// get the page count
$pageCount = $pdf->setSourceFile('../pdf/cash_receipt.pdf');
// iterate through all pages
for ($pageNo = 1; $pageNo <= $pageCount; $pageNo++) {
    // import a page
    $templateId = $pdf->importPage($pageNo);
    // get the size of the imported page
    $size = $pdf->getTemplateSize($templateId);

    // create a page (landscape or portrait depending on the imported page size)
    if ($size['w'] > $size['h']) {
        $pdf->AddPage('L', array($size['w'], $size['h']));
    } else {
        $pdf->AddPage('P', array($size['w'], $size['h']));
    }

// use the imported page
$pdf->useTemplate($templateId);

}

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

$pdf->SetFont('Arial','B',9);

$pdf->Text(99,10,$receiptNo,0,'C');
$pdf->Text(18,17,$paymentDate,0,'C');
$pdf->Text(93,17,$refNo,0,'C');
$pdf->Text(50,26,$cname,0,'C');
$pdf->Text(30,31,$address,0,'C');

$pdf->Text(30,43,$totalamount." pesos(PHP ".$amount.")",0,'C');
$pdf->Text(30,49,"+delivery fee of ".$dword."pesos(PHP ".$deliveryfee.")",0,'C');
$pdf->Text(45,56,$purposeOfPayment,0,'C');

$pdf->Text(45,63,$uname,0,'C');


$pdf->Output();

?>