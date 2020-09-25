<?php 
 #one things you need to webhook the file using a https host to run it
$botToken = "token"; #replace the token from the token you get from bot father 
$website = "https://api.telegram.org/bot".$botToken;
error_reporting(0);
$update = file_get_contents('php://input');
$update = json_decode($update, TRUE);
 $e = print_r($update);
 
//$chatId = reply_to_message_id;
$chatId = $update["message"]["chat"]["id"];
//$chatId = "-490195907";
$gId = $update["message"]["from"]["id"];
$userId = $update["message"]["from"]["id"];
$firstname = $update["message"]["from"]["first_name"];
$username = $update["message"]["from"]["username"];
$message = $update["message"]["text"];
$message_id = $update["message"]["message_id"];

$username = urlencode($username);

$info = "<b>Chat Id : </b><code>$chatId</code>%0A<b>First Name : </b><code>$firstname</code><b>Username : </b><code>$username</code><b>User Id: </b><code>$userId</code>";


$cmds11 = "<b>Hey, welcome to this Bot!%0ACommands List:<b>To know the info</b><code>$info</code>";

switch($message) {
       
        case "/start":
                sendMessage($chatId, "<b>Type /cmds to know the command! </b>");
                break;
        case "/cmds":
                sendMessage($chatId,"This are the command'.$cmds11.'");
                break;
        case "/info":
                sendMessage($chatId,$info);
                break;
        }

function sendMessage ($chatId, $message) {
       
        $url = $GLOBALS[website]."/sendMessage?chat_id=".$chatId."&text=".$message."&reply_to_message_id=".$message_id."&parse_mode=HTML";
        file_get_contents($url);
       
}

?>