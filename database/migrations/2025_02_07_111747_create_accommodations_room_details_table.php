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
        Schema::create('accommodations_room_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('quotation_accommodation_id')->constrained('quotation_accommodations')->onDelete('cascade');
            $table->string('room_type');
            $table->decimal('per_night_cost', 10, 2);
            $table->integer('nights');
            $table->decimal('total_cost', 10, 2);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('accommodations_room_details');
    }
};
