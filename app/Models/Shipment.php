<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Shipment extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'awb_number', 'branch_id', 'customer_id', 'created_by',
        'sender_name', 'sender_phone', 'sender_address', 'sender_city',
        'sender_state', 'sender_pincode', 'sender_country',
        'receiver_name', 'receiver_phone', 'receiver_address', 'receiver_city',
        'receiver_state', 'receiver_pincode', 'receiver_country',
        'weight', 'pieces', 'content', 'declared_value', 'service_type',
        'freight_charge', 'cod_amount', 'total_charge', 'payment_mode',
        'status', 'booking_date', 'expected_delivery_date', 'delivered_at',
        'remarks', 'barcode', 'qr_code',
    ];

    protected $casts = [
        'weight' => 'decimal:3',
        'declared_value' => 'decimal:2',
        'freight_charge' => 'decimal:2',
        'cod_amount' => 'decimal:2',
        'total_charge' => 'decimal:2',
        'booking_date' => 'date',
        'expected_delivery_date' => 'date',
        'delivered_at' => 'datetime',
    ];

    public function branch(): BelongsTo
    {
        return $this->belongsTo(Branch::class);
    }

    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class);
    }

    public function createdBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function trackings(): HasMany
    {
        return $this->hasMany(ShipmentTracking::class);
    }

    public static function generateAwb(string $branchCode): string
    {
        $prefix = strtoupper($branchCode);
        $date = now()->format('ymd');
        $count = static::whereDate('created_at', today())
            ->where('awb_number', 'like', "{$prefix}{$date}%")
            ->count();
        return $prefix . $date . str_pad($count + 1, 4, '0', STR_PAD_LEFT);
    }
}
