<?php

// database/seeders/ProductSeeder.php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;

class ProductSeeder extends Seeder
{
    public function run()
    {
        // Insert multiple products into the products table
        Product::create([
            'barcode' => 'P001',
            'description' => 'Smartphone with 6GB RAM, 128GB Storage',
            'price' => 299.99,
            'quantity' => 50,
            'category' => 'Electronics',
        ]);

        Product::create([
            'barcode' => 'P002',
            'description' => 'Laptop with 16GB RAM, 512GB SSD',
            'price' => 799.99,
            'quantity' => 30,
            'category' => 'Computers',
        ]);

        Product::create([
            'barcode' => 'P003',
            'description' => 'Bluetooth Headphones, Noise Cancelling',
            'price' => 129.99,
            'quantity' => 100,
            'category' => 'Accessories',
        ]);

        Product::create([
            'barcode' => 'P004',
            'description' => 'Smartwatch with heart rate monitor',
            'price' => 199.99,
            'quantity' => 70,
            'category' => 'Wearables',
        ]);

        Product::create([
            'barcode' => 'P005',
            'description' => '4K Ultra HD Smart TV, 55 inch',
            'price' => 599.99,
            'quantity' => 40,
            'category' => 'Electronics',
        ]);
    }
}
