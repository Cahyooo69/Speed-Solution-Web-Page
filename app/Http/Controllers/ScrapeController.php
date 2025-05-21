<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Browsershot\Browsershot;
use Symfony\Component\DomCrawler\Crawler;

class ScrapeController extends Controller
{
    public function scrape()
    {
        try {
            $html = Browsershot::url('https://www.shopandbike.co.id/produk?category=Ban')
                ->setNodeBinary('C:\Program Files\nodejs\node.exe')
                ->userAgent('Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/120.0.0.0 Safari/537.36')
                ->waitUntilNetworkIdle()
                ->timeout(60)
                ->bodyHtml();

            file_put_contents(storage_path('app/html-dump.html'), $html);

            //analisis HTML dump yang berhasil di dapatkan
            $dumpHtml = file_get_contents(storage_path('app/html-dump.html'));
            
            // Jika tidak bisa mengakses file dump, gunakan HTML hasil scraping
            if (!$dumpHtml) {
                $dumpHtml = $html;
            }
            
            $crawler = new Crawler($dumpHtml);

            $produkList = $crawler->filter('div.card-body')->each(function (Crawler $node) {
                // ambil nama produk
                $nama = $node->filter('div.p-4 a.fs-3')->count() 
                    ? trim($node->filter('div.p-4 a.fs-3')->text()) 
                    : 'Nama tidak ditemukan';
                
                // ambil harga produk
                $harga = $node->filter('div.text-right p.fs-3')->count() 
                    ? trim($node->filter('div.text-right p.fs-3')->text()) 
                    : 'Harga tidak ditemukan';
                
                // ambil URL gambar
                $gambar = null;
                
                // PENDEKATAN BARU: Parse background-image dengan DOMXPath
                if ($node->filter('img.image-product')->count()) {
                    $styleAttr = $node->filter('img.image-product')->attr('style');
                    
                    // Ekstrak URL menggunakan regex yang diperbarui untuk HTML yang Anda berikan
                    if (preg_match('/background-image:\s*url\((.*?)\)/', $styleAttr, $matches)) {
                        $gambar = trim($matches[1], '"\'');
                        
                        // Pastikan URL adalah absolut
                        if ($gambar && strpos($gambar, 'http') !== 0) {
                            $gambar = 'https://www.shopandbike.co.id' . $gambar;
                        }
                    }
                }
                
                // Jika masih tidak ada URL gambar, gunakan link anchor sebagai alternatif
                if (!$gambar && $node->filter('.image-product-wrapper a')->count()) {
                    $productUrl = $node->filter('.image-product-wrapper a')->attr('href');
                    // Ekstrak ID produk/slug dari URL
                    $urlParts = explode('/', $productUrl);
                    $slug = end($urlParts);
                    // Gunakan sebagai gambar placeholder
                    $gambar = 'https://via.placeholder.com/300x200?text=' . substr($slug, 0, 20);
                }
                
                // Jika masih tidak bisa, gunakan gambar placeholder default
                if (!$gambar) {
                    $gambar = asset('images/produk_placeholder.jpg');
                }
                
                // Mengambil deskripsi dan info produk
                $deskripsi = $node->filter('div.p-4 p.fs-2')->count() 
                    ? trim($node->filter('div.p-4 p.fs-2')->text()) 
                    : '';
                
                $infoTambahan = $node->filter('p.fs-2.w-50')->count() 
                    ? trim($node->filter('p.fs-2.w-50')->text()) 
                    : '';
                
                // Gabungkan deskripsi dan info tambahan
                $deskripsiLengkap = $deskripsi;
                if ($infoTambahan) {
                    $deskripsiLengkap .= ($deskripsiLengkap ? ' - ' : '') . $infoTambahan;
                }
                
                // Jika deskripsi kosong, berikan default
                if (!$deskripsiLengkap) {
                    $deskripsiLengkap = 'Ban berkualitas tinggi untuk sepeda motor';
                }
                
                // Kategori ban
                $kategori = 'ban';
                
                return [
                    'nama' => $nama,
                    'harga' => $harga,
                    'gambar' => $gambar,
                    'deskripsi' => $deskripsiLengkap,
                    'kategori' => $kategori
                ];
            });

            return view('produk', ['produkList' => $produkList]);
        } catch (\Exception $e) {
            // Log error untuk debugging
            file_put_contents(storage_path('app/scrape-error.log'), date('Y-m-d H:i:s') . ': ' . $e->getMessage() . "\n" . $e->getTraceAsString());
            
            return view('produk', ['error' => $e->getMessage()]);
        }
    }
}