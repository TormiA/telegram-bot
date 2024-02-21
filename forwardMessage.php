<?php

// Your bot's API token
$botToken = 'YOUR_BOT_API_TOKEN';

// ID of the group you want to forward messages to
$destinationChatId = 'YOUR_DESTINATION_GROUP_CHAT_ID';

// Function to forward messages
function forwardMessage($message) {
    global $botToken, $destinationChatId;
    
    $url = "https://api.telegram.org/bot$botToken/sendMessage";
    $data = array(
        'chat_id' => $destinationChatId,
        'text' => $message
    );
    
    $options = array(
        'http' => array(
            'method'  => 'POST',
            'content' => json_encode($data),
            'header' =>  "Content-Type: application/json\r\n" .
                        "Accept: application/json\r\n"
        )
    );

    $context  = stream_context_create($options);
    $result = file_get_contents($url, false, $context);

    return $result;
}

// Get the incoming message
$update = json_decode(file_get_contents('php://input'), true);
$message = $update['message']['text'];

// Forward the message to the destination group
forwardMessage($message);
