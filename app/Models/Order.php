<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    const STATUS_PENDING = 'pending';
    const STATUS_PROCESSING = 'processing';
    const STATUS_SHIPPED = 'shipped';
    const STATUS_DELIVERED = 'delivered';
    const STATUS_CANCELLED = 'cancelled';
    const STATUS_REJECTED = 'rejected';

    protected $fillable = [
        'user_id', 'order_number', 'total_price', 'shipping_cost',
        'distance', 'address', 'city', 'province', 'postal_code',
        'latitude', 'longitude', 'payment_method', 'status', 'notes'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function canBeCancelled()
    {
        return $this->status === self::STATUS_PENDING;
    }

    public function canBeMarkedAsReceived()
    {
        return $this->status === self::STATUS_SHIPPED;
    }

    public function getStatusNameAttribute()
    {
        return match($this->status) {
            self::STATUS_PENDING => 'Menunggu Konfirmasi',
            self::STATUS_PROCESSING => 'Sedang Diproses',
            self::STATUS_SHIPPED => 'Dalam Pengiriman',
            self::STATUS_DELIVERED => 'Diterima',
            self::STATUS_CANCELLED => 'Dibatalkan',
            self::STATUS_REJECTED => 'Ditolak',
            default => 'Status Tidak Diketahui',
        };
    }

    public function getStatusColorAttribute()
    {
        return match($this->status) {
            self::STATUS_PENDING => 'yellow',
            self::STATUS_PROCESSING => 'blue',
            self::STATUS_SHIPPED => 'indigo',
            self::STATUS_DELIVERED => 'green',
            self::STATUS_CANCELLED => 'red',
            self::STATUS_REJECTED => 'red',
            default => 'gray',
        };
    }

    /**
     * Check if a status transition is valid
     */
    public function canTransitionTo(string $newStatus): bool
    {
        // Define valid transitions
        $validTransitions = [
            self::STATUS_PENDING => [self::STATUS_PROCESSING, self::STATUS_REJECTED, self::STATUS_CANCELLED],
            self::STATUS_PROCESSING => [self::STATUS_SHIPPED, self::STATUS_CANCELLED],
            self::STATUS_SHIPPED => [self::STATUS_DELIVERED],
            self::STATUS_DELIVERED => [], // Terminal state
            self::STATUS_CANCELLED => [], // Terminal state
            self::STATUS_REJECTED => []   // Terminal state
        ];

        return in_array($newStatus, $validTransitions[$this->status] ?? []);
    }

    /**
     * Get available next statuses
     */
    public function getNextAvailableStatuses(): array
    {
        $validTransitions = [
            self::STATUS_PENDING => [self::STATUS_PROCESSING, self::STATUS_REJECTED, self::STATUS_CANCELLED],
            self::STATUS_PROCESSING => [self::STATUS_SHIPPED, self::STATUS_CANCELLED],
            self::STATUS_SHIPPED => [], // Only customers can mark as delivered
            self::STATUS_DELIVERED => [], // Terminal state
            self::STATUS_CANCELLED => [], // Terminal state
            self::STATUS_REJECTED => []   // Terminal state
        ];

        return $validTransitions[$this->status] ?? [];
    }
}
