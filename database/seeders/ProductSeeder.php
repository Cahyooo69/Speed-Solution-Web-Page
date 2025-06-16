<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        // Hapus semua data produk yang ada
        Product::truncate();
        
        $file = storage_path('app/public/shopandbike_products_selenium.csv');
        
        if (!file_exists($file)) {
            echo "File CSV tidak ditemukan: " . $file . "\n";
            echo "Coba gunakan path langsung...\n";
            $file = 'd:\coba_selenium\shopandbike_products_selenium.csv';
        }
        
        if (!file_exists($file)) {
            echo "File CSV tidak ditemukan di: " . $file . "\n";
            return;
        }
        
        $csv = array_map('str_getcsv', file($file));
        $header = array_map('trim', array_shift($csv));
        
        // Debug: tampilkan header yang ditemukan
        echo "Header ditemukan: " . print_r($header, true) . "\n";
        echo "Jumlah kolom header: " . count($header) . "\n";
        
        // Debug: tampilkan beberapa baris pertama
        echo "3 baris pertama data:\n";
        for ($i = 0; $i < min(3, count($csv)); $i++) {
            echo "Row " . ($i + 1) . ": " . print_r($csv[$i], true) . "\n";
        }
        
        $imported = 0;
        foreach ($csv as $index => $row) {
            if (count($row) === count($header)) {
                $data = array_combine($header, $row);
                
                // Debug: tampilkan data yang akan diinsert untuk row pertama
                if ($index === 0) {
                    echo "Data row pertama: " . print_r($data, true) . "\n";
                }
                
                try {
                    // Gunakan key yang sesuai dengan header CSV
                    Product::create([
                        'nama_produk' => trim($data[$header[0]]), // kolom pertama
                        'harga' => trim($data[$header[1]]),       // kolom kedua  
                        'url_gambar' => trim($data[$header[2]])   // kolom ketiga
                    ]);
                    $imported++;
                } catch (\Exception $e) {
                    echo "Error importing row " . ($index + 1) . ": " . $e->getMessage() . "\n";
                }
            }
        }
        
        echo "Successfully imported: " . $imported . " products\n";
    }
}