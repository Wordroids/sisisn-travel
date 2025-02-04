<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('quotation_travel_plans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('quotation_id')->constrained()->onDelete('cascade');
            $table->foreignId('route_id')->constrained('travel_routes')->onDelete('cascade'); // Ensure correct reference
            $table->foreignId('vehicle_type_id')->constrained('vehicle_types')->onDelete('cascade'); // Ensure correct reference
            $table->date('start_date');
            $table->date('end_date');
            $table->decimal('mileage', 8, 2);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('quotation_travel_plans');
    }
};

