<?php

namespace App\Http\Controllers;

use App\Models\Outlet;

class OutletController extends Controller
{
    /**
     * Menampilkan halaman outlet dengan data langsung
     */
    public function index()
    {
        try {
            // Ambil semua data yang dibutuhkan
            $heroData = Outlet::getHeroData();
            $outletsByRegion = Outlet::getAllOutletsByRegion();
            $icons = Outlet::getIcons();
            
            return view('outlet', compact('heroData', 'outletsByRegion', 'icons'));
            
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal memuat halaman outlet');
        }
    }

    // HAPUS method API untuk sekarang atau biarkan saja
    public function apiOutlets()
    {
        try {
            $outletsByRegion = Outlet::getAllOutletsByRegion();
            
            return response()->json([
                'success' => true,
                'data' => $outletsByRegion,
                'message' => 'Data outlet berhasil dimuat'
            ]);
            
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal memuat data outlet'
            ], 500);
        }
    }

    public function getOutletsByRegion($region)
    {
        try {
            $allOutlets = Outlet::getAllOutletsByRegion();
            $outlets = $allOutlets[strtoupper($region)] ?? [];
            
            return response()->json([
                'success' => true,
                'data' => $outlets,
                'region' => strtoupper($region)
            ]);
            
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal memuat data outlet untuk region ' . $region
            ], 500);
        }
    }
}