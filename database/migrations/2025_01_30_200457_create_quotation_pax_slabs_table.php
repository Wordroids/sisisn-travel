<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('quotation_pax_slabs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('quotation_id')->constrained()->onDelete('cascade'); // Links to quotation
            $table->integer('exact_pax'); // Number of pax
            $table->string('vehicle_type'); // Selected vehicle type
            $table->decimal('vehicle_payout_rate', 10, 2); // Auto-filled based on vehicle type
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('quotation_pax_slabs');
    }
};
