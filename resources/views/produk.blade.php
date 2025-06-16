@extends('layouts.app')

@section('title', 'Produk Speed Solution - Produk Motor Berkualitas')

@section('content')
{{-- Produk Hero Section --}}
<section class="produk-hero">
    <img src="{{ asset('images/produk.png') }}" alt="Produk Speed Solution">
    <div class="produk-hero-content">
        <div class="produk-title">
            <h1>Produk</h1>
            <h2>TEMUKAN PRODUK MOTOR BERKUALITAS UNTUK KENDARAAN ANDA</h2>
        </div>
    </div>
</section>

{{-- Vue.js Mount Point --}}
<div id="app">
    <product-search></product-search>
</div>

@include('partials.footer')
@endsection