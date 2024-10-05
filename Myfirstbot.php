<?php

class TelegramBot {
    private $botToken;
    private $website;
    private $update;

    public function __construct($token) {
        $this->botToken = $token;
        $this->website = "https://api.telegram.org/bot" . $this->botToken;
        $this->update = json_decode(file_get_contents('php://input'), TRUE);
    }
    
    /**
     * Method to give the chat id
     */
    public function getChatId() {
        return $this->update["message"]["chat"]["id"];
    }
    
    /**
     * Function to give the user information
     * @return Array 
     */
    public function getUserInfo() {
        $userId = $this->update["message"]["from"]["id"];
        $firstname = $this->update["message"]["from"]["first_name"];
        $username = isset($this->update["message"]["from"]["username"]) ? $this->update["message"]["from"]["username"] : '';
        return [
            "userId" => $userId,
            "firstname" => $firstname,
            "username" => $username
        ];
    }
    
    /**
     * Method to get the input message from user
     * @return String 
     */
    public function getMessage() {
        return $this->update["message"]["text"];
    }
    
    /**
     * Method to send reply message 
     */
    public function sendMessage($chatId, $message) {
        $url = $this->website . "/sendMessage?chat_id=" . $chatId . "&text=" . urlencode($message) . "&parse_mode=HTML";
        file_get_contents($url);
    }
    
    /**
     * Method to handle the commands;
     */
    public function handleCommand() {
        $message = $this->getMessage();
        $chatId = $this->getChatId();
        $userInfo = $this->getUserInfo();
        
        $info = "<b>ID : </b>{$userInfo['userId']}\n<b>First Name: </b>{$userInfo['firstname']}\n<b>Username : </b>@{$userInfo['username']}";

        switch ($message) {
            case "/start":
                $response = "Hey Type /cmds for a list of all commands!";
                break;
            case "/cmds":
                $response = "Hey, welcome to this Bot!\nCommands List:\n<b>To know the info- /info</b>\n<b>To know the id- /id</b>";
                break;
            case "/info":
                $response = $info;
                break;
            case "/status":
                $response = "<b>I AM NOT DEAD </b>";
                break;
            case "/id":
                $response = "<b>CHAT ID : </b><code>$chatId</code>";
                break;
            default:
                $response = "Invalid command.";
        }

        $this->sendMessage($chatId, $response);
    }
}

// Initialize the bot and handle the command
// paste the telegram bot in example:- TelegramBot("XXXXXXXXXXXXXXX"); 
$bot = new TelegramBot("");
$bot->handleCommand();

?>
