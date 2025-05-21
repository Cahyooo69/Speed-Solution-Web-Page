<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Browsershot\Browsershot;
use Symfony\Component\DomCrawler\Crawler;

class LandingController extends Controller
{
    public function showProduk()
    {
        try {
            $html = Browsershot::url('https://www.shopandbike.co.id/produk?category=Ban')
                ->setNodeBinary('C:\Program Files\nodejs\node.exe')
                ->waitUntilNetworkIdle()
                ->timeout(60)
                ->bodyHtml();

            $crawler = new Crawler($html);

            $produkList = $crawler->filter('div.card-body')->each(function (Crawler $node) {
                $nama = $node->filter('div.p-4 a.fs-3')->count() ? trim($node->filter('div.p-4 a.fs-3')->text()) : 'Nama tidak ditemukan';
                $harga = $node->filter('div.text-right p.fs-3')->count() ? trim($node->filter('div.text-right p.fs-3')->text()) : 'Harga tidak ditemukan';
                return compact('nama', 'harga');
            });

            return view('produk', compact('produkList'));
        } catch (\Exception $e) {
            return view('produk', ['produkList' => [], 'error' => $e->getMessage()]);
        }
    }
}

