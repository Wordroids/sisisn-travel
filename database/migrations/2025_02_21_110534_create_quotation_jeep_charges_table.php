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
        Schema::create('quotation_jeep_charges', function (Blueprint $table) {
            $table->id();
            $table->foreignId('quotation_id')->constrained()->onDelete('cascade'); // Links to the quotations table
            $table->string('pax_range'); // Pax Range
            $table->decimal('unit_price', 10, 2); // Unit Price (US$)
            $table->integer('quantity'); // Quantity
            $table->decimal('total_price', 10, 2); // Total Price (US$)
            $table->decimal('per_person', 10, 2); // Per Person (US$)
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('quotation_jeep_charges');
    }
};
