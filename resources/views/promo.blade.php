<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Promo Speed Solution - Dapatkan Promo Terbaik</title>
    <link rel="stylesheet" href="{{ asset('css/promo.css') }}">
</head>
<body>
    @include('partials.header')

    <!-- Promo Hero Section -->
    <section class="promo-hero">
        <img src="{{ asset('images/bg_bengkel.png') }}" alt="Promo Speed Solution">
        <div class="promo-hero-content">
            <div class="promo-title">
                <h1>Promo</h1>
                <h2>Dapatkan dan Nikmati Promo Terbaik dari Kami</h2>
            </div>
        </div>
    </section>

    <!-- Promo Content -->
    <section class="promo-content">
        <div class="container">
            <div class="current-promo">
                <h2 class="promo-heading">PROMO MEI 2025</h2>
                <p class="promo-period">Periode Promo : 01 Mei - 31 Mei 2025</p>
                
                <div class="promo-description">
                    <p>Yuk langsung ke Speed Solution terdekat buat dapetin promonya ✨</p>
                    
                    <div class="promo-info">
                        <p>📍 Berlaku di semua outlet Speed Solution</p>
                        <p>*) Syarat & Ketentuan Berlaku</p>
                    </div>
                    
                    <div class="contact-info">
                        <p>Untuk info lebih lanjut bisa hubungi Official :</p>
                        <p>Whatsapp : 08983841072</p>
                    </div>
                    
                    <div class="social-info">
                        <p>Ikuti Official akun media sosial Speed Solutiuon untuk mendapatkan info dan promo terupdate :</p>
                        <p>Instagram : @speedsolution_</p>
                        <p>Facebook : SpeedSolutionsda</p>
                        <p>Tiktok : speedsolution_</p>
                        <p>Website : www.speedsolution.co.id</p>
                    </div>
                </div>
                
                <div class="terms-section">
                    <h3 class="terms-heading">Syarat dan Ketentuan</h3>
                    <p>S&K: Pembelian langsung ke outlet</p>
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
</body>
</html>
