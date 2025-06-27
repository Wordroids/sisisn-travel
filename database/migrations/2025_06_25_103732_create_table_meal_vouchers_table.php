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
        Schema::create('meal_voucher_amendments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('group_quotation_id')->nullable()->constrained();
            $table->date('voucher_date');
            $table->foreignId('hotel_id')->nullable()->constrained();
            $table->string('hotel_name');
            $table->text('hotel_address')->nullable();
            $table->string('market')->nullable();
            $table->string('meal_plan'); // LUNCH, DINNER, BREAKFAST
            $table->text('selected_tours_data')->nullable(); // Store JSON data of selected tours
            $table->string('special_notes')->nullable();
            $table->string('billing_instructions')->nullable();
            $table->string('remarks')->nullable();
            $table->string('reservation_note')->nullable();
            $table->string('contact_person')->nullable();
            

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('meal_voucher_amendments');
    }
};
