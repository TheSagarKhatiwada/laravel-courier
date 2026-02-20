<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->foreignId('branch_id')->nullable()->constrained()->nullOnDelete()->after('id');
            $table->string('phone')->nullable()->after('email');
            $table->string('employee_id')->nullable()->unique()->after('phone');
            $table->boolean('is_active')->default(true)->after('employee_id');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['branch_id']);
            $table->dropColumn(['branch_id', 'phone', 'employee_id', 'is_active']);
        });
    }
};
