<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Outlet extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'phone', 
        'address',
        'region',
        'maps_url',
        'is_active'
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    /**
     * Data hero section - EDIT DI SINI untuk ubah hero
     */
    public static function getHeroData()
    {
        return [
            'title' => 'Outlet',
            'subtitle' => 'TEMUKAN KAMI DILOKASI TERDEKAT ANDA',
            'background_image' => 'outlet.png',
            'description' => 'Speed Solution hadir di berbagai lokasi strategis untuk melayani kebutuhan service motor Anda'
        ];
    }

    /**
     * Data semua outlet berdasarkan region dari database
     */
    public static function getAllOutletsByRegion()
    {
        $outlets = self::where('is_active', true)->get();
        $groupedOutlets = [];

        foreach ($outlets as $outlet) {
            $groupedOutlets[$outlet->region][] = [
                'name' => $outlet->name,
                'phone' => $outlet->phone,
                'address' => $outlet->address,
                'maps_url' => $outlet->maps_url
            ];
        }

        return $groupedOutlets;
    }

    /**
     * Icons yang digunakan - EDIT DI SINI untuk ganti icon
     */
    public static function getIcons()
    {
        return [
            'phone' => 'phone.png',
            'location' => 'navigation.png'
        ];
    }

    /**
     * Helper method - mendapatkan semua region
     */
    public static function getAllRegions()
    {
        return self::where('is_active', true)
                  ->distinct()
                  ->pluck('region')
                  ->toArray();
    }

    /**
     * Helper method - mendapatkan outlet berdasarkan region
     */
    public static function getOutletsByRegion($region)
    {
        return self::where('region', strtoupper($region))
                  ->where('is_active', true)
                  ->get()
                  ->map(function ($outlet) {
                      return [
                          'name' => $outlet->name,
                          'phone' => $outlet->phone,
                          'address' => $outlet->address,
                          'maps_url' => $outlet->maps_url
                      ];
                  })
                  ->toArray();
    }

    /**
     * Helper method - hitung total outlet
     */
    public static function getTotalOutlets()
    {
        return self::where('is_active', true)->count();
    }

    /**
     * Scope untuk outlet aktif
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope untuk outlet berdasarkan region
     */
    public function scopeByRegion($query, $region)
    {
        return $query->where('region', strtoupper($region));
    }
}