<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class LoginController extends Controller
{
    /**
     * Menampilkan halaman login
     */
    public function index()
    {
        try {
            // Jika user sudah login, redirect ke home
            if (Auth::check()) {
                return redirect()->route('home');
            }
            
            return $this->renderView('login');
        } catch (\Exception $e) {
            return $this->handleException($e, 'Gagal memuat halaman login');
        }
    }

    /**
     * API untuk mendapatkan data login (untuk Vue.js)
     */
    public function apiLogin()
    {
        try {
            $formData = [
                'title' => 'Masuk ke Akun Anda',
                'subtitle' => 'Silakan masuk untuk melanjutkan',
                'logo' => 'speedsolution_logo.png', // Tambah comma yang hilang
                'google_icon' => 'google.png', // Update menggunakan google.png
                'form_fields' => [
                    'email' => [
                        'label' => 'Email',
                        'type' => 'email',
                        'required' => true,
                        'placeholder' => 'Masukkan email Anda'
                    ],
                    'password' => [
                        'label' => 'Password',
                        'type' => 'password',
                        'required' => true,
                        'placeholder' => 'Masukkan password Anda'
                    ]
                ],
                'links' => [
                    'forgot_password' => 'Lupa Password?',
                    'register' => 'Belum punya akun?',
                    'register_link' => 'Daftar Sekarang'
                ]
            ];
            
            return $this->sendResponse([
                'formData' => $formData,
                'isLoggedIn' => Auth::check(),
                'user' => Auth::user()
            ], 'Login data loaded successfully');
            
        } catch (\Exception $e) {
            return $this->sendError('Gagal memuat data login: ' . $e->getMessage(), null, 500);
        }
    }

    /**
     * Proses login via API
     */
    public function apiLoginSubmit(Request $request)
    {
        try {
            $validated = $request->validate([
                'email' => 'required|email',
                'password' => 'required|string|min:8',
                'remember' => 'boolean'
            ], [
                'email.required' => 'Email wajib diisi',
                'email.email' => 'Format email tidak valid',
                'password.required' => 'Password wajib diisi',
                'password.min' => 'Password minimal 8 karakter',
            ]);

            $credentials = [
                'email' => $validated['email'],
                'password' => $validated['password']
            ];

            $remember = $request->boolean('remember', false);

            if (Auth::attempt($credentials, $remember)) {
                $request->session()->regenerate();
                
                $user = Auth::user();
                
                // Redirect admin ke dashboard chat
                $redirectUrl = $user->email === 'admin@gmail.com' ? route('admin.chat') : route('home');
                
                return $this->sendResponse([
                    'user' => $user,
                    'redirect' => $redirectUrl
                ], 'Login berhasil! Selamat datang ' . $user->name);
            }

            return $this->sendError('Email atau password salah', null, 422);
            
        } catch (ValidationException $e) {
            return $this->sendError('Validation error', $e->errors(), 422);
        } catch (\Exception $e) {
            return $this->sendError('Terjadi kesalahan saat login: ' . $e->getMessage(), null, 500);
        }
    }

    /**
     * Proses login (untuk form submission biasa)
     */
    public function login(Request $request)
    {
        try {
            $validated = $request->validate([
                'email' => 'required|email',
                'password' => 'required|string|min:8',
                'remember' => 'boolean'
            ], [
                'email.required' => 'Email wajib diisi',
                'email.email' => 'Format email tidak valid',
                'password.required' => 'Password wajib diisi',
                'password.min' => 'Password minimal 8 karakter',
            ]);

            $credentials = [
                'email' => $validated['email'],
                'password' => $validated['password']
            ];

            $remember = $request->boolean('remember', false);

            if (Auth::attempt($credentials, $remember)) {
                $request->session()->regenerate();
                
                $user = Auth::user();
                
                // Redirect admin ke dashboard chat
                if ($user->email === 'admin@gmail.com') {
                    return redirect()->route('admin.chat')
                        ->with('success', 'Selamat datang Admin, ' . $user->name);
                }
                
                return redirect()->intended(route('home'))
                    ->with('success', 'Selamat datang, ' . $user->name);
            }

            throw ValidationException::withMessages([
                'email' => 'Email atau password salah'
            ]);
            
        } catch (ValidationException $e) {
            throw $e;
        } catch (\Exception $e) {
            return $this->handleException($e, 'Terjadi kesalahan saat login');
        }
    }

    /**
     * Logout user
     */
    public function logout(Request $request)
    {
        try {
            Auth::logout();
            
            $request->session()->invalidate();
            $request->session()->regenerateToken();
            
            if ($request->expectsJson()) {
                return $this->sendResponse(null, 'Logout berhasil');
            }
            
            return redirect()->route('home')
                ->with('success', 'Anda telah berhasil logout');
                
        } catch (\Exception $e) {
            return $this->handleException($e, 'Terjadi kesalahan saat logout');
        }
    }

    /**
     * Check authentication status (API)
     */
    public function checkAuth()
    {
        return $this->sendResponse([
            'isAuthenticated' => Auth::check(),
            'user' => Auth::user()
        ], 'Authentication status checked');
    }
}