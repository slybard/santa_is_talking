<?php 
//imports
require 'vendor/autoload.php';
require "vendor/predis/predis/autoload.php";
require("includes/utils.php");
Predis\Autoloader::Register();


//post data
$caller = $_POST['callerNumber'];
$isCallActive = $_POST['isActive'];
$direction = $_POST['direction'];
$sessionID = $_POST['sessionId'];

try {
    $redis = new Predis\Client();
    
    $callstate = GetCallState($redis, $sessionID, $caller);
    if ($isCallActive == 1 && $direction == "Outbound") {
        
        if ($callstate == "Intro") {
            $str = "Welcome to the North Pole. I am Elfie. Press 1 followed by the hash sign to continue";
            $callstate = "Reception";
            SetCallState($redis, $sessionID, $caller, $callstate);
            SendResponse(true, $str);
        }
        
        elseif ($callstate == "Reception") {
            $userinput = $_POST['dtmfDigits'];
            
            if ($userinput == "1") {
                $str = "Okay. What would you like for Christmas. Press 1 followed by hash if you want a cup for Christmas. Press 2 followed by hash if you want a girlfriend for Christmas";
                $callstate = "Options";
                SetCallState($redis, $sessionID, $caller, $callstate);
                SendResponse(true, $str);
            }
        }
        
        elseif ($callstate == "Options") {
            
            $userinput = $_POST['dtmfDigits'];
            $callstate = "End";
            
            if ($userinput == "1" || $userinput == "2") {
                $str = "That is a good choice. We've sent the Northern Express to deliver. Merry Christmas";
            }
            SetCallState($redis, $sessionID, $caller, $callstate);
            SendResponse(false, $str);
            
        }
    }
    
    else {
        SendResponse(false);
    }
    
    
} catch (Exception $e) {
    echo $e->getMessage();
}

?>