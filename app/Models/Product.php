<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'slug', 'category_id', 'description',
        'price', 'stock', 'image', 'is_active'
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function carts()
    {
        return $this->hasMany(Cart::class);
    }

    /**
     * Determine if the product is actually active (considers both is_active flag and stock)
     *
     * @return bool
     */
    public function getIsActuallyActiveAttribute()
    {
        return $this->is_active && $this->stock > 0;
    }
}
