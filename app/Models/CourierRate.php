<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CourierRate extends Model
{
    use HasFactory;

    protected $fillable = [
        'branch_id', 'service_type', 'origin_zone', 'destination_zone',
        'base_weight', 'base_price', 'additional_weight_price',
        'fuel_surcharge_pct', 'cod_charge_pct', 'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'base_weight' => 'decimal:3',
        'base_price' => 'decimal:2',
        'additional_weight_price' => 'decimal:2',
        'fuel_surcharge_pct' => 'decimal:2',
        'cod_charge_pct' => 'decimal:2',
    ];

    public function branch(): BelongsTo
    {
        return $this->belongsTo(Branch::class);
    }
}
