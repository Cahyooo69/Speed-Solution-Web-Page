<!-- resources/views/partials/header.blade.php -->
<!-- Navigation -->
<nav class="navbar">
    <div class="container">
        <a href="{{ route('home') }}" class="navbar-brand">
            <img src="{{ asset('images/speedsolution_logo.png') }}" alt="Speed Solution Logo">
        </a>
        <ul class="nav-menu">
            <li><a href="{{ route('promo') }}">Promo</a></li>
            <li><a href="{{ route('produk') }}">Produk</a></li>
            <li><a href="{{ route('outlet') }}">Outlet</a></li>
            <li><a href="{{ route('tentang') }}">Tentang</a></li>
            @auth
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle">{{ Auth::user()->name }}</a>
                    <div class="dropdown-menu">
                        @if(Auth::user()->email === 'admin@gmail.com')
                            <a href="{{ route('admin.chat') }}" class="dropdown-link">Admin Dashboard</a>
                        @endif
                        <form action="{{ route('logout') }}" method="POST">
                            @csrf
                            <button type="submit" class="dropdown-link">Logout</button>
                        </form>
                    </div>
                </li>
            @else
                <li><a href="{{ route('login') }}">Login</a></li>
            @endauth
        </ul>
    </div>
</nav>