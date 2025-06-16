<?php

require_once 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';

$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\User;

// Update user ID 1 to be admin
$user = User::find(1);
if ($user) {
    $user->role = 'admin';
    $user->save();
    echo "User '{$user->name}' has been updated to admin role.\n";
} else {
    echo "User with ID 1 not found.\n";
}

// Show updated users
echo "\nUpdated users:\n";
$users = User::all();
foreach ($users as $user) {
    echo "ID: {$user->id}, Name: {$user->name}, Email: {$user->email}, Role: {$user->role}\n";
}
