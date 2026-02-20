<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Customer extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'code', 'email', 'phone', 'address', 'city', 'state',
        'country', 'pincode', 'gstin', 'credit_limit', 'balance',
        'branch_id', 'user_id', 'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'credit_limit' => 'decimal:2',
        'balance' => 'decimal:2',
    ];

    public function branch(): BelongsTo
    {
        return $this->belongsTo(Branch::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function shipments(): HasMany
    {
        return $this->hasMany(Shipment::class);
    }

    public function ledgers(): HasMany
    {
        return $this->hasMany(CustomerLedger::class);
    }

    public function contactBook(): HasMany
    {
        return $this->hasMany(ContactBook::class);
    }
}
