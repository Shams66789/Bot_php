<?php 
 #one things you need to webhook the file using a https host to run it
$botToken = "token"; #replace the token from the token you get from bot father 
$website = "https://api.telegram.org/bot".$botToken;
error_reporting(0);
$update = file_get_contents('php://input');
$update = json_decode($update, TRUE);
$e = print_r($update);

#$chatId = reply_to_message_id;
$chatId = $update["message"]["chat"]["id"];
$gId = $update["message"]["from"]["id"];
$userId = $update["message"]["from"]["id"];
$firstname = $update["message"]["from"]["first_name"];
$username = $update["message"]["from"]["username"];
$message = $update["message"]["text"];
$message_id = $update["message"]["message_id"];
$r_userId = $update["message"]["reply_to_message"]["from"]["id"]; 
$r_firstname = $update["message"]["reply_to_message"]["from"]["first_name"]; 
$r_username = $update["message"]["reply_to_message"]["from"]["username"];
$r_msg_id = $update["message"]["reply_to_message"]["message_id"];

if($r_userId ===null)
{
   $info2 ="<b>ID : </b>$userId\n<b>First Name: </b>$firstname\n<b>Username : </b>@$username";   
}
else{
   $info2 ="<b>ID : </b>$r_userId\n<b>First Name: </b>$r_firstname\n<b>Username : </b>@$r_username";
}

$info = urlencode($info2);

$cmds11 = "<b>Hey, welcome to this Bot!%0ACommands List:<b>To know the info</b><code>$info</code>";

$message_text = "";

switch($message) {

      

       case "/start":
               $message_text = "Hey Type  /cmds for a list of all commands!";
               

               break;

       case "/cmds":

               $message_text = $cmds11;

               break;

       case "/info":

               $message_text = $info;

               break;

       case "/status":

             $message_text = "<b>I AM NOT DEAD </b>";

             break;

        case "/id":

               $message_text = "<b>CHAT ID : </b><code>$chatId</code>";

               break;

}

sendMessage($chatId, $message_text);

function sendMessage ($chatId, $message) {
       
        $url = $GLOBALS[website]."/sendMessage?chat_id=".$chatId."&text=".$message."&reply_to_message_id=".$message_id."&parse_mode=HTML";
        file_get_contents($url);
       
}

?>
