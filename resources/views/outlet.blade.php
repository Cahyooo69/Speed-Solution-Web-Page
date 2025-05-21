<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Outlet Speed Solution - Temukan Bengkel Motor Terdekat</title>
    <link rel="stylesheet" href="{{ asset('css/outlet.css') }}">
</head>
<body>
    @include('partials.header')

    <!-- Outlet Hero Section -->
    <section class="outlet-hero">
        <img src="{{ asset('images/bg_bengkel.png') }}" alt="Outlet Speed Solution">
        <div class="outlet-hero-content">
            <div class="outlet-title">
                <h1>Outlet</h1>
                <h2>Temukan Kami di Lokasi Terdekat Anda</h2>
            </div>
        </div>
    </section>

    <!-- Sidoarjo Outlets -->
    <section class="outlets">
        <div class="container">
            <h2 class="region-title">SIDOARJO</h2>
            
            <div class="outlet-cards">
                <div class="outlet-card">
                    <h3>Speed Solution Jumputrejo</h3>
                    <div class="outlet-info">
                        <div class="info-item">
                            <div class="icon-wrapper">
                                <img src="{{ asset('images/phone.png') }}" alt="Phone" class="info-icon">
                            </div>
                            <p>08983841072</p>
                        </div>
                        <div class="info-item">
                            <div class="icon-wrapper">
                                <img src="{{ asset('images/navigation.png') }}" alt="Location" class="info-icon">
                            </div>
                            <p>Jl Beciro, RT : 11 RW : 03 Jumputrejo, Sukodono, Sidoarjo</p>
                        </div>
                    </div>
                    <a href="https://www.google.com/maps/@-7.4145265,112.7007763,3a,75y,12.96h,83.28t/data=!3m7!1e1!3m5!1svX5rG2cXu8SRMDWwhSx0BQ!2e0!6shttps:%2F%2Fstreetviewpixels-pa.googleapis.com%2Fv1%2Fthumbnail%3Fcb_client%3Dmaps_sv.tactile%26w%3D900%26h%3D600%26pitch%3D6.720865784002115%26panoid%3DvX5rG2cXu8SRMDWwhSx0BQ%26yaw%3D12.956459535577075!7i16384!8i8192?entry=ttu&g_ep=EgoyMDI1MDUxNS4wIKXMDSoASAFQAw%3D%3D" target="_blank" class="btn btn-direction">Arahkan</a>
                </div>
                
                <div class="outlet-card">
                    <h3>Speed Solution Candi</h3>
                    <div class="outlet-info">
                        <div class="info-item">
                            <div class="icon-wrapper">
                                <img src="{{ asset('images/phone.png') }}" alt="Phone" class="info-icon">
                            </div>
                            <p>08982134231</p>
                        </div>
                        <div class="info-item">
                            <div class="icon-wrapper">
                                <img src="{{ asset('images/navigation.png') }}" alt="Location" class="info-icon">
                            </div>
                            <p>Gelam, Candi, Sidoarjo Regency</p>
                        </div>
                    </div>
                    <a href="https://www.google.com/maps/@-7.4835947,112.7128842,3a,75y,175.33h,98.48t/data=!3m7!1e1!3m5!1sY_e01CkP2rAtd3UG3EXGOw!2e0!6shttps:%2F%2Fstreetviewpixels-pa.googleapis.com%2Fv1%2Fthumbnail%3Fcb_client%3Dmaps_sv.tactile%26w%3D900%26h%3D600%26pitch%3D-8.47796799245971%26panoid%3DY_e01CkP2rAtd3UG3EXGOw%26yaw%3D175.3346488721017!7i16384!8i8192?entry=ttu&g_ep=EgoyMDI1MDUxNS4wIKXMDSoASAFQAw%3D%3D" target="_blank" class="btn btn-direction">Arahkan</a>
                </div>
            </div>

            <!-- Surabaya Outlets -->
            <h2 class="region-title">SURABAYA</h2>
            
            <div class="outlet-cards">
                <div class="outlet-card">
                    <h3>Speed Solution G. Anyar</h3>
                    <div class="outlet-info">
                        <div class="info-item">
                            <div class="icon-wrapper">
                                <img src="{{ asset('images/phone.png') }}" alt="Phone" class="info-icon">
                            </div>
                            <p>08982918347</p>
                        </div>
                        <div class="info-item">
                            <div class="icon-wrapper">
                                <img src="{{ asset('images/navigation.png') }}" alt="Location" class="info-icon">
                            </div>
                            <p>Jl. Dr. Ir. H. Soekarno No.682, Gn. Anyar, Kec. Gn. Anyar, Surabaya, Jawa Timur 60294</p>
                        </div>
                    </div>
                    <a href="https://www.google.com/maps/@-7.3444275,112.7864897,3a,32.6y,6.06h,78.58t/data=!3m7!1e1!3m5!1sxFwUKQhynVOCAcj8Y2sHTw!2e0!6shttps:%2F%2Fstreetviewpixels-pa.googleapis.com%2Fv1%2Fthumbnail%3Fcb_client%3Dmaps_sv.tactile%26w%3D900%26h%3D600%26pitch%3D11.42436708018191%26panoid%3DxFwUKQhynVOCAcj8Y2sHTw%26yaw%3D6.057781717777167!7i16384!8i8192?entry=ttu&g_ep=EgoyMDI1MDUxNS4wIKXMDSoASAFQAw%3D%3D" target="_blank" class="btn btn-direction">Arahkan</a>
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