<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('shipments', function (Blueprint $table) {
            $table->id();
            $table->string('awb_number', 30)->unique();
            $table->foreignId('branch_id')->constrained();
            $table->foreignId('customer_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('created_by')->constrained('users');
            // Sender info
            $table->string('sender_name');
            $table->string('sender_phone');
            $table->string('sender_address');
            $table->string('sender_city');
            $table->string('sender_state');
            $table->string('sender_pincode', 20);
            $table->string('sender_country', 5)->default('IN');
            // Receiver info
            $table->string('receiver_name');
            $table->string('receiver_phone');
            $table->string('receiver_address');
            $table->string('receiver_city');
            $table->string('receiver_state');
            $table->string('receiver_pincode', 20);
            $table->string('receiver_country', 5)->default('IN');
            // Package info
            $table->decimal('weight', 8, 3);
            $table->integer('pieces')->default(1);
            $table->string('content')->nullable();
            $table->decimal('declared_value', 12, 2)->default(0);
            $table->string('service_type')->default('standard');
            $table->decimal('freight_charge', 10, 2)->default(0);
            $table->decimal('cod_amount', 10, 2)->default(0);
            $table->decimal('total_charge', 10, 2)->default(0);
            $table->string('payment_mode')->default('prepaid'); // prepaid, cod, credit
            $table->string('status')->default('booked'); // booked, picked, in_transit, out_for_delivery, delivered, returned, cancelled
            $table->date('booking_date');
            $table->date('expected_delivery_date')->nullable();
            $table->timestamp('delivered_at')->nullable();
            $table->text('remarks')->nullable();
            $table->string('barcode')->nullable();
            $table->string('qr_code')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('shipments');
    }
};
