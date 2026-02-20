<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Employee extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'user_id', 'branch_id', 'employee_code', 'name', 'designation',
        'department', 'joining_date', 'leaving_date', 'basic_salary',
        'phone', 'email', 'address', 'status', 'documents',
    ];

    protected $casts = [
        'joining_date' => 'date',
        'leaving_date' => 'date',
        'basic_salary' => 'decimal:2',
        'documents' => 'array',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function branch(): BelongsTo
    {
        return $this->belongsTo(Branch::class);
    }

    public function attendances(): HasMany
    {
        return $this->hasMany(Attendance::class);
    }

    public function leaves(): HasMany
    {
        return $this->hasMany(Leave::class);
    }

    public function assets(): HasMany
    {
        return $this->hasMany(Asset::class, 'assigned_to');
    }

    public function salaries(): HasMany
    {
        return $this->hasMany(Salary::class);
    }
}
