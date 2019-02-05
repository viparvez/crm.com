<?php

//=======================SET THE API USER CREDENTIALS========================
$apiUrl = "https://202.84.39.107/crmapi/rest/v2/";
$apiUsername = "protitee.yasmine";
$apiPassword = "protitee";
$apiOrganisation = "BEXIMCO";

// ============================== Functions ==================================
//==============================callCURL()=============================

function curlPOST($data,$actionURL){
	
	global $apiUrl;
	
	$jsonData = json_encode($data);
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL,"$apiUrl$actionURL"); 
	curl_setopt($ch, CURLOPT_POST, 1);
	curl_setopt($ch, CURLOPT_POSTFIELDS,$jsonData);
	curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
	curl_setopt($ch, CURLOPT_HTTPHEADER, array(
	                'Content-Type: application/json',
	                'Content-Length: ' . strlen($jsonData))
	        );

	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

	$server_output = curl_exec ($ch);

	if ($server_output === FALSE) {
	    printf("cUrl error (#%d): %s<br>\n", curl_errno($ch),
	    htmlspecialchars(curl_error($ch)));
	}

	$server_output = json_decode($server_output);

	curl_close ($ch);
	
	return $server_output;
}
