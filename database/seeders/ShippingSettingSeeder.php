<?php

namespace Database\Seeders;

use App\Models\ShippingSetting;
use Illuminate\Database\Seeder;

class ShippingSettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Delete existing settings to prevent duplicates
        ShippingSetting::truncate();

        // Create default shipping settings
        ShippingSetting::create([
            'free_shipping_distance' => 2.0,
            'cost_per_km' => 5000,
            'store_latitude' => -6.175110,  // Jakarta
            'store_longitude' => 106.865039
        ]);
    }
}
