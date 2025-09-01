<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('shipping_settings', function (Blueprint $table) {
            $table->id();
            $table->decimal('free_shipping_distance', 8, 2)->default(2.0);
            $table->decimal('cost_per_km', 12, 2)->default(5000);
            $table->decimal('store_latitude', 10, 8);
            $table->decimal('store_longitude', 11, 8);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('shipping_settings');
    }
};
