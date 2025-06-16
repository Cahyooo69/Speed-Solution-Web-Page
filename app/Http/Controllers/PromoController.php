<?php

namespace App\Http\Controllers;

use App\Models\Promo;

class PromoController extends Controller
{
    /**
     * Menampilkan halaman promo dengan data langsung
     */
    public function index()
    {
        try {
            // Ambil semua data yang dibutuhkan
            $heroData = Promo::getHeroData();
            $currentPromo = Promo::getCurrentPromo();
            
            return view('promo', compact('heroData', 'currentPromo'));
            
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal memuat halaman promo');
        }
    }
}