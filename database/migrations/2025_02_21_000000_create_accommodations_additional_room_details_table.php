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
        Schema::create('additional_rooms', function (Blueprint $table) {
            $table->id();
            $table->foreignId('quotation_accommodation_id')->constrained('quotation_accommodations')->onDelete('cascade');
            $table->string('room_type');
            $table->decimal('per_night_cost', 10, 2);
            $table->integer('nights');
            $table->decimal('total_cost', 10, 2);
            $table->boolean('provided_by_hotel')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('additional_rooms');
    }
};
