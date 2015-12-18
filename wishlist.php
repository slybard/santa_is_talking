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
    
    if ($isCallActive == 1 && $direction == "Outbound") {
        $callstate = GetCallState($redis, $sessionID, $caller);
        
        if ($callstate == "Intro") {
            $str = "Welcome to the North Pole. I am Elfie. Press 1 followed by the hash sign to continue";
            $callstate = "Reception";
            SendResponse(true, $str);
            SetCallState($redis, $sessionID, $caller, $callstate);
        }
        
        elseif ($callstate == "Reception") {
            $userinput = $_POST['dtmf'];
            
            if ($userinput == "1") {
                $str = "Okay. What would you like for Christmas. Press 1 followed by hash if you want a cup for Christmas. Press 2 followed by hash if you want a girlfriend for Christmas";
                $callstate = "Options";
                SendResponse(true, $str);
                SetCallState($redis, $sessionID, $caller, $callstate);
            }
        }
        
        elseif ($callstate == "Options") {
            
            $userinput = $_POST['dtmf'];
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