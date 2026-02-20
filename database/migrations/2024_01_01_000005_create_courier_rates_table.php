<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('courier_rates', function (Blueprint $table) {
            $table->id();
            $table->foreignId('branch_id')->constrained()->cascadeOnDelete();
            $table->string('service_type'); // standard, express, same_day
            $table->string('origin_zone')->nullable();
            $table->string('destination_zone')->nullable();
            $table->decimal('base_weight', 8, 3)->default(0.5); // kg
            $table->decimal('base_price', 10, 2);
            $table->decimal('additional_weight_price', 10, 2)->default(0);
            $table->decimal('fuel_surcharge_pct', 5, 2)->default(0);
            $table->decimal('cod_charge_pct', 5, 2)->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('courier_rates');
    }
};
