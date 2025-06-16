<!DOCTYPE html>
<html>
<head>
    <title>Debug Chat Test</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>
<body style="font-family: Arial; padding: 20px;">
    <h1>Debug Chat Test</h1>
    <p>Ini halaman untuk debug chat tanpa interferensi dari file lain.</p>
    
    <button onclick="testFunction()" style="background: blue; color: white; padding: 10px; border: none; margin: 10px;">Test Button</button>
    
    <div id="test-chat-btn" style="position: fixed; bottom: 30px; right: 30px; width: 80px; height: 80px; background: red; color: white; border-radius: 50%; cursor: pointer; display: flex; align-items: center; justify-content: center; font-weight: bold;">
        CHAT
    </div>
    
    <div id="test-chat-container" style="display: none; position: fixed; bottom: 120px; right: 30px; width: 300px; height: 400px; background: white; border: 2px solid #ccc; border-radius: 10px; z-index: 9999;">
        <div style="background: #333; color: white; padding: 10px;">
            <span>Test Chat</span>
            <button id="test-close" style="float: right; background: none; border: none; color: white; cursor: pointer;">&times;</button>
        </div>
        <div style="padding: 20px;">
            <p>Chat berhasil dibuka!</p>
        </div>
    </div>
    
    <script>
        console.log('Debug script loaded');
        
        function testFunction() {
            alert('Test button works!');
        }
        
        document.addEventListener('DOMContentLoaded', function() {
            console.log('DOM loaded');
            
            const chatBtn = document.getElementById('test-chat-btn');
            const chatContainer = document.getElementById('test-chat-container');
            const closeBtn = document.getElementById('test-close');
            
            console.log('Elements:', {
                chatBtn: !!chatBtn,
                chatContainer: !!chatContainer,
                closeBtn: !!closeBtn
            });
            
            if (chatBtn) {
                chatBtn.onclick = function() {
                    console.log('Chat clicked!');
                    alert('Chat button diklik!');
                    if (chatContainer) {
                        chatContainer.style.display = 'block';
                    }
                };
            }
            
            if (closeBtn) {
                closeBtn.onclick = function() {
                    console.log('Close clicked!');
                    if (chatContainer) {
                        chatContainer.style.display = 'none';
                    }
                };
            }
        });
    </script>
</body>
</html>
