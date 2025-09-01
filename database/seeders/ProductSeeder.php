<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $products = [
            [
                'name' => 'Pakan Ayam Starter',
                'category_id' => 1,
                'description' => 'Pakan untuk ayam pada fase starter (0-4 minggu), mengandung protein tinggi untuk pertumbuhan optimal.',
                'price' => 75000,
                'stock' => 100,
                'image' => null,
                'is_active' => true
            ],
            [
                'name' => 'Pakan Ayam Finisher',
                'category_id' => 1,
                'description' => 'Pakan untuk ayam pada fase finisher (>4 minggu), formulasi khusus untuk pertumbuhan daging.',
                'price' => 70000,
                'stock' => 120,
                'image' => null,
                'is_active' => true
            ],
            [
                'name' => 'Pakan Sapi Perah',
                'category_id' => 2,
                'description' => 'Pakan khusus untuk sapi perah, meningkatkan produksi susu dan kesehatan sapi.',
                'price' => 125000,
                'stock' => 50,
                'image' => null,
                'is_active' => true
            ],
            [
                'name' => 'Pakan Sapi Potong',
                'category_id' => 2,
                'description' => 'Pakan khusus untuk sapi potong, meningkatkan pertumbuhan bobot dan kualitas daging.',
                'price' => 130000,
                'stock' => 45,
                'image' => null,
                'is_active' => true
            ],
            [
                'name' => 'Pakan Kambing Premium',
                'category_id' => 3,
                'description' => 'Pakan berkualitas tinggi untuk kambing, meningkatkan kesehatan dan produksi susu kambing.',
                'price' => 85000,
                'stock' => 60,
                'image' => null,
                'is_active' => true
            ],
            [
                'name' => 'Pakan Ikan Lele',
                'category_id' => 4,
                'description' => 'Pakan khusus untuk budidaya ikan lele, meningkatkan pertumbuhan dan imunitas.',
                'price' => 50000,
                'stock' => 150,
                'image' => null,
                'is_active' => true
            ],
            [
                'name' => 'Pakan Ikan Nila',
                'category_id' => 4,
                'description' => 'Pakan khusus untuk budidaya ikan nila, mengandung nutrisi lengkap untuk pertumbuhan optimal.',
                'price' => 55000,
                'stock' => 140,
                'image' => null,
                'is_active' => true
            ],
            [
                'name' => 'Suplemen Vitamin Ternak',
                'category_id' => 5,
                'description' => 'Suplemen multivitamin untuk meningkatkan daya tahan dan kesehatan hewan ternak.',
                'price' => 95000,
                'stock' => 80,
                'image' => null,
                'is_active' => true
            ],
            [
                'name' => 'Probiotik Ternak',
                'category_id' => 5,
                'description' => 'Suplemen probiotik untuk menjaga kesehatan sistem pencernaan hewan ternak.',
                'price' => 110000,
                'stock' => 70,
                'image' => null,
                'is_active' => true
            ],
            [
                'name' => 'Mineral Blok Ternak',
                'category_id' => 5,
                'description' => 'Suplemen mineral berbentuk blok untuk kebutuhan mineral hewan ternak.',
                'price' => 60000,
                'stock' => 90,
                'image' => null,
                'is_active' => true
            ],
        ];

        foreach ($products as $product) {
            $product['slug'] = Str::slug($product['name']);
            Product::create($product);
        }
    }
}
