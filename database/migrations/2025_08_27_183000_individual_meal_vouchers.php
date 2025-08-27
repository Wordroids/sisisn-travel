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
        Schema::create('individual_meal_vouchers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('quotation_id')->constrained()->onDelete('cascade');
            $table->date('voucher_date');
            $table->foreignId('hotel_id')->nullable()->constrained()->nullOnDelete();
            $table->string('hotel_name');
            $table->text('hotel_address')->nullable();
            $table->string('meal_plan');
            $table->string('market')->nullable();
            $table->text('special_notes')->nullable();
            $table->json('meal_dates')->nullable();
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
        Schema::dropIfExists('individual_meal_vouchers');
    }
};
