<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama_produk',
        'harga',
        'url_gambar',
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Parse harga dari format string ke numeric
     */
    public function getParsedPriceAttribute(): int
    {
        $cleanPrice = preg_replace('/[^0-9]/', '', $this->harga);
        return (int) $cleanPrice;
    }

    /**
     * Get formatted price
     */
    public function getFormattedPriceAttribute(): string
    {
        if (strpos($this->harga, 'Rp') !== false) {
            return $this->harga;
        }
        
        $numericPrice = $this->getParsedPriceAttribute();
        return 'Rp ' . number_format($numericPrice, 0, ',', '.');
    }

    /**
     * Get product category
     */
    public function getCategoryAttribute(): string
    {
        $productName = strtolower($this->nama_produk);
        
        if (strpos($productName, 'shock') !== false || 
            strpos($productName, 'absorber') !== false || 
            strpos($productName, 'shockbreaker') !== false) {
            return 'shockbreaker';
        }
        
        if (strpos($productName, 'aki') !== false || 
            strpos($productName, 'battery') !== false || 
            strpos($productName, 'accu') !== false) {
            return 'aki';
        }
        
        if (strpos($productName, 'ban') !== false) {
            return 'ban';
        }
        
        $oliKeywords = ['oli', 'yamalube', 'shell', '1.0', '0.8', '10w', '20w', '5w', 'sae', 'engine', 'lubricant'];
        foreach ($oliKeywords as $keyword) {
            if (strpos($productName, $keyword) !== false) {
                return 'oli';
            }
        }
        
        return 'lainnya';
    }

    /**
     * Get product description
     */
    public function getDescriptionAttribute(): string
    {
        $category = $this->getCategoryAttribute();
        
        $descriptions = [
            'shockbreaker' => 'Shockbreaker berkualitas untuk kenyamanan dan handling motor yang optimal',
            'aki' => 'Aki motor bertenaga dengan daya tahan lama dan performa stabil',
            'ban' => 'Ban motor berkualitas dengan daya cengkram dan ketahanan tinggi',
            'oli' => 'Oli motor berkualitas tinggi untuk performa mesin optimal',
            'lainnya' => 'Produk motor berkualitas untuk kendaraan Anda'
        ];
        
        return $descriptions[$category] ?? $descriptions['lainnya'];
    }
}