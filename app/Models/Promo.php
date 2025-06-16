<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Promo extends Model
{
    protected $fillable = ['title', 'period', 'description', 'terms', 'is_active'];

    /**
     * Data kontak default - mudah diedit di sini
     */
    private static function getDefaultContact()
    {
        return [
            'whatsapp' => '08983841072'
        ];
    }

    /**
     * Data social media default - mudah diedit di sini
     */
    private static function getDefaultSocialMedia()
    {
        return [
            'instagram' => '@speedsolution_',
            'facebook' => 'SpeedSolutionsda', 
            'tiktok' => 'speedsolution_',
            'website' => 'www.speedsolution.co.id'
        ];
    }

    /**
     * Data hero section - mudah diedit di sini
     */
    public static function getHeroData()
    {
        return [
            'title' => 'Promo',
            'subtitle' => 'Dapatkan dan Nikmati Promo Terbaik dari Kami',
            'background_image' => 'promo.png'
        ];
    }

    /**
     * Data ketika tidak ada promo
     */
    private static function getNoPromoData()
    {
        return [
            'title' => 'Belum Ada Promo',
            'message' => 'Yaaah... masih belum ada promo untuk bulan ini 😢',
            'image' => 'not_found_kartun.png',
            'contact' => self::getDefaultContact(),
            'social_media' => self::getDefaultSocialMedia(),
            'contact_message' => 'Tapi jangan khawatir! Untuk info promo terbaru bisa hubungi :',
            'social_message' => 'Follow media sosial kami untuk update promo terbaru :',
            'has_promo' => false
        ];
    }

    /**
     * Data promo saat ini - SEKARANG DARI DATABASE
     */
    public static function getCurrentPromo()
    {
        // Coba ambil dari database dulu
        $promo = self::where('is_active', true)->first();
        
        // Jika ada di database, pakai itu
        if ($promo) {
            return [
                'title' => $promo->title,
                'period' => $promo->period,
                'description' => $promo->description,
                'location_info' => '📍 Berlaku di semua outlet Speed Solution',
                'terms_note' => '*) Syarat & Ketentuan Berlaku',
                'contact' => self::getDefaultContact(),
                'social_media' => self::getDefaultSocialMedia(),
                'terms' => $promo->terms,
                'has_promo' => true
            ];
        }
        
        // Jika tidak ada, return data "tidak ada promo"
        return self::getNoPromoData();
    }

    public static function getActivePromo()
    {
        $promo = self::where('is_active', true)->first();
        
        if ($promo) {
            return [
                'title' => $promo->title,
                'period' => $promo->period,
                'status' => 'active'
            ];
        }
        
        return [
            'title' => 'No Active Promo',
            'period' => '-',
            'status' => 'inactive'
        ];
    }

    public static function getAllPromos()
    {
        return [
            self::getCurrentPromo()
        ];
    }
}