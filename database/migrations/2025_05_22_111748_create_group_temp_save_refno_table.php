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
        Schema::create('group_temp_save_refno', function (Blueprint $table) {
            $table->id();
            $table->string('quote_reference')->nullable(); 
            $table->string('booking_reference')->nullable(); // Temporary no after rejected , ST/SP/1001
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('group_temp_save_refno');
    }
};
