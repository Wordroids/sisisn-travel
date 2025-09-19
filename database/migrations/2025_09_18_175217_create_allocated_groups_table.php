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
        Schema::create('allocated_groups', function (Blueprint $table) {
            $table->id();
            $table->foreignId('accommodation_id')
                  ->constrained('group_quotation_accommodations')
                  ->cascadeOnDelete();
            $table->string('group_name');
            $table->timestamps();
            
            // Use a shorter custom name for the unique constraint
            $table->unique(['accommodation_id', 'group_name'], 'ag_accommodation_group_unique');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('allocated_groups');
    }
};
