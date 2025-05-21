<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tentang Speed Solution - Service Motor Terbaik</title>
    <link rel="stylesheet" href="{{ asset('css/tentang.css') }}">
</head>
<body>
    @include('partials.header')

    <!-- Hero Section -->
    <section class="hero">
        <div class="container hero-content">
            <div class="hero-text">
                <h1>SPEED SOLUTION,</h1>
                <p class="subheading">Solusi Kilat untuk Motor Hebat!</p>
                <p class="hero-description">Bawa pengalaman servis motor Anda ke level selanjutnya dengan sistem pemantauan kondisi motor yang canggih, dan harga yang selalu transparan di Bengkel Speed Solution.</p>
            </div>
            <div class="hero-images">
                <img src="{{ asset('images/mekanik_real.png') }}" alt="Speed Solution Workshop">
            </div>
        </div>
    </section>
    
    <!-- About Section -->
    <section class="about-section">
        <div class="container">
            <h2>SPEED SOLUTION MENTRANSFORMASI LAYANAN PURNA-JUAL OTOMOTIF</h2>
            <div class="about-content">
                <p>Indonesia tengah mengalami perkembangan pesat di sektor otomotif, termasuk dalam hal kepemilikan sepeda motor yang semakin meningkat. Meskipun informasi tentang perawatan kendaraan bisa didapatkan dengan mudah melalui internet, masih banyak pengendara motor yang kesulitan dalam mencari bengkel terpercaya dan memahami cara merawat motor mereka dengan tepat.</p>
                
                <p>Sebagian besar pengendara motor cenderung fokus pada pembelian motor baru, padahal yang lebih penting adalah mengetahui cara merawat dan memperbaiki motor mereka secara berkala. Sayangnya, hingga kini belum ada ekosistem yang menyatukan semua kebutuhan tersebut.</p>
                
                <p>Dengan Speed Solution, pengendara motor mendapatkan akses mudah ke informasi yang tepat, pelayanan profesional, dan harga yang transparan. Bengkel Speed Solution hadir sebagai one-stop solution untuk perawatan motor yang membawa pengalaman servis ke level berikutnya!</p>
            </div>
        </div>
    </section>

    <!-- Vision Mission Section -->
    <section class="vision-mission">
        <div class="container">
            <div class="vision-mission-content boxed">
                <div class="vision-mission-image">
                    <img src="{{ asset('images/tangan_mockup.png') }}" alt="Speed Solution Mobile App">
                </div>
                <div class="vision-mission-text">
                    <div class="vision-box">
                        <h3>Visi</h3>
                        <p>Menjadi bengkel motor terpercaya di Indonesia yang menghadirkan layanan perawatan dan perbaikan motor berbasis teknologi, dengan standar transparansi, kecepatan, dan kualitas terbaik bagi setiap pelanggan.</p>
                    </div>
                    <div class="mission-box">
                        <h3>Misi</h3>
                        <ol>
                            <li>Menyediakan layanan servis dan perbaikan motor yang cepat, akurat dan transparan.</li>
                            <li>Membangun jaringan bengkel yang profesional, ramah, dan berkompetensi di seluruh Indonesia.</li>
                            <li>Memberikan edukasi kepada pelanggan tentang pentingnya perawatan motor secara berkala.</li>
                            <li>Terus berinovasi dalam meningkatkan kualitas layanan demi kepuasan dan keselamatan pengendara motor.</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Journey Section -->
    <section class="journey-section">
        <div class="container">
            <div class="journey-box">
                <h2>Perjalanan Kami</h2>
                <p>Speed Solution terwujud sebagai implementasi dari cita-cita kami untuk menjadi mitra terpercaya untuk segala kebutuhan otomotif konsumen Indonesia. Kami berkomitmen untuk memajukan industri bengkel dan menciptakan lapangan kerja di Indonesia melalui inovasi teknologi.</p>
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
</body>
</html>
