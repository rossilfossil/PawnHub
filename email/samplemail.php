<?php

// echo "wah";
require 'PHPMailer/PHPMailerAutoload.php';

function sendEmail($receiver,$message){

	// echo $message." ".$receiver;
	$mail = new PHPMailer;

	//$mail->SMTPDebug = 3;                               // Enable verbose debug output
	$mail->isSMTP();                                      // Set mailer to use SMTP
	$mail->Host = 'smtp.gmail.com';  // Specify main and backup SMTP servers
	$mail->SMTPAuth = true;                               // Enable SMTP authentication
	$mail->Username = 'pawnshopms41n@gmail.com';                 // SMTP username
	$mail->Password = 'pmscapstone';                           // SMTP password
	$mail->SMTPSecure = 'tls';                            // Enable TLS encryption, `ssl` also accepted
	$mail->Port = 587;                                    // TCP port to connect to

	$mail->setFrom('pawnshopms41n@gmail.com', 'Auction');
	$mail->addAddress($receiver, 'PMS-Auction Admin');     // Add a recipient
	//$mail->addAddress('ellen@example.com');               // Name is optional
	//$mail->addReplyTo('info@example.com', 'Information');
	//$mail->addCC('cc@example.com');
	//$mail->addBCC('bcc@example.com');

	//$mail->addAttachment('/var/tmp/file.tar.gz');         // Add attachments
	//$mail->addAttachment('/tmp/image.jpg', 'new.jpg');    // Optional name
	$mail->isHTML(true);                                  // Set email format to HTML

	$mail->SMTPOptions = array(
	'ssl' => array(
	    'verify_peer' => false,
	    'verify_peer_name' => false,
	    'allow_self_signed' => true
	)
	);

	$mail->Subject = 'Pawnshop-Auction System';
	$mail->Body    = $message;
	$mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

	if(!$mail->send()) {
	echo 'Message could not be sent.';
	echo 'Mailer Error: ' . $mail->ErrorInfo;
	} else {
	echo 'Message has been sent';
}
}