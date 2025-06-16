<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TentangSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $sections = [
            [
                'section' => 'hero',
                'title' => 'SPEED SOLUTION,',
                'subtitle' => 'Solusi Kilat untuk Motor Hebat!',
                'description' => 'Bawa pengalaman servis motor Anda ke level selanjutnya dengan sistem pemantauan kondisi motor yang canggih, dan harga yang selalu transparan di Bengkel Speed Solution.',
                'image' => 'mekanik_real.png',
                'sort_order' => 1,
                'is_active' => true
            ],
            [
                'section' => 'about',
                'title' => 'SPEED SOLUTION MENTRANSFORMASI LAYANAN PURNA-JUAL OTOMOTIF',
                'content_array' => json_encode([
                    'Indonesia tengah mengalami perkembangan pesat di sektor otomotif, termasuk dalam hal kepemilikan sepeda motor yang semakin meningkat. Meskipun informasi tentang perawatan kendaraan bisa didapatkan dengan mudah melalui internet, masih banyak pengendara motor yang kesulitan dalam mencari bengkel terpercaya dan memahami cara merawat motor mereka dengan tepat.',
                    'Sebagian besar pengendara motor cenderung fokus pada pembelian motor baru, padahal yang lebih penting adalah mengetahui cara merawat dan memperbaiki motor mereka secara berkala. Sayangnya, hingga kini belum ada ekosistem yang menyatukan semua kebutuhan tersebut.',
                    'Dengan Speed Solution, pengendara motor mendapatkan akses mudah ke informasi yang tepat, pelayanan profesional, dan harga yang transparan. Bengkel Speed Solution hadir sebagai one-stop solution untuk perawatan motor yang membawa pengalaman servis ke level berikutnya!'
                ]),
                'sort_order' => 2,
                'is_active' => true
            ],
            [
                'section' => 'vision_mission',
                'title' => 'Visi & Misi',
                'description' => 'Menjadi bengkel motor terpercaya di Indonesia yang menghadirkan layanan perawatan dan perbaikan motor berbasis teknologi, dengan standar transparansi, kecepatan, dan kualitas terbaik bagi setiap pelanggan.',
                'content_array' => json_encode([
                    'Menyediakan layanan servis dan perbaikan motor yang cepat, akurat dan transparan.',
                    'Membangun jaringan bengkel yang profesional, ramah, dan berkompetensi di seluruh Indonesia.',
                    'Memberikan edukasi kepada pelanggan tentang pentingnya perawatan motor secara berkala.',
                    'Terus berinovasi dalam meningkatkan kualitas layanan demi kepuasan dan keselamatan pengendara motor.'
                ]),
                'image' => 'tangan_mockup.png',
                'sort_order' => 3,
                'is_active' => true
            ],
            [
                'section' => 'journey',
                'title' => 'Perjalanan Kami',
                'content' => 'Speed Solution terwujud sebagai implementasi dari cita-cita kami untuk menjadi mitra terpercaya untuk segala kebutuhan otomotif konsumen Indonesia. Kami berkomitmen untuk memajukan industri bengkel dan menciptakan lapangan kerja di Indonesia melalui inovasi teknologi.',
                'sort_order' => 4,
                'is_active' => true
            ]
        ];

        foreach ($sections as $section) {
            DB::table('tentang')->insert($section);
        }
    }
}
