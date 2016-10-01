<?php
require('fpdf/fpdf.php');
require('fpdi/fpdi.php');


// initiate FPDI
$pdf = new FPDI();

// get the page count
$pageCount = $pdf->setSourceFile('pdf/auction_voucher.pdf');
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

include 'connect_to_pms.php';

$voucher = $_SESSION['voucher'];
$get = mysql_fetch_assoc(mysql_query("SELECT * FROM tbl_Voucher 
                                            INNER JOIN tbl_Checkouts
                                            ON tbl_Voucher.checkoutId = tbl_Checkouts.checkout_ID
                                            WHERE voucherId = $voucher"));
$checkoutId = $get['checkoutId'];

$sql1= "SELECT * FROM tbl_checkouts WHERE checkout_ID = $checkoutId";
$res1 = mysql_query($sql1) or die("Error in Query:" . mysql_error());
            
while($row = mysql_fetch_assoc($res1))
{
        $checkoutId = $row['checkout_ID'];
        $bidderId = $row['bidder_ID'];
        $auctionId = $row['auction_ID'];
        $claim_preference = $row['claim_preference'];

}

$sql2= "SELECT * FROM tbl_bidders 
            INNER JOIN tbl_Cities
            ON tbl_bidders.bidder_city = tbl_Cities.city_ID
            INNER JOIN tbl_Provinces
            ON tbl_Cities.province_ID = tbl_Provinces.province_ID
WHERE bidder_ID = $bidderId";
$res2 = mysql_query($sql2) or die("Error in Query:" . mysql_error());
            
while($row = mysql_fetch_assoc($res2))
{
        
        $bidderId = $row['bidder_ID'];
        $bidder_lname = $row['bidder_lastname'];
        $bidder_fname = $row['bidder_firstname'];
        $bidder_mname = $row['bidder_middlename'];
        $bidder_prov = $row['province_name'];
        $bidder_city = $row['city_name'];
        $bidder_brgy = $row['bidder_barangay'];
        $bidder_street = $row['bidder_street'];
        $bidder_houseno = $row['bidder_housenumber'];
        $bidder_contact = $row['bidder_contact'];
        $bidder_email = $row['bidder_email'];

}

$sql3= "SELECT * FROM tbl_auctions WHERE auction_ID = $auctionId";
$res3 = mysql_query($sql3) or die("Error in Query:" . mysql_error());
            
while($row = mysql_fetch_assoc($res3))
{
        
        $auctionId = $row['auction_ID'];
        $auction_name = $row['auction_name']; 
        $auction_description = $row['auction_description'];

        $end_date = $row['end_date'];
        $end_date = date("M jS, Y", strtotime($end_date));
        $current_price = $row['current_price'];
        $total = $current_price;
}



// queries in if else


if($claim_preference == 0){
    $sql4= "SELECT * FROM tbl_deliveries
                WHERE checkout_ID = $checkoutId";
    $res4 = mysql_query($sql4) or die("Error in Query:" . mysql_error());
                
    while($row = mysql_fetch_assoc($res4))
    {
            $checkoutId = $row['checkout_ID'];
            $deliveryId = $row['delivery_ID'];
            $delivery_brgy= $row['delivery_barangay'];
            $delivery_city = $row['city_ID'];
            $delivery_street = $row['delivery_street'];
            $delivery_houseno = $row['delivery_housenumber'];
    }

        $get = mysql_fetch_assoc(mysql_query("SELECT * FROM tbl_Provinces 
                                INNER JOIN tbl_Regions
                                ON tbl_Provinces.region_ID = tbl_Regions.region_ID
                                INNER JOIN tbl_Cities
                                ON tbl_Cities.province_ID = tbl_Provinces.province_ID
            WHERE city_ID = $delivery_city"));
        $delivery_prov = $get['province_name']; 
        $delivery_city = $get['city_name'];
        $delivery_fee = $get['delivery_fee'];
        $total = $current_price + $delivery_fee;
}


else if($claim_preference == 1){

    $sql5= "SELECT * FROM tbl_pickups WHERE checkout_ID = $checkoutId";
    $res5 = mysql_query($sql5) or die("Error in Query:" . mysql_error());
                
    while($row = mysql_fetch_assoc($res5))
    {
            $checkoutId = $row['checkout_ID'];
            $pickupId = $row['pickup_ID'];
            $branchId = $row['branchId'];
    }


    $sql6= "SELECT * FROM tbl_branch 
            INNER JOIN tbl_Cities
            ON tbl_branch.city_ID = tbl_Cities.city_ID
            INNER JOIN tbl_Provinces
            ON tbl_Cities.province_ID = tbl_Provinces.province_ID
    WHERE branchId = $branchId";
    $res6 = mysql_query($sql6) or die("Error in Query:" . mysql_error());
                
    while($row = mysql_fetch_assoc($res6))
    {
            $branchname = $row['branchName'];
            $bstreet = $row['street'];
            $bcity = $row['city_name'];
            $bprob = $row['province_name'];
    }
}

$bname = $bidder_lname." , ".$bidder_fname." ".$bidder_mname." . ";
$voucher = str_pad($voucher, 5, 0, STR_PAD_LEFT);

// initiate data

$pdf->SetFont('Arial','U',13);

$pdf->Text(170,20,$voucher,0,'C');

$pdf->SetFont('Arial','B',13);

$pdf->Text(155,49,$auction_name,0,'C');
$pdf->Text(150,58,$auction_description,0,'C');
$pdf->Text(150,66,$end_date,0,'C');


$pdf->SetFont('Arial','B',24);
$pdf->SetTextColor(255, 0, 0);
$pdf->Text(150,111,"PHP ".$total,0,'C');

$pdf->SetFont('Arial','B',12);
$pdf->SetTextColor(0, 0, 0);
$pdf->Text(40,54,$bname,0,'C');

$pdf->Text(40,59,$bidder_houseno." ".$bidder_street." ".$bidder_brgy.", ",0,'C');
$pdf->Text(40,64,$bidder_city." ".$bidder_prov,0,'C');


$pdf->Text(45,70,$bidder_contact,0,'C');
$pdf->Text(49,75,$bidder_email,0,'C');




if($claim_preference == 0) {

    $claimpref = "FOR DELIVERY";

    $pdf->SetFont('Arial','B',17);
    $pdf->Text(20,93,$claimpref,0,'C');

    $pdf->SetFont('Arial','B',12);
    $pdf->Text(40,103,$delivery_houseno." ".$delivery_street." ".$delivery_brgy.", ",0,'C');
    $pdf->Text(20,108,$delivery_city.", ".$delivery_prov,0,'C');


    $pdf->Text(117,95,"Amount",0,'C');
    $pdf->Text(117,100,"Delivery Fee:",0,'C');
    $pdf->Text(150,95,"PHP ".$current_price,0,'C');
    $pdf->Text(150,100,"PHP ".$delivery_fee,0,'C');

}

else if($claim_preference == 1) {

    $claimpref = "FOR PICK-UP";

    $pdf->SetFont('Arial','B',17);
    $pdf->Text(20,93,$claimpref,0,'C');

    $pdf->SetFont('Arial','B',12);
    $pdf->Text(40,103,$branchname." - ". $bstreet." ".$bcity." ,".$bprob,0,'C');
  
}

$pdf->Output();

?>