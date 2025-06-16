<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Home extends Model
{
    protected $fillable = [
        'type',
        'image',
        'title',
        'name',
        'price',
        'role',
        'description',
        'message'
    ];
    
    // Method untuk mendapatkan semua services
    public static function getAllServices()
    {
        return [
            [
                'image' => 'gantioli.png',
                'title' => 'Oli',
                'price' => 'Rp. 50.000/Liter',
                'description' => 'Ganti oli + gratis jasa penggantian'
            ],
            [
                'image' => 'rem.png',
                'title' => 'Rem',
                'price' => 'Rp. 40.000',
                'description' => 'Jaga kondisi rem agar aman berkendara'
            ],
            [
                'image' => 'detailing.png',
                'title' => 'Detailing',
                'price' => 'Rp. 50.000',
                'description' => 'Bikin cat motor kamu kembali kinclong'
            ],
            [
                'image' => 'tuneup.png',
                'title' => 'Tune Up',
                'price' => 'Rp. 90.000',
                'description' => 'Tune up rutin untuk mengembalikan tenaga maksimal'
            ]
        ];
    }
    
    // Method untuk mendapatkan semua testimonials
    public static function getAllTestimonials()
    {
        return [
            [
                'image' => 'ilham.png',
                'name' => 'Ilham Nurcahyo',
                'role' => 'Mahasiswa - Sidoarjo',
                'message' => 'Hasil servicenya rapi dan cepet banget, sangat cocok buat kalian yang suka modifikasi motor juga, di Speed Solution ini juga banyak sparepart variasi yang bagus dan berkualitas'
            ],
            [
                'image' => 'farhan.png',
                'name' => 'Farhan Maheswara',
                'role' => 'Mahasiswa - Surabaya',
                'message' => 'Modif motor jadi makin gampang bareng Speed Solution! Servis cepat, hasil rapi, dan pilihan sparepart variasi yang lengkap serta berkualitas tinggi. Cocok banget buat kamu yang ingin tampil beda dan tetap nyaman di jalan!'
            ],
            [
                'image' => 'daud.png',
                'name' => 'Daud Rizal',
                'role' => 'Driver Ojek - Gresik',
                'message' => 'Driver ojek? Wajib coba Speed Solution! Servis motor jadi cepat, hasil rapi, dan banyak pilihan sparepart berkualitas. Gak perlu antri lama, motor kamu selalu siap ngebut cari orderan!'
            ]
        ];
    }
    
    // Method untuk mendapatkan semua data home (services + testimonials)
    public static function getHomeData()
    {
        return [
            'services' => self::getAllServices(),
            'testimonials' => self::getAllTestimonials()
        ];
    }
}