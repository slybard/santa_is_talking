<?php 

//AIT
$aitusername = "Klaus_JR";
$aitkey = "f955be572d3184e216acdd5d7d7e3b7211a94ec61581d994529951599cc57ae3";
$aitnumber = "+256312319100";

//base url
$baseURL = "https://christmas-wishlist-slybard.c9users.io/";

//REDIS
$rediskey = "hellofromsanta";

//send response
function SendResponse($getresponse, $str = "Thank you. Goodbye!"){
    
    //construct response
    $response = '<?xml version="1.0" encoding="UTF-8"?>';
    $response .= '<Response>';
    if (!$getresponse) {
        $response .= '<Say>' . $str . '</Say>';
    }
    
    else {
            $response .= '<GetDigits  timeout="30" finishOnKey="#">';
            $response .= '<Say>' . $str . '</Say>';
            $response .= '</GetDigits>';
    }
    
                $response .= '</Response>';
            header('Content-type: text/plain');
            echo $response;
}

//set call state
function SetCallState($redis, $sessionid, $callernum, $callstate){
    global $rediskey;
    
    $redis->expire($rediskey, 200);
    
    $redis->hmset($rediskey, [
        "sessionId" => $sessioId,
        "caller" => $callerNum,
        "callstate" => $callstate]);
}

//get call state
function GetCallState($redis, $sessionId, $callernum){
    global $rediskey;
    $callstate = "Intro";
    if ($redis->exists($rediskey) == 1) {
        $state = $redis->hgetall($rediskey);
        
        if ($state['sessionId'] == $sessionId && $state['caller'] == $callernum) {
            $callstate = $state['callstate'];
        }
    }
    
    return $callstate;
}

?>