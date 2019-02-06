<?php

function createPayment($accrecnum, $amount, $method, $token){
    
    $data = array(
        "token" => $token,
        "accounts_receivable_identifier" => array(
            "number" => $accrecnum,
        ),
        "type_identifier" => array(
            "name" => 'Payment'
        ),
        "life_cycle_state" => 'POSTED',
        "payment_method_identifier" => array(
            "name" => $method,
        ),
        "payment_amount" => $amount,     
    );
    
    $server_output = curlPOST($data,"payments/create");
    
    if ($server_output->status->code == "OK") {
        return 'Payment Posted';   
    } else {
        return $server_output->status->message;
    }

}