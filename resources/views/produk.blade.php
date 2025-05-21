<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Produk Speed Solution - Layanan Bengkel Terbaik</title>
    <link rel="stylesheet" href="{{ asset('css/produk.css') }}">
</head>
<body>
    @include('partials.header')

    <!-- Produk Hero Section -->
    <section class="produk-hero">
        <img src="{{ asset('images/bg_bengkel.png') }}" alt="Produk Speed Solution">
        <div class="produk-hero-content">
            <div class="produk-title">
                <h1>Produk</h1>
                <h2>Temukan Produk dan Layanan Bengkel Terbaik dari Kami</h2>
            </div>
        </div>
    </section>

    <!-- Produk Content -->
    <section class="produk-content">
        <div class="container">
            <div class="produk-kategori">
                <h2 class="produk-heading">KATALOG PRODUK & LAYANAN</h2>
                <p class="produk-subtitle">Solusi Terbaik untuk Sepeda Motor Anda</p>
                
                <!-- Kategori Filter -->
                <div class="kategori-filter">
                    <button class="filter-btn active" data-filter="all">Semua</button>
                    <button class="filter-btn" data-filter="ban">Ban</button>
                    <button class="filter-btn" data-filter="oli">Oli & Pelumas</button>
                    <button class="filter-btn" data-filter="sparepart">Sparepart</button>
                    <button class="filter-btn" data-filter="aksesoris">Aksesoris</button>
                </div>

                <!-- Status Scraping -->
                @if(isset($error))
                <div class="scraping-error">
                    <p>Terjadi kesalahan saat mengambil data: {{ $error }}</p>
                </div>
                @endif

                <!-- Produk Grid dari Scraping -->
                <div class="produk-grid">
                    @if(isset($produkList) && count($produkList) > 0)
                        @foreach($produkList as $index => $produk)
                            <div class="produk-item {{ $produk['kategori'] ?? 'ban' }}">
                                <div class="produk-card">
                                    <div class="produk-image">
                                        @if(isset($produk['gambar']) && $produk['gambar'])
                                            <img src="{{ $produk['gambar'] }}" alt="{{ $produk['nama'] }}">
                                        @else
                                            <img src="{{ asset('images/produk_placeholder.jpg') }}" alt="{{ $produk['nama'] }}">
                                        @endif
                                    </div>
                                    <div class="produk-info">
                                        <h3>{{ $produk['nama'] }}</h3>
                                        <p class="produk-desc">{{ $produk['deskripsi'] ?? 'Ban berkualitas tinggi untuk sepeda motor' }}</p>
                                        <p class="produk-price">{{ $produk['harga'] }}</p>
                                        <button class="detail-btn">Lihat Detail</button>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    @else
                        <!-- Produk Default jika tidak ada data scraping -->
                        <!-- Oli & Pelumas -->
                        <div class="produk-item oli">
                            <div class="produk-card">
                                <div class="produk-image">
                                    <img src="{{ asset('images/oli_mesin.jpg') }}" alt="Oli Mesin Premium">
                                </div>
                                <div class="produk-info">
                                    <h3>Oli Mesin Premium</h3>
                                    <p class="produk-desc">Oli mesin berkualitas tinggi untuk performa optimal sepeda motor Anda</p>
                                    <p class="produk-price">Rp 85.000</p>
                                    <button class="detail-btn">Lihat Detail</button>
                                </div>
                            </div>
                        </div>
                        
                        <div class="produk-item oli">
                            <div class="produk-card">
                                <div class="produk-image">
                                    <img src="{{ asset('images/oli_gardan.jpg') }}" alt="Oli Gardan">
                                </div>
                                <div class="produk-info">
                                    <h3>Oli Gardan</h3>
                                    <p class="produk-desc">Pelumas khusus untuk gardan sepeda motor dengan daya tahan tinggi</p>
                                    <p class="produk-price">Rp 45.000</p>
                                    <button class="detail-btn">Lihat Detail</button>
                                </div>
                            </div>
                        </div>

                        <!-- Sparepart -->
                        <div class="produk-item sparepart">
                            <div class="produk-card">
                                <div class="produk-image">
                                    <img src="{{ asset('images/kampas_rem.jpg') }}" alt="Kampas Rem">
                                </div>
                                <div class="produk-info">
                                    <h3>Kampas Rem Premium</h3>
                                    <p class="produk-desc">Kampas rem berkualitas tinggi untuk pengereman yang responsif</p>
                                    <p class="produk-price">Rp 120.000</p>
                                    <button class="detail-btn">Lihat Detail</button>
                                </div>
                            </div>
                        </div>

                        <div class="produk-item sparepart">
                            <div class="produk-card">
                                <div class="produk-image">
                                    <img src="{{ asset('images/aki_motor.jpg') }}" alt="Aki Motor">
                                </div>
                                <div class="produk-info">
                                    <h3>Aki Motor Tahan Lama</h3>
                                    <p class="produk-desc">Aki motor dengan daya tahan hingga 2 tahun dan performa stabil</p>
                                    <p class="produk-price">Rp 350.000</p>
                                    <button class="detail-btn">Lihat Detail</button>
                                </div>
                            </div>
                        </div>

                        <!-- Aksesoris -->
                        <div class="produk-item aksesoris">
                            <div class="produk-card">
                                <div class="produk-image">
                                    <img src="{{ asset('images/helm.jpg') }}" alt="Helm Racing">
                                </div>
                                <div class="produk-info">
                                    <h3>Helm Racing Premium</h3>
                                    <p class="produk-desc">Helm berkualitas tinggi dengan desain aerodinamis dan nyaman</p>
                                    <p class="produk-price">Rp 750.000</p>
                                    <button class="detail-btn">Lihat Detail</button>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
                
                <div class="produk-cta">
                    <p>Dapatkan produk dan layanan terbaik kami dengan mengunjungi outlet Speed Solution terdekat atau hubungi customer service kami.</p>
                    <button class="cta-button">Hubungi Kami</button>
                </div>
            </div>
            
            <div class="info-section">
                <h3 class="info-heading">Informasi Produk</h3>
                <div class="info-content">
                    <p>Data produk di atas diambil dari ShopAndBike untuk memberikan referensi harga pasar terkini. Untuk informasi lebih lanjut tentang ketersediaan dan spesifikasi produk, silakan hubungi customer service kami atau kunjungi outlet Speed Solution terdekat.</p>
                    
                    <div class="contact-info">
                        <p>Untuk info lebih lanjut bisa hubungi Official :</p>
                        <p>Whatsapp : 08983841072</p>
                    </div>
                    
                    <div class="social-info">
                        <p>Ikuti Official akun media sosial Speed Solution untuk mendapatkan info dan promo terupdate :</p>
                        <p>Instagram : @speedsolution_</p>
                        <p>Facebook : SpeedSolutionsda</p>
                        <p>Tiktok : speedsolution_</p>
                        <p>Website : www.speedsolution.co.id</p>
                    </div>
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

    <script>
        // Fungsi untuk filter produk
        document.addEventListener('DOMContentLoaded', function() {
            const filterButtons = document.querySelectorAll('.filter-btn');
            const produkItems = document.querySelectorAll('.produk-item');
            
            filterButtons.forEach(button => {
                button.addEventListener('click', function() {
                    // Menghapus kelas active dari semua tombol
                    filterButtons.forEach(btn => btn.classList.remove('active'));
                    
                    // Menambahkan kelas active ke tombol yang diklik
                    this.classList.add('active');
                    
                    const filterValue = this.getAttribute('data-filter');
                    
                    produkItems.forEach(item => {
                        if (filterValue === 'all' || item.classList.contains(filterValue)) {
                            item.style.display = 'block';
                        } else {
                            item.style.display = 'none';
                        }
                    });
                });
            });
        });
    </script>
</body>
</html>