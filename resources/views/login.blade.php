
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Speed Solution - Platform Bengkel Digital Terpercaya</title>
    <link rel="stylesheet" href="{{ asset('css/login.css') }}">
</head>
<body>
    @include('partials.header')

    <!-- Login Content -->
    <section class="login-content">
        <div class="login-container">
            <div class="login-image">
                <img src="{{ asset('images/speedsolution_logo.png') }}" alt="Speed Solution Logo">
            </div>
            <div class="login-form">
                <div class="form-header">
                    <h1>Selamat datang di Speed Solution</h1>
                </div>
                
                @if (session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
                @endif
                
                @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
                @endif
                <form action="{{ route('login.post') }}" method="post">
                    @csrf
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" id="email" name="email" value="{{ old('email') }}" required>
                    </div>
                    <div class="form-group">
                        <label for="password">Password</label>
                        <input type="password" id="password" name="password" required>
                    </div>
                    <div class="form-actions">
                        <a href="#" class="forgot-password">Lupa Password?</a>
                        <button type="submit" class="login-btn">Login</button>
                    </div>
                    <div class="form-divider">
                        <span>Atau masuk dengan</span>
                    </div>
                    <button type="button" class="google-btn">
                        <img src="{{ asset('images/google.png') }}" alt="Google Icon">
                        Login dengan Google
                    </button>
                    <div class="register-link">
                        <p>Belum punya akun? <a href="{{ url('/register') }}">Daftar</a></p>
                    </div>
                </form>
            </div>
        </div>
    </section>
    
    <style>
    .alert {
        padding: 15px;
        margin-bottom: 20px;
        border: 1px solid transparent;
        border-radius: 4px;
    }
    
    .alert-success {
        color: #155724;
        background-color: #d4edda;
        border-color: #c3e6cb;
    }
    
    .alert-danger {
        color: #721c24;
        background-color: #f8d7da;
        border-color: #f5c6cb;
    }
    
    .alert ul {
        margin: 0;
        padding-left: 20px;
    }
    </style>
</body>
</html>