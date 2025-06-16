<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use Illuminate\Support\Facades\Log;

class ProductController extends Controller
{
    /**
     * Display the products page
     */
    public function index()
    {
        try {
            return $this->renderView('produk');
        } catch (\Exception $e) {
            return $this->handleException($e, 'Gagal memuat halaman produk');
        }
    }

    /**
     * API: Get all products
     */
    public function apiProducts(Request $request)
    {
        try {
            $category = $request->get('category');
            $search = $request->get('search');
            
            $query = Product::query();
            
            if ($category && $category !== 'all') {
                $this->applyCategoryFilter($query, $category);
            }
            
            if ($search) {
                $query->where('nama_produk', 'like', "%{$search}%");
            }
            
            $products = $query->get()->map(function ($product) {
                return [
                    'id' => $product->id,
                    'name' => $product->nama_produk,
                    'price' => $product->parsed_price,
                    'image' => $product->url_gambar ?? '/images/default-product.png',
                    'description' => $product->description,
                    'category' => $product->category,
                    'formatted_price' => $product->formatted_price
                ];
            });

            return $this->sendResponse([
                'products' => $products,
                'total' => $products->count()
            ], 'Products loaded successfully');
            
        } catch (\Exception $e) {
            Log::error('Error in apiProducts:', ['error' => $e->getMessage()]);
            return $this->sendError('Gagal memuat data produk: ' . $e->getMessage(), null, 500);
        }
    }

    /**
     * Get product categories
     */
    public function getCategories()
    {
        try {
            return $this->sendResponse($this->getProductCategories(), 'Categories loaded successfully');
        } catch (\Exception $e) {
            return $this->sendError('Gagal memuat kategori produk', null, 500);
        }
    }

    /**
     * Apply category filter
     */
    private function applyCategoryFilter($query, $category)
    {
        $filters = [
            'shockbreaker' => ['shock', 'absorber', 'shockbreaker'],
            'aki' => ['aki', 'battery', 'accu'],
            'ban' => ['ban'],
            'oli' => ['oli', 'yamalube', 'shell', '1.0', '0.8', '10w', '20w', '5w', 'sae', 'engine', 'lubricant']
        ];

        if ($category === 'lainnya') {
            $allKeywords = array_merge(...array_values($filters));
            $query->where(function($q) use ($allKeywords) {
                foreach ($allKeywords as $keyword) {
                    $q->where('nama_produk', 'not like', "%{$keyword}%");
                }
            });
        } elseif (isset($filters[$category])) {
            if ($category === 'oli') {
                $excludeKeywords = array_merge($filters['shockbreaker'], $filters['aki']);
                $query->where(function($q) use ($filters, $category, $excludeKeywords) {
                    $q->where(function($subQ) use ($filters, $category) {
                        foreach ($filters[$category] as $keyword) {
                            $subQ->orWhere('nama_produk', 'like', "%{$keyword}%");
                        }
                    });
                    foreach ($excludeKeywords as $exclude) {
                        $q->where('nama_produk', 'not like', "%{$exclude}%");
                    }
                });
            } else {
                $query->where(function($q) use ($filters, $category) {
                    foreach ($filters[$category] as $keyword) {
                        $q->orWhere('nama_produk', 'like', "%{$keyword}%");
                    }
                });
            }
        }
    }

/**
 * Get product categories list
 */
private function getProductCategories()
{
    return [
        ['id' => 'all', 'name' => 'Semua'],
        ['id' => 'oli', 'name' => 'Oli'],
        ['id' => 'ban', 'name' => 'Ban'],
        ['id' => 'shockbreaker', 'name' => 'Shockbreaker'],
        ['id' => 'aki', 'name' => 'Aki'],
        ['id' => 'lainnya', 'name' => 'Lainnya']
        ];
    }
}