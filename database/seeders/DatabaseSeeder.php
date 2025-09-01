<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Role;
use App\Models\User;
use App\Models\Category;
use App\Models\ShippingSetting;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        // Create Roles
        $adminRole = Role::create(['name' => 'admin']);
        $customerRole = Role::create(['name' => 'customer']);

        // Create Admin
        User::create([
            'name' => 'Admin Toko Deden',
            'email' => 'admin@tokodeden.com',
            'password' => Hash::make('password'),
            'role_id' => $adminRole->id
        ]);

        // Test Customer
        User::create([
            'name' => 'Customer Test',
            'email' => 'customer@example.com',
            'password' => Hash::make('password'),
            'role_id' => $customerRole->id,
            'address' => 'Jl. Test Customer No. 123',
            'phone' => '08123456789',
            'latitude' => -6.180000,
            'longitude' => 106.860000
        ]);

        // Create Categories
        $categories = [
            'Pakan Ayam',
            'Pakan Sapi',
            'Pakan Kambing',
            'Pakan Ikan',
            'Suplemen Ternak'
        ];

        foreach ($categories as $category) {
            Category::create([
                'name' => $category,
                'slug' => \Illuminate\Support\Str::slug($category)
            ]);
        }

        // Call seeders
        $this->call([
            ShippingSettingSeeder::class,
            ProductSeeder::class,
        ]);
    }
}
