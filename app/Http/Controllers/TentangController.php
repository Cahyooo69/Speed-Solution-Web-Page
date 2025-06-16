<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Tentang;

class TentangController extends Controller
{
    /**
     * Menampilkan halaman tentang
     */
    public function index()
    {
        try {
            // Ambil data hero section
            $heroData = Tentang::getHeroData();
            
            // Ambil data about section
            $aboutData = Tentang::getAboutData();
            
            // Ambil data visi misi
            $visionMissionData = Tentang::getVisionMissionData();
            
            // Ambil data journey
            $journeyData = Tentang::getJourneyData();
            
            return view('tentang', compact('heroData', 'aboutData', 'visionMissionData', 'journeyData'));
            
        } catch (\Exception $e) {
            return back()->withError('Gagal memuat halaman tentang: ' . $e->getMessage());
        }
    }

    /**
     * API: Get tentang data for Vue.js
     */
    public function apiTentang()
    {
        try {
            $data = [
                'hero' => Tentang::getHeroData(),
                'about' => Tentang::getAboutData(),
                'visionMission' => Tentang::getVisionMissionData(),
                'journey' => Tentang::getJourneyData()
            ];
            
            return response()->json([
                'success' => true,
                'data' => $data
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal memuat data tentang',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}