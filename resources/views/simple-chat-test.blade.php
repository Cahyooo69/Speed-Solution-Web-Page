<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Simple Chat Test</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            padding: 20px;
            margin: 0;
            height: 100vh;
        }
        
        /* Floating Chat Button */
        .floating-btn {
            position: fixed !important;
            bottom: 30px !important;
            right: 30px !important;
            width: 80px !important;
            height: 80px !important;
            border-radius: 50% !important;
            background-color: #fff !important;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.3) !important;
            z-index: 9999 !important;
            cursor: pointer !important;
            display: flex !important;
            align-items: center !important;
            justify-content: center !important;
            transition: transform 0.3s ease !important;
            border: none !important;
            outline: none !important;
        }
        
        .floating-btn:hover {
            transform: scale(1.1) !important;
            box-shadow: 0 6px 20px rgba(0, 0, 0, 0.4) !important;
        }
        
        .floating-btn img {
            width: 85% !important;
            height: 85% !important;
            object-fit: contain !important;
            border-radius: 50% !important;
        }
        
        /* Chat Container */
        .chat-container {
            position: fixed !important;
            bottom: 120px !important;
            right: 30px !important;
            width: 380px !important;
            height: 500px !important;
            background-color: #fff !important;
            border-radius: 15px !important;
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.2) !important;
            z-index: 9998 !important;
            display: none !important;
            flex-direction: column !important;
            overflow: hidden !important;
        }
        
        .chat-header {
            background-color: #CD0505 !important;
            color: white !important;
            padding: 20px !important;
            display: flex !important;
            justify-content: space-between !important;
            align-items: center !important;
        }
        
        .chat-header h3 {
            margin: 0 !important;
            font-size: 18px !important;
            font-weight: 600 !important;
        }
        
        .close-chat {
            background: none !important;
            border: none !important;
            color: white !important;
            font-size: 24px !important;
            cursor: pointer !important;
            line-height: 1 !important;
            padding: 0 !important;
        }
        
        .chat-body {
            padding: 20px !important;
            flex-grow: 1 !important;
            overflow-y: auto !important;
            background-color: #f8f9fa !important;
        }
        
        .chat-message {
            margin-bottom: 15px !important;
            padding: 12px 16px !important;
            border-radius: 18px !important;
            max-width: 85% !important;
            word-wrap: break-word !important;
            font-size: 14px !important;
            line-height: 1.4 !important;
        }
        
        .message-received {
            background-color: #CD0505 !important;
            color: white !important;
            align-self: flex-start !important;
            border-bottom-left-radius: 4px !important;
        }
        
        .message-sent {
            background-color: #e9ecef !important;
            color: #333 !important;
            align-self: flex-end !important;
            margin-left: auto !important;
            border-bottom-right-radius: 4px !important;
        }
        
        .chat-messages {
            display: flex !important;
            flex-direction: column !important;
            min-height: 100% !important;
        }
        
        .chat-input {
            display: flex !important;
            padding: 15px !important;
            border-top: 1px solid #e9ecef !important;
            background-color: white !important;
        }
        
        .chat-input input {
            flex-grow: 1 !important;
            border: 2px solid #e9ecef !important;
            border-radius: 25px !important;
            padding: 12px 18px !important;
            margin-right: 10px !important;
            font-size: 14px !important;
            outline: none !important;
        }
        
        .chat-input button {
            background-color: #CD0505 !important;
            color: white !important;
            border: none !important;
            border-radius: 25px !important;
            padding: 12px 20px !important;
            cursor: pointer !important;
            font-weight: 600 !important;
        }
    </style>
</head>
<body>
    <h1 style="color: #CD0505;">Test Chat Widget</h1>
    <p>Klik tombol chat di pojok kanan bawah untuk mengetes chat.</p>
    <p>Jika tidak terlihat, periksa console untuk error.</p>

    <!-- Chat Widget -->
    <div id="floating-chat-btn" class="floating-btn">
        <img src="{{ asset('images/mechanic_mascot.png') }}" alt="Speed Solution Chat">
    </div>

    <div id="chat-container" class="chat-container">
        <div class="chat-header">
            <h3>Speed Solution Konsultasi</h3>
            <button id="close-chat" class="close-chat">&times;</button>
        </div>
        
        <div class="chat-body">
            <div id="chat-messages" class="chat-messages">
                <div class="chat-message message-received">
                    Halo! Selamat datang di Speed Solution. Ada yang bisa saya bantu dengan kendaraan Anda?
                </div>
            </div>
        </div>
        
        <div class="chat-input">
            <input type="text" id="message-input" placeholder="Ketik pesan Anda...">
            <button id="send-message">Kirim</button>
        </div>
    </div>

    <script>
    document.addEventListener('DOMContentLoaded', function() {
        console.log('Simple chat test loaded');
        
        const floatingBtn = document.getElementById('floating-chat-btn');
        const chatContainer = document.getElementById('chat-container');
        const closeBtn = document.getElementById('close-chat');
        
        console.log('Elements found:', {
            floatingBtn: !!floatingBtn,
            chatContainer: !!chatContainer,
            closeBtn: !!closeBtn
        });
        
        if (floatingBtn) {
            floatingBtn.addEventListener('click', function() {
                console.log('Chat button clicked!');
                chatContainer.style.display = 'flex';
            });
        }
        
        if (closeBtn) {
            closeBtn.addEventListener('click', function() {
                console.log('Close button clicked!');
                chatContainer.style.display = 'none';
            });
        }
    });
    </script>
</body>
</html>
