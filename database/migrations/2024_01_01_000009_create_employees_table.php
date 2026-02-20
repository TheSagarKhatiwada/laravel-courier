<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('employees', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('branch_id')->constrained();
            $table->string('employee_code', 20)->unique();
            $table->string('name');
            $table->string('designation')->nullable();
            $table->string('department')->nullable();
            $table->date('joining_date');
            $table->date('leaving_date')->nullable();
            $table->decimal('basic_salary', 10, 2)->default(0);
            $table->string('phone')->nullable();
            $table->string('email')->nullable();
            $table->string('address')->nullable();
            $table->string('status')->default('active'); // active, resigned, terminated
            $table->json('documents')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('employees');
    }
};
