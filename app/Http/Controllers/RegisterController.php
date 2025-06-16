<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rules\Password;
use Illuminate\Validation\ValidationException;

class RegisterController extends Controller
{
    /**
     * Menampilkan halaman register
     */
    public function index()
    {
        try {
            // Jika user sudah login, redirect ke home
            if (Auth::check()) {
                return redirect()->route('home');
            }
            
            return $this->renderView('register');
        } catch (\Exception $e) {
            return $this->handleException($e, 'Gagal memuat halaman register');
        }
    }    /**
     * API untuk mendapatkan data register (untuk Vue.js)
     */
    public function apiRegister()
    {
        try {
            $formData = $this->getFormData();
            
            return $this->sendResponse([
                'formData' => $formData,
                'isLoggedIn' => Auth::check(),
                'user' => Auth::user()
            ], 'Register data loaded successfully');
            
        } catch (\Exception $e) {
            return $this->sendError('Gagal memuat data register: ' . $e->getMessage(), null, 500);
        }
    }

    /**
     * Proses registrasi via API
     */
    public function apiRegisterSubmit(Request $request)
    {
        try {
            $validated = $request->validate([
                'name' => 'required|string|min:2|max:255',
                'email' => 'required|email|unique:users,email|max:255',
                'phone' => 'required|string|min:10|max:15|regex:/^[0-9+\-\s()]+$/',
                'password' => ['required', 'string', 'min:8', 'confirmed'],
            ], [
                'name.required' => 'Nama lengkap wajib diisi',
                'name.min' => 'Nama minimal 2 karakter',
                'email.required' => 'Email wajib diisi',
                'email.email' => 'Format email tidak valid',
                'email.unique' => 'Email sudah terdaftar',
                'phone.required' => 'Nomor telepon wajib diisi',
                'phone.regex' => 'Format nomor telepon tidak valid',
                'password.required' => 'Password wajib diisi',
                'password.min' => 'Password minimal 8 karakter',
                'password.confirmed' => 'Konfirmasi password tidak sesuai',
            ]);

            // Buat user baru menggunakan Model Register
            $result = $this->createUser($validated);

            if ($result['success']) {
                // Redirect ke login setelah register berhasil (tanpa auto login)
                return $this->sendResponse([
                    'user' => $result['user'],
                    'redirect_url' => route('login'),
                    'success_message' => $result['message'] . '. Silakan login untuk melanjutkan.'
                ], $result['message']);
            } else {
                return $this->sendError($result['message'], null, 422);
            }
            
        } catch (ValidationException $e) {
            return $this->sendError('Validation error', $e->errors(), 422);
        } catch (\Exception $e) {
            return $this->sendError('Terjadi kesalahan saat registrasi: ' . $e->getMessage(), null, 500);
        }
    }

    /**
     * Proses registrasi (untuk form submission biasa)
     */
    public function register(Request $request)
    {
        try {
            $validated = $request->validate([
                'name' => 'required|string|min:2|max:255',
                'email' => 'required|email|unique:users,email|max:255',
                'phone' => 'required|string|min:10|max:15|regex:/^[0-9+\-\s()]+$/',
                'password' => ['required', 'string', 'min:8', 'confirmed'],
            ], [
                'name.required' => 'Nama lengkap wajib diisi',
                'name.min' => 'Nama minimal 2 karakter',
                'email.required' => 'Email wajib diisi',
                'email.email' => 'Format email tidak valid',
                'email.unique' => 'Email sudah terdaftar',
                'phone.required' => 'Nomor telepon wajib diisi',
                'phone.regex' => 'Format nomor telepon tidak valid',
                'password.required' => 'Password wajib diisi',
                'password.min' => 'Password minimal 8 karakter',
                'password.confirmed' => 'Konfirmasi password tidak sesuai',
            ]);

            // Buat user baru menggunakan Model Register
            $result = $this->createUser($validated);

            if ($result['success']) {
                // Redirect ke login setelah register berhasil (tanpa auto login)
                return redirect()->route('login')
                    ->with('success', $result['message'] . '. Silakan login untuk melanjutkan.');
            } else {
                return back()->withErrors(['general' => $result['message']])->withInput();
            }
            
        } catch (ValidationException $e) {
            throw $e;
        } catch (\Exception $e) {
            return $this->handleException($e, 'Terjadi kesalahan saat registrasi');
        }
    }

    /**
     * Get registration statistics (API endpoint)
     */
    public function getStats()
    {
        try {
            $stats = $this->getRegistrationStats();
            
            return $this->sendResponse($stats, 'Registration statistics retrieved successfully');
            
        } catch (\Exception $e) {
            return $this->sendError('Gagal memuat statistik registrasi: ' . $e->getMessage(), null, 500);
        }
    }

    /**
     * Get form data untuk register
     */
    private function getFormData()
    {
        return [
            'title' => 'Daftar Member',
            'subtitle' => 'Bergabunglah dengan Speed Solution',
            'logo' => 'speedsolution_logo.png',
            'google_icon' => 'google.png',
            'form_fields' => [
                'nama' => [
                    'label' => 'Nama Lengkap',
                    'type' => 'text',
                    'required' => true,
                    'placeholder' => 'Masukkan nama lengkap Anda'
                ],
                'telpon' => [
                    'label' => 'Nomor Telepon',
                    'type' => 'tel',
                    'required' => true,
                    'placeholder' => 'Masukkan nomor telepon Anda'
                ],
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
                    'placeholder' => 'Masukkan password minimal 8 karakter'
                ]
            ],
            'links' => [
                'google_register' => 'Daftar dengan Google',
                'login' => 'Sudah punya akun?',
                'login_link' => 'Masuk Sekarang'
            ]
        ];
    }

    /**
     * Create user helper method
     */
    private function createUser($data)
    {
        try {
            // Cek apakah email sudah ada
            if (User::where('email', $data['email'])->exists()) {
                return [
                    'success' => false,
                    'message' => 'Email sudah terdaftar'
                ];
            }

            // Buat user baru
            $user = User::create([
                'name' => $data['name'],
                'email' => $data['email'],
                'phone' => $data['phone'],
                'password' => Hash::make($data['password'])
            ]);

            return [
                'success' => true,
                'user' => $user,
                'message' => 'Registrasi berhasil! Selamat datang ' . $user->name
            ];

        } catch (\Exception $e) {
            return [
                'success' => false,
                'message' => 'Gagal membuat akun: ' . $e->getMessage()
            ];
        }
    }

    /**
     * Get registration statistics
     */
    private function getRegistrationStats()
    {
        $currentMonth = User::whereMonth('created_at', now()->month)
                           ->whereYear('created_at', now()->year)
                           ->count();
        
        $lastMonth = User::whereMonth('created_at', now()->subMonth()->month)
                        ->whereYear('created_at', now()->subMonth()->year)
                        ->count();

        $growthRate = 0;
        if ($lastMonth > 0) {
            $growthRate = round((($currentMonth - $lastMonth) / $lastMonth) * 100, 2);
        } elseif ($currentMonth > 0) {
            $growthRate = 100;
        }

        return [
            'total_users' => User::count(),
            'users_this_month' => $currentMonth,
            'users_today' => User::whereDate('created_at', today())->count(),
            'growth_rate' => $growthRate
        ];
    }
}