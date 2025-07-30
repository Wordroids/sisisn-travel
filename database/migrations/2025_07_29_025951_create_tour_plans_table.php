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
        Schema::create('tour_plans', function (Blueprint $table) {
            $table->id();
            $table->string('group_quotation_id'); // Reference to the main booking ref
            $table->longText('tour_notes')->nullable(); // Rich text from Quill editor
            $table->longText('important_notes')->nullable(); // Critical information for the tour
            $table->json('guests')->nullable(); // Store guests as JSON array
            $table->json('detailed_guests')->nullable(); // Store detailed guest information as JSON array
            $table->json('itinerary_days')->nullable(); // Store itinerary days as JSON array
            $table->unsignedBigInteger('created_by'); // User who created the tour plan
            $table->timestamps();
            
            // Foreign key relationship
            $table->foreign('created_by')
                ->references('id')
                ->on('users')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tour_plans');
    }
};
