@extends('layouts.app')

@section('title', 'Outlet Speed Solution - Temukan Bengkel Motor Terdekat')

@section('content')

{{-- Hero Section --}}
<section class="outlet-hero">
    <img src="{{ asset('images/' . $heroData['background_image']) }}" alt="Outlet Speed Solution">
    <div class="outlet-hero-content">
        <div class="outlet-title">
            <h1>{{ $heroData['title'] }}</h1>
            <h2>{{ $heroData['subtitle'] }}</h2>
            @if(isset($heroData['description']))
                <p>{{ $heroData['description'] }}</p>
            @endif
        </div>
    </div>
</section>

{{-- Main Content --}}
<section class="outlets">
    <div class="container">
        
        {{-- Filter Region --}}
        <div class="outlet-filter">
            <h3>Filter berdasarkan Region:</h3>
            <div class="filter-buttons">
                <button class="filter-btn active" onclick="showAllRegions()">
                    Semua Region ({{ collect($outletsByRegion)->flatten(1)->count() }})
                </button>
                @foreach($outletsByRegion as $region => $outlets)
                    <button class="filter-btn" onclick="showRegion('{{ $region }}')">
                        {{ $region }} ({{ count($outlets) }})
                    </button>
                @endforeach
            </div>
        </div>

        {{-- Outlet Cards per Region --}}
        @foreach($outletsByRegion as $region => $outlets)
            <div class="region-section" data-region="{{ $region }}">
                <h2 class="region-title">{{ $region }}</h2>
                
                <div class="outlet-cards">
                    @foreach($outlets as $outlet)
                        <div class="outlet-card">
                            
                            {{-- Nama Outlet --}}
                            <h3>{{ $outlet['name'] }}</h3>
                            
                            {{-- Info Outlet --}}
                            <div class="outlet-info">
                                {{-- Phone --}}
                                <div class="info-item">
                                    <div class="icon-wrapper">
                                        <img src="{{ asset('images/' . $icons['phone']) }}" alt="Phone" class="info-icon">
                                    </div>
                                    <p>{{ $outlet['phone'] }}</p>
                                </div>
                                
                                {{-- Address --}}
                                <div class="info-item">
                                    <div class="icon-wrapper">
                                        <img src="{{ asset('images/' . $icons['location']) }}" alt="Location" class="info-icon">
                                    </div>
                                    <p>{{ $outlet['address'] }}</p>
                                </div>
                            </div>
                            
                            {{-- Button Arahkan --}}
                            <a href="{{ $outlet['maps_url'] }}" target="_blank" class="btn detail-btn">
                                📍 Arahkan ke Maps
                            </a>
                            
                        </div>
                    @endforeach
                </div>  
            </div>
        @endforeach
        
        {{-- Info Total --}}
        <div class="outlet-summary">
            <p>
                <strong>Total: {{ collect($outletsByRegion)->flatten(1)->count() }} outlet</strong> 
                tersebar di {{ count($outletsByRegion) }} region
            </p>
        </div>
        
    </div>
</section>

{{-- JavaScript untuk Filter --}}
<script>
function showAllRegions() {
    // Tampilkan semua region
    document.querySelectorAll('.region-section').forEach(function(section) {
        section.style.display = 'block';
    });
    
    // Update button active
    document.querySelectorAll('.filter-btn').forEach(function(btn) {
        btn.classList.remove('active');
    });
    document.querySelector('.filter-btn').classList.add('active');
}

function showRegion(region) {
    // Sembunyikan semua region
    document.querySelectorAll('.region-section').forEach(function(section) {
        section.style.display = 'none';
    });
    
    // Tampilkan region yang dipilih
    document.querySelector('[data-region="' + region + '"]').style.display = 'block';
    
    // Update button active
    document.querySelectorAll('.filter-btn').forEach(function(btn) {
        btn.classList.remove('active');
    });
    event.target.classList.add('active');
}
</script>

@include('partials.footer')
@endsection