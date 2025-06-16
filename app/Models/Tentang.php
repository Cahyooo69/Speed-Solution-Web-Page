<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Tentang extends Model
{
    use HasFactory;

    protected $table = 'tentang';
    
    protected $fillable = [
        'section',
        'title',
        'subtitle', 
        'description',
        'content',
        'content_array',
        'image',
        'is_active',
        'sort_order'
    ];

    protected $casts = [
        'content_array' => 'array',
        'is_active' => 'boolean',
    ];

    // Method untuk mendapatkan data hero section
    public static function getHeroData()
    {
        $hero = self::where('section', 'hero')->where('is_active', true)->first();
        
        if (!$hero) {
            // Fallback ke data default jika tidak ada di database
            return [
                'title' => 'SPEED SOLUTION,',
                'subtitle' => 'Solusi Kilat untuk Motor Hebat!',
                'description' => 'Bawa pengalaman servis motor Anda ke level selanjutnya dengan sistem pemantauan kondisi motor yang canggih, dan harga yang selalu transparan di Bengkel Speed Solution.',
                'image' => 'mekanik_real.png'
            ];
        }

        return [
            'title' => $hero->title,
            'subtitle' => $hero->subtitle,
            'description' => $hero->description,
            'image' => $hero->image
        ];
    }

    // Method untuk mendapatkan data about section
    public static function getAboutData()
    {
        $about = self::where('section', 'about')->where('is_active', true)->first();
        
        if (!$about) {
            // Fallback ke data default
            return [
                'title' => 'SPEED SOLUTION MENTRANSFORMASI LAYANAN PURNA-JUAL OTOMOTIF',
                'content' => [
                    'Indonesia tengah mengalami perkembangan pesat di sektor otomotif, termasuk dalam hal kepemilikan sepeda motor yang semakin meningkat. Meskipun informasi tentang perawatan kendaraan bisa didapatkan dengan mudah melalui internet, masih banyak pengendara motor yang kesulitan dalam mencari bengkel terpercaya dan memahami cara merawat motor mereka dengan tepat.',
                    'Sebagian besar pengendara motor cenderung fokus pada pembelian motor baru, padahal yang lebih penting adalah mengetahui cara merawat dan memperbaiki motor mereka secara berkala. Sayangnya, hingga kini belum ada ekosistem yang menyatukan semua kebutuhan tersebut.',
                    'Dengan Speed Solution, pengendara motor mendapatkan akses mudah ke informasi yang tepat, pelayanan profesional, dan harga yang transparan. Bengkel Speed Solution hadir sebagai one-stop solution untuk perawatan motor yang membawa pengalaman servis ke level berikutnya!'
                ]
            ];
        }

        return [
            'title' => $about->title,
            'content' => $about->content_array ?? []
        ];
    }

    // Method untuk mendapatkan data visi misi
    public static function getVisionMissionData()
    {
        $visionMission = self::where('section', 'vision_mission')->where('is_active', true)->first();
        
        if (!$visionMission) {
            // Fallback ke data default
            return [
                'vision' => 'Menjadi bengkel motor terpercaya di Indonesia yang menghadirkan layanan perawatan dan perbaikan motor berbasis teknologi, dengan standar transparansi, kecepatan, dan kualitas terbaik bagi setiap pelanggan.',
                'mission' => [
                    'Menyediakan layanan servis dan perbaikan motor yang cepat, akurat dan transparan.',
                    'Membangun jaringan bengkel yang profesional, ramah, dan berkompetensi di seluruh Indonesia.',
                    'Memberikan edukasi kepada pelanggan tentang pentingnya perawatan motor secara berkala.',
                    'Terus berinovasi dalam meningkatkan kualitas layanan demi kepuasan dan keselamatan pengendara motor.'
                ],
                'image' => 'tangan_mockup.png'
            ];
        }

        return [
            'vision' => $visionMission->description,
            'mission' => $visionMission->content_array ?? [],
            'image' => $visionMission->image
        ];
    }

    // Method untuk mendapatkan data journey
    public static function getJourneyData()
    {
        $journey = self::where('section', 'journey')->where('is_active', true)->first();
        
        if (!$journey) {
            // Fallback ke data default
            return [
                'title' => 'Perjalanan Kami',
                'content' => 'Speed Solution terwujud sebagai implementasi dari cita-cita kami untuk menjadi mitra terpercaya untuk segala kebutuhan otomotif konsumen Indonesia. Kami berkomitmen untuk memajukan industri bengkel dan menciptakan lapangan kerja di Indonesia melalui inovasi teknologi.'
            ];
        }

        return [
            'title' => $journey->title,
            'content' => $journey->content
        ];
    }

    // Scope untuk section aktif
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    // Scope untuk section tertentu
    public function scopeBySection($query, $section)
    {
        return $query->where('section', $section);
    }
}
