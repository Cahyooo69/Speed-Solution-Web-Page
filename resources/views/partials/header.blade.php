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

<style>
/* CSS untuk dropdown menu */
.dropdown {
    position: relative;
}

.dropdown-toggle {
    cursor: pointer;
}

.dropdown-menu {
    display: none;
    position: absolute;
    right: 0;
    background-color: #fff;
    min-width: 160px;
    box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2);
    z-index: 1;
    border-radius: 4px;
    padding: 8px 0;
}

.dropdown:hover .dropdown-menu {
    display: block;
}

.dropdown-menu a, .dropdown-menu .dropdown-link {
    color: #333;
    padding: 8px 16px;
    text-decoration: none;
    display: block;
    text-align: left;
    background: none;
    border: none;
    width: 100%;
    font-size: 14px;
    cursor: pointer;
}

.dropdown-menu a:hover, .dropdown-menu .dropdown-link:hover {
    background-color: #f1f1f1;
}
</style>