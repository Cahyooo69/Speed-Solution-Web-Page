<?php

require_once 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';

$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\Chat;

echo "Total chats in database: " . Chat::count() . "\n";

$chats = Chat::orderBy('created_at', 'desc')->take(5)->get();

foreach ($chats as $chat) {
    echo "ID: {$chat->id}, Session: {$chat->session_id}, User_ID: {$chat->user_id}, Message: {$chat->message}, Sender: {$chat->sender_type}, Created: {$chat->created_at}\n";
}

if (Chat::count() == 0) {
    echo "No chats found in database. This could be the issue.\n";
}
