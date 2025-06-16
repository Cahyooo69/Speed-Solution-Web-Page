<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Home;

class HomeController extends Controller
{
    public function index()
    {
        try {
            $homeData = Home::getHomeData();
            $services = $homeData['services'];
            $testimonials = $homeData['testimonials'];
            
            return view('home', compact('services', 'testimonials'));
            
        } catch (\Exception $e) {
            // Fallback data jika error
            $services = [];
            $testimonials = [];
            
            return view('home', compact('services', 'testimonials'))
                ->with('error', 'Gagal memuat data beranda');
        }
    }
    
    // API untuk Services
    public function apiServices()
    {
        try {
            $services = Home::getAllServices();
            return response()->json($services);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to load services'], 500);
        }
    }
    
    // API untuk Testimonials
    public function apiTestimonials()
    {
        try {
            $testimonials = Home::getAllTestimonials();
            return response()->json($testimonials);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to load testimonials'], 500);
        }
    }
}