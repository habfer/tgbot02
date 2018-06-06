<?php

include('vendor/autoload.php');

include('TelegramBot.php');

include('GeneratePasswords.php');

$telegramApi = new TelegramBot();
$generate = new GeneratePasswords();
$work = true;

while (true) {

    sleep(2);

    $updates = $telegramApi->getUpdates();

    foreach ($updates as $update) {

        if (isset($update->message->text)) {

            $userschoice = $update->message->text;

            switch ($userschoice) {

                case "/start":
                    $telegramApi->sendMessage($update->message->chat->id, "Hello, my dear user :)");
                    break;

                case "/help":
                    $telegramApi->sendMessage($update->message->chat->id, "This bot can help you keep your passwords in the mind :)");
                    break;

                case "/generate_new":
                    $telegramApi->sendMessage($update->message->chat->id, "For generating password, please choose a difficulty: easy - 8 symb; medium - 12 symb; hard - 16 symb:");

                    while ($work) {
                        
                        sleep(2);
                        
                        $new_updates = $telegramApi->getUpdates();

                        foreach ($new_updates as $new_update) {

                            if (isset($new_update->message->text)) {

                                $userschoice = $new_update->message->text;

                                if ($userschoice == "/start" || $userschoice == "/help" || $userschoice == "/generate_new") {
                                    $work = false;
                                    continue;
                                }

                                $passw = $generate->GeneratePassword($userschoice);

                                if ($passw == "Choose one of 3 difficulties, please.") {

                                    $telegramApi->sendMessage($new_update->message->chat->id, $passw);  

                                    break;  
                                }
                                else
                                {
                                    $telegramApi->sendMessage($update->message->chat->id, "Here is your password, friend: " . $passw);
                                    $work = false;
                                    break;
                                }
                            }
                            else
                                $telegramApi->sendMessage($update->message->chat->id, "I do not understand anything besides the text!");
                        }
                    }
                    break;

                default:
                    $telegramApi->sendMessage($update->message->chat->id, "Give me some command!");
                    break;
            }

            
        }

        else 
            $telegramApi->sendMessage($update->message->chat->id, "I do not understand anything besides the text!");
        
    }

}