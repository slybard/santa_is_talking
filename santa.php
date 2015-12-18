<?php

require_once(__DIR__."/includes/AfricasTalkingGateway.php");
require_once(__DIR__."/includes/utils.php");

//get some post data
$callerNumber = $_POST['callerNumber'];
$direction = $_POST['direction'];
$sessionID = $_POST['sessionId'];
$isCallActive = $_POST['isActive'];

if ($isCallActive == 1 && $direction == "Inbound") {
    //hang up
    //construct response
    $response = '<?xml version="1.0" encoding="UTF-8"?>';
    $response .= '<Response>';
    $response .= '<Reject/>';
    $response .= '</Response>';
    header('Content-type: text/plain');
    echo $response;
    
    //immediately call user back
    $gateway = new AfricasTalkingGateway($aitusername, $aitkey);
    try {
        $gateway->call($aitnumber, $callerNumber);
    } catch (Exception $e) {
        echo "error: ".$e->getMessage();
    }
}

elseif ($isCallActive == 1 && $direction == "Outbound") {
    //redirect call to be processed on other page
    $url = "https://santa-slybard.c9users.io/wishlist.php";
    //construct response
    $response = '<?xml version="1.0" encoding="UTF-8"?>';
    $response .= '<Response>';
    $response .= '<Redirect>'.$url.'</Redirect>';
    $response .= '</Response>';
    header('Content-type: text/plain');
    echo $response;
}

else{
    SendResponse(false, "Goodbye!");
}


?>
