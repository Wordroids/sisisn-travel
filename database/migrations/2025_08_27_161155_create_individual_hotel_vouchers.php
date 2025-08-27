<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('individual_hotel_vouchers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('quotation_id')->constrained()->onDelete('cascade');
            $table->foreignId('hotel_id')->constrained()->onDelete('cascade');
            $table->string('booking_name');
            $table->date('voucher_date');
            $table->date('arrival_date');
            $table->date('departure_date');
            $table->integer('total_nights');
            $table->text('hotel_address')->nullable();
            $table->string('room_category')->nullable();
            $table->string('meal_plan');
            $table->integer('adults');
            $table->integer('children')->default(0);
            $table->json('room_counts');
            $table->text('special_notes')->nullable();
            $table->text('billing_instructions')->nullable();
            $table->text('remarks')->nullable();
            $table->text('reservation_note')->nullable();
            $table->string('contact_person')->nullable();
            $table->boolean('is_amendment')->default(false);
            $table->integer('amendment_number')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('individual_hotel_vouchers');
    }
};
