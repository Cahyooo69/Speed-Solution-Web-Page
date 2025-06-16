@extends('layouts.app')

@section('title', 'Promo Speed Solution - Dapatkan Promo Terbaik')

@section('content')

{{-- Hero Section --}}
<section class="promo-hero">
    <img src="{{ asset('images/' . $heroData['background_image']) }}" alt="{{ $heroData['title'] }} Background">
    <div class="promo-hero-content">
        <div class="promo-title">
            <h1>{{ $heroData['title'] }}</h1>
            <h2>{{ $heroData['subtitle'] }}</h2>
        </div>
    </div>
</section>

{{-- Main Content --}}
<div class="promo-content">
    <div class="container">
        @if($currentPromo['has_promo'])
            {{-- Tampilan Promo Normal --}}
            <div class="current-promo">
                {{-- Header Promo --}}
                <div class="promo-heading">
                    <h2>{{ $currentPromo['title'] }}</h2>
                    <p class="promo-period">Periode Promo : {{ $currentPromo['period'] }}</p>
                </div>
              
                {{-- Deskripsi --}}
                <div class="promo-description">
                    <p>{{ $currentPromo['description'] }}</p>
                </div>

                {{-- Info Lokasi --}}
                <div class="promo-info">
                    <p>{{ $currentPromo['location_info'] }}</p>
                    <p>{{ $currentPromo['terms_note'] }}</p>
                </div>

                {{-- Kontak --}}
                <div class="contact-info">
                    <p>Untuk info lebih lanjut bisa hubungi Official :</p>
                    <p>Whatsapp : {{ $currentPromo['contact']['whatsapp'] }}</p>
                </div>

                {{-- Social Media --}}
                <div class="social-info">
                    <p>Ikut Official akun media sosial Speed Solution untuk mendapatkan info dan promo terupdate :</p>
                    <p>Instagram : {{ $currentPromo['social_media']['instagram'] }}</p>
                    <p>Facebook : {{ $currentPromo['social_media']['facebook'] }}</p>
                    <p>Tiktok : {{ $currentPromo['social_media']['tiktok'] }}</p>
                    <p>Website : {{ $currentPromo['social_media']['website'] }}</p>
                </div>

                {{-- Syarat dan Ketentuan --}}
                <div class="terms-section">
                    <h3 class="terms-heading">Syarat dan Ketentuan</h3>
                    <p>{{ $currentPromo['terms'] }}</p>
                </div>
            </div>
        @else
            {{-- Tampilan Tidak Ada Promo --}}
            <div class="no-promo" style="text-align: center; padding: 50px 20px;">
                <img src="{{ asset('images/' . $currentPromo['image']) }}" alt="No Promo Found" 
                     style="max-width: 300px; width: 100%; height: auto; margin-bottom: 20px;">
                <h3 style="color: #666; margin-bottom: 30px;">{{ $currentPromo['message'] }}</h3>
                
                {{-- Kontak untuk info --}}
                <div class="contact-info" style="margin-top: 40px;">
                    <p>{{ $currentPromo['contact_message'] }}</p>
                    <p><strong>Whatsapp : {{ $currentPromo['contact']['whatsapp'] }}</strong></p>
                </div>

                {{-- Social Media --}}
                <div class="social-info" style="margin-top: 30px;">
                    <p>{{ $currentPromo['social_message'] }}</p>
                    <p>Instagram : {{ $currentPromo['social_media']['instagram'] }}</p>
                    <p>Facebook : {{ $currentPromo['social_media']['facebook'] }}</p>
                    <p>Tiktok : {{ $currentPromo['social_media']['tiktok'] }}</p>
                    <p>Website : {{ $currentPromo['social_media']['website'] }}</p>
                </div>
            </div>
        @endif
    </div>
</div>

@include('partials.footer')
@endsection