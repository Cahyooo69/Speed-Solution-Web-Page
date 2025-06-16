<?php

require_once 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';

$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\Chat;

echo "Fixing admin reply user_id associations...\n";

// Update admin replies to have the same user_id as the user messages in the same session
$adminReplies = Chat::where('sender_type', 'admin')
    ->whereNull('user_id')
    ->get();

foreach ($adminReplies as $adminReply) {
    // Find a user message in the same session
    $userMessage = Chat::where('session_id', $adminReply->session_id)
        ->where('sender_type', 'user')
        ->whereNotNull('user_id')
        ->first();
    
    if ($userMessage) {
        $adminReply->user_id = $userMessage->user_id;
        $adminReply->save();
        echo "Updated admin reply ID {$adminReply->id} with user_id {$userMessage->user_id}\n";
    } else {
        echo "No user message found for admin reply ID {$adminReply->id} in session {$adminReply->session_id}\n";
    }
}

echo "\nFixed admin replies. Updated chat records:\n";
$chats = Chat::orderBy('created_at', 'desc')->take(10)->get();
foreach ($chats as $chat) {
    echo "ID: {$chat->id}, Session: {$chat->session_id}, User_ID: {$chat->user_id}, Message: " . substr($chat->message, 0, 30) . "..., Sender: {$chat->sender_type}\n";
}
