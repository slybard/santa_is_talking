<?php

//get some post data
$callerNumber = $_POST['callerNumber'];
$direction = $_POST['direction'];
$sessionID = $_POST['sessionId'];
$isCallActive = $_POST['isActive'];

if ($isCallActive == 1 && $direction == "Inbound") {
    //hang up
    
    
    //immediately call user back
}

elseif ($isCallActive == 1 && $direction == "Outbound") {
    //redirect call to be processed on other page
}

else{
}


?>
