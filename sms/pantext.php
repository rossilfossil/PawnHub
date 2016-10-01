<?php
/**
 * This file will show a simple implementation on how to send SMS using Chikka API
 * @author Ronald Allan Mojica
 * 
 * 
 */
include('chikka.php');

function sendSMS($textcount,$message){

	$clientId = '6d0a6634c848f34afe600d42422ffc412823da15983149d9e5a768470ea3867c';
	$secretKey = '3527adda68064dce2daa352a7d05ab219a7eea4336da8f355eb6c2b28309d6a1';
	$shortCode = '2929006214';

	$textnumber 	= $_POST['textcount'];
	$message		= $_POST['message'];

	$chikkaAPI = new ChikkaSMS($clientId,$secretKey,$shortCode);
	$response = $chikkaAPI->sendText($textnumber,'639995956624',$message);
	header("HTTP/1.1 " . $response->status . " " . $response->message);
	exit($response->description);
}