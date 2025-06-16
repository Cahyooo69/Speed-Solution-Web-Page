<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Chat Test Page</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            padding: 20px;
            margin: 0;
        }
        h1 {
            color: #CD0505;
        }
        /* Import chat styles from app.css */
        @import url('/build/assets/app-CqnGSSYm.css');
    </style>
</head>
<body>
    <h1>Test Halaman Chat</h1>
    <p>Halaman ini untuk test chat widget. Coba klik tombol chat di pojok kanan bawah.</p>
    
    <div style="height: 100vh;">
        <p>Scroll ke bawah untuk melihat chat button...</p>
    </div>

    <!-- Include Chat Widget -->
    @include('partials.chat_simple')
</body>
</html>
