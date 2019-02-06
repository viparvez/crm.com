<?php

function checkStatus($accrecnum){
	
	global $token;
	global $apiUrl;
	
	$url = $apiUrl."subscriptions/list/?token=$token&accounts_receivable_identifier=number=$accrecnum";
	$ch = curl_init();
	$timeout = 5;
	curl_setopt($ch, CURLOPT_URL, $url);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
	curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
	$server_output = json_decode(curl_exec($ch));
	$server_output = curl_exec($ch);
	curl_close($ch);
	return $server_output;
}