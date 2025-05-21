<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Speed Solution - Service Motor Terbaik</title>
    <link rel="stylesheet" href="{{ asset('css/landing.css') }}">
    <style>
        /* Floating Button Style */
        .floating-btn {
            position: fixed;
            bottom: 30px;
            right: 30px;
            width: 70px;
            height: 70px;
            border-radius: 50%;
            background-color: #fff;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            z-index: 1000;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: transform 0.3s;
        }
        
        .floating-btn:hover {
            transform: scale(1.1);
        }
        
        .floating-btn img {
            width: 85%;
            height: 85%;
            object-fit: contain;
        }
        
        /* Chat Window Style */
        .chat-container {
            position: fixed;
            bottom: 110px;
            right: 30px;
            width: 350px;
            height: 450px;
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
            z-index: 999;
            display: none;
            flex-direction: column;
            overflow: hidden;
        }
        
        .chat-header {
            background-color: #e61c23;
            color: white;
            padding: 15px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        
        .chat-header h3 {
            margin: 0;
            font-size: 18px;
        }
        
        .close-chat {
            background: none;
            border: none;
            color: white;
            font-size: 20px;
            cursor: pointer;
        }
        
        .chat-body {
            padding: 15px;
            flex-grow: 1;
            overflow-y: auto;
            background-color: #f5f5f5;
        }
        
        .chat-message {
            margin-bottom: 10px;
            padding: 10px;
            border-radius: 10px;
            max-width: 80%;
        }
        
        .message-received {
            background-color: #e61c23;
            color: white;
            align-self: flex-start;
        }
        
        .message-sent {
            background-color: #e6e6e6;
            color: #333;
            align-self: flex-end;
            margin-left: auto;
        }
        
        .chat-messages {
            display: flex;
            flex-direction: column;
        }
        
        .chat-input {
            display: flex;
            padding: 10px;
            border-top: 1px solid #ddd;
        }
        
        .chat-input input {
            flex-grow: 1;
            border: 1px solid #ddd;
            border-radius: 20px;
            padding: 8px 15px;
            margin-right: 10px;
        }
        
        .chat-input button {
            background-color: #e61c23;
            color: white;
            border: none;
            border-radius: 20px;
            padding: 8px 15px;
            cursor: pointer;
        }
    </style>
</head>
<body>
     @include('partials.header')

    <!-- Hero Section -->
    <section class="hero">
        <div class="container hero-content">
            <div class="hero-text">
                <h1>Service Motor to The Next Level dengan Speed Solution!</h1>
                <div class="info-box">
                    <h3>Motor Kamu Bermasalah?</h3>
                    <p>Dapatkan Solusi Terbaik bersama Speed Consultant.</p>
                    <a href="#" class="btn btn-block" id="contact-us-btn">Hubungi Kami</a>
                </div>
            </div>
            <div class="hero-images">
                <img src="{{ asset('images/workshop.png') }}" alt="Speed Solution Workshop">
            </div>
        </div>
    </section>
    
    <!-- Services Section -->
    <section class="services">
        <div class="container">
            <h2>PILIH JENIS SERVIS YANG MEMUDAHKAN PERAWATAN MOTORMU</h2>
            <div class="services-scroll">
                <div class="service-card">
                    <div class="image-wrapper">
                        <img src="{{ asset('images/gantioli.png') }}" alt="Oli Service">
                        <div class="overlay-text">
                            <h3>Oli</h3>
                            <div class="price">
                                <span class="label">Mulai dari</span>
                                <span class="amount">Rp. 50.000/Liter</span>
                            </div>
                            <a href="#" class="btn">Pesan Sekarang</a>
                            <p>Ganti oli + gratis jasa penggantian</p>
                        </div>
                    </div>
                </div>

                <div class="service-card">
                    <div class="image-wrapper">
                        <img src="{{ asset('images/rem.png') }}" alt="Rem Service">
                        <div class="overlay-text">
                            <h3>Rem</h3>
                            <div class="price">
                                <span class="label">Mulai dari</span>
                                <span class="amount">Rp. 40.000</span>
                            </div>
                            <a href="#" class="btn">Pesan Sekarang</a>
                            <p>Jaga kondisi rem agar aman berkendara</p>
                        </div>
                    </div>
                </div>

                <div class="service-card">
                    <div class="image-wrapper">
                        <img src="{{ asset('images/detailing.png') }}" alt="Detailing Service">
                        <div class="overlay-text">
                            <h3>Detailing</h3>
                            <div class="price">
                                <span class="label">Mulai dari</span>
                                <span class="amount">Rp. 50.000</span>
                            </div>
                            <a href="#" class="btn">Pesan Sekarang</a>
                            <p>Bikin cat motor kamu kembali kinclong</p>
                        </div>
                    </div>
                </div>

                <div class="service-card">
                    <div class="image-wrapper">
                        <img src="{{ asset('images/tuneup.png') }}" alt="Tune Up">
                        <div class="overlay-text">
                            <h3>Tune Up</h3>
                            <div class="price">
                                <span class="label">Mulai dari</span>
                                <span class="amount">Rp. 90.000</span>
                            </div>
                            <a href="#" class="btn">Pesan Sekarang</a>
                            <p>Tune up rutin untuk mengembalikan tenaga maksimal</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Testimonials -->
    <section class="testimonials">
        <div class="container">
            <h2>KATA MEREKA TENTANG SPEED SOLUTION</h2>
            <div class="testimonial-container">
                <div class="testimonial-card">
                    <img src="{{ asset('images/ilham.png') }}" alt="Ilham Nurcahyo" class="testimonial-img">
                    <h3>Ilham Nurcahyo</h3>
                    <span class="testimonial-role">Mahasiswa - Sidoarjo</span>
                    <p>Hasil servicenya rapi dan cepet banget, sangat cocok buat kalian yang suka modifikasi motor juga, di Speed Solution ini juga banyak sparepart variasi yang bagus dan berkualitas</p>
                    <div class="stars">★ ★ ★ ★ ★</div>
                </div>
                <div class="testimonial-card">
                    <img src="{{ asset('images/farhan.png') }}" alt="Farhan Maheswara" class="testimonial-img">
                    <h3>Farhan Maheswara</h3>
                    <span class="testimonial-role">Mahasiswa - Surabaya</span>
                    <p>Modif motor jadi makin gampang bareng Speed Solution! Servis cepat, hasil rapi, dan pilihan sparepart variasi yang lengkap serta berkualitas tinggi. Cocok banget buat kamu yang ingin tampil beda dan tetap nyaman di jalan!</p>
                    <div class="stars">★ ★ ★ ★ ★</div>
                </div>
                <div class="testimonial-card">
                    <img src="{{ asset('images/daud.png') }}" alt="Daud Rizal" class="testimonial-img">
                    <h3>Daud Rizal</h3>
                    <span class="testimonial-role">Driver Ojek - Gresik</span>
                    <p>Driver ojek? Wajib coba Speed Solution! Servis motor jadi cepat, hasil rapi, dan banyak pilihan sparepart berkualitas. Gak perlu antri lama, motor kamu selalu siap ngebut cari orderan!</p>
                    <div class="stars">★ ★ ★ ★ ★</div>
                </div>
            </div>
        </div>
    </section>

    <!-- Partners -->
    <section class="partners">
        <div class="container">
            <h2>PARTNER KAMI</h2>
            <div class="partner-logos">
                <div class="partner-logo">
                    <img src="{{ asset('images/pirelli.png') }}" alt="Pirelli">
                </div>
                <div class="partner-logo">
                    <img src="{{ asset('images/brembo.png') }}" alt="Brembo">
                </div>
                <div class="partner-logo">
                    <img src="{{ asset('images/aspira.png') }}" alt="Aspira">
                </div>
                <div class="partner-logo">
                    <img src="{{ asset('images/shell 1.png') }}" alt="Shell">
                </div>
                <div class="partner-logo">
                    <img src="{{ asset('images/motul.png') }}" alt="Motul">
                </div>
                <div class="partner-logo">
                    <img src="{{ asset('images/brt logo.png') }}" alt="Brt">
                </div>
                <div class="partner-logo">
                    <img src="{{ asset('images/ohlins.png') }}" alt="Ohlins">
                </div>
                <div class="partner-logo">
                    <img src="{{ asset('images/tdr.png') }}" alt="TDR">
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer>
        <div class="container">
            <div class="footer-content">
                <div class="footer-logo">
                    <img src="{{ asset('images/footer_logo.png') }}" alt="Speed Solution Logo">
                    <p>Didirikan pada tahun 2025, Speed Solution memiliki visi misi menjadi platform bengkel digital terpercaya di Indonesia yang memberikan kemudahan, kecepatan, dan kualitas dalam memenuhi kebutuhan perawatan dan modifikasi sepeda motor. Tersedia ganti oli dan tune up rem, aki, detailing, dan servis lainnya dengan praktis!</p>
                </div>
                <div class="footer-contact">
                    <h3>Speed Solution Center</h3>
                    <p>Jl. Beciro No.238, Sukodono, Jumputrejo, Kec. Sukodono, Kabupaten Sidoarjo, Jawa Timur 61258</p>
                    <br>
                    <h3>Informasi Kontak Layanan Pengaduan Konsumen</h3>
                    <p>WhatsApp Customer Service Speed Solution: 08983841072</p>
                </div>
            </div>
            <div class="footer-bottom">
                <p><span class="tag">#SingleFighter</span></p>
            </div>
        </div>
    </footer>

    <!-- Floating Chat Button -->
    <div class="floating-btn" id="floating-chat-btn">
        <img src="{{ asset('images/mechanic_mascot.png') }}" alt="Speed Solution Chat">
    </div>

    <!-- Chat Window -->
    <div class="chat-container" id="chat-container">
        <div class="chat-header">
            <h3>Speed Solution Konsultasi</h3>
            <button class="close-chat" id="close-chat">&times;</button>
        </div>
        <div class="chat-body">
            <div class="chat-messages" id="chat-messages">
                <div class="chat-message message-received">
                    Halo! Selamat datang di Speed Solution. Ada yang bisa kami bantu dengan kendaraan Anda?
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
            const floatingBtn = document.getElementById('floating-chat-btn');
            const contactUsBtn = document.getElementById('contact-us-btn');
            const chatContainer = document.getElementById('chat-container');
            const closeChat = document.getElementById('close-chat');
            const messageInput = document.getElementById('message-input');
            const sendMessage = document.getElementById('send-message');
            const chatMessages = document.getElementById('chat-messages');
            
            // Function to show chat window
            function showChat() {
                chatContainer.style.display = 'flex';
            }
            
            // Function to hide chat window
            function hideChat() {
                chatContainer.style.display = 'none';
            }
            
            // Show chat when floating button is clicked
            floatingBtn.addEventListener('click', showChat);
            
            // Show chat when "Hubungi Kami" button is clicked
            contactUsBtn.addEventListener('click', function(e) {
                e.preventDefault();
                showChat();
            });
            
            // Hide chat when close button is clicked
            closeChat.addEventListener('click', hideChat);
            
            // Function to send message
            function sendUserMessage() {
                const message = messageInput.value.trim();
                if (message !== '') {
                    // Create user message element
                    const userMessage = document.createElement('div');
                    userMessage.className = 'chat-message message-sent';
                    userMessage.textContent = message;
                    chatMessages.appendChild(userMessage);
                    
                    // Clear input
                    messageInput.value = '';
                    
                    // Auto-scroll to bottom
                    chatMessages.scrollTop = chatMessages.scrollHeight;
                    
                    // Simulate response after a short delay
                    setTimeout(function() {
                        const responseMessage = document.createElement('div');
                        responseMessage.className = 'chat-message message-received';
                        responseMessage.textContent = 'Terima kasih atas pertanyaan Anda. Konsultan kami akan segera membantu Anda. Mohon tunggu sebentar.';
                        chatMessages.appendChild(responseMessage);
                        chatMessages.scrollTop = chatMessages.scrollHeight;
                    }, 1000);
                }
            }
            
            // Send message when send button is clicked
            sendMessage.addEventListener('click', sendUserMessage);
            
            // Send message when Enter key is pressed
            messageInput.addEventListener('keypress', function(e) {
                if (e.key === 'Enter') {
                    sendUserMessage();
                }
            });
        });
    </script>
</body>
</html>