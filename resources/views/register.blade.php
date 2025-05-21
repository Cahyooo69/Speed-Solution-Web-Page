<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register Speed Solution - Platform Bengkel Digital Terpercaya</title>
    <link rel="stylesheet" href="{{ asset('css/register.css') }}">
</head>
<body>
    @include('partials.header')

    <!-- Register Content -->
    <section class="register-content">
        <div class="register-container">
            <div class="register-image">
                <img src="{{ asset('images/speedsolution_logo.png') }}" alt="Speed Solution Logo">
            </div>
            <div class="register-form">
                <div class="form-header">
                    <h1>Daftar Member</h1>
                </div>
                @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
                @endif
                <form action="{{ route('register.post') }}" method="post">
                    @csrf
                    <div class="form-group">
                        <label for="nama">Nama Lengkap</label>
                        <input type="text" id="nama" name="nama" value="{{ old('nama') }}" required>
                    </div>
                    <div class="form-group">
                        <label for="telpon">Telpon</label>
                        <input type="tel" id="telpon" name="telpon" value="{{ old('telpon') }}" required>
                    </div>
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" id="email" name="email" value="{{ old('email') }}" required>
                    </div>
                    <div class="form-group">
                        <label for="password">Password</label>
                        <input type="password" id="password" name="password" required>
                    </div>
                    <button type="submit" class="register-btn">Daftar</button>
                    <div class="form-divider">
                        <span>Atau daftar dengan</span>
                    </div>
                    <button type="button" class="google-btn">
                        <img src="{{ asset('images/google.png') }}" alt="Google Icon">
                        Daftar dengan Google
                    </button>
                    <div class="login-link">
                        <p>Sudah punya akun? <a href="{{ route('login') }}">Masuk</a></p>
                    </div>
                </form>
            </div>
        </div>
    </section>
</body>
</html>