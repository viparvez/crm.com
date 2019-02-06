<?php

//=================createPayment()=====================

function activate($subId){
	
	global $token;
	
	$data = array("token" => $token,
        "subscription_identifier" => array(
        	"number" => $subId,
        )
    );
    
    $server_output = curlPOST($data,"subscriptions/activate");
    
    if ($server_output->status->code == "OK") {
			return 'Activation Completed';	
		} else {
			return $server_output->status->message;
		}
}

