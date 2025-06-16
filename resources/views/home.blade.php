@extends('layouts.app')

@section('title', 'Speed Solution - Bengkel Motor Terpercaya')

@section('content')
    {{-- Hero Section --}}
    <section class="hero">
        <div class="container">
            <div class="hero-content">
                <div class="hero-text">
                    @auth
                        <div class="welcome-message">
                            <h3>Selamat datang, {{ Auth::user()->name }}!</h3>
                            <p>Terima kasih telah bergabung dengan Speed Solution</p>
                        </div>
                    @endauth
                    <h1>Service Motor to The Next Level dengan Speed Solution!</h1>
                    <div class="info-box">
                        <h3>Motor Kamu Bermasalah?</h3>
                        <p>Dapatkan Solusi Terbaik bersama Speed Consultant.</p>
                        <a href="{{ url('/outlet') }}" class="btn">Cek Lokasi Kami</a>
                    </div>
                </div>
                <div class="workshop-images">
                    <img src="{{ asset('images/workshop.png') }}" alt="Speed Solution Workshop">
                </div>
            </div>
        </div>
    </section>    {{-- Services & Testimonials Section - Vue Component --}}
    <home-content></home-content>

    @include('partials.partners')
    @include('partials.footer')
@endsection