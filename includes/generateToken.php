<?php

require 'curlPOST.php';

function getToken()
{
    global $apiUrl;
    global $apiUsername;
    global $apiPassword;
    global $apiOrganisation;

    $data = array(
        "username" => $apiUsername,
        "password" => $apiPassword,
        "organisation" => $apiOrganisation,
    );
    
    $server_output = curlPOST($data,"authentication/token");

    if ($server_output->status->code == "OK") {
		return $server_output->data->token;	
	} else {
		return $server_output->status->message;
	}
}
