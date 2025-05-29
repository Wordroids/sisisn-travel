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
        // Main group quotation table
        Schema::create('group_quotations', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->string('quote_reference')->unique();
            $table->string('booking_reference')->nullable();
            $table->foreignId('market_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('customer_id')->nullable()->constrained('customers')->nullOnDelete();
            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();
            $table->integer('duration')->nullable();
            $table->string('currency')->default('USD');
            $table->decimal('conversion_rate', 10, 4)->default(1);
            $table->decimal('markup_per_person', 10, 2)->default(0);
            $table->enum('status', ['draft', 'pending', 'approved', 'rejected'])->default('draft');
            $table->foreignId('pax_slab_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('driver_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('guide_id')->nullable()->constrained()->nullOnDelete();
            $table->text('description')->nullable();
            $table->boolean('is_template')->default(false);
            $table->timestamps();
        });

       // Group accommodations table
        Schema::create('group_quotation_accommodations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('group_quotation_id')
                  ->constrained()
                  ->cascadeOnDelete();
            $table->foreignId('hotel_id')->constrained()->cascadeOnDelete();
            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();
            $table->integer('nights')->nullable();
            $table->foreignId('meal_plan_id')->constrained()->cascadeOnDelete();
            $table->foreignId('room_category_id')->constrained()->cascadeOnDelete();
            $table->timestamps();
        });

        // Group accommodation room details - Renamed to shorter name
        Schema::create('group_room_details', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('group_quotation_accommodation_id');
            $table->string('room_type');
            $table->decimal('per_night_cost', 10, 2)->nullable();
            $table->integer('nights')->nullable();
            $table->decimal('total_cost', 10, 2)->nullable();
            $table->timestamps();
            
            // Add foreign key constraint with custom name
            $table->foreign('group_quotation_accommodation_id', 'grp_room_dtl_accom_id_fk')
                  ->references('id')
                  ->on('group_quotation_accommodations')
                  ->cascadeOnDelete();
        });

        // Group additional rooms - Renamed to shorter name
        Schema::create('group_additional_rooms', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('group_quotation_accommodation_id');
            $table->string('room_type');
            $table->decimal('per_night_cost', 10, 2)->nullable();
            $table->integer('nights')->nullable();
            $table->decimal('total_cost', 10, 2)->nullable();
            $table->boolean('provided_by_hotel')->default(false);
            $table->timestamps();
            
            // Add foreign key constraint with custom name
            $table->foreign('group_quotation_accommodation_id', 'grp_add_rooms_accom_id_fk')
                  ->references('id')
                  ->on('group_quotation_accommodations')
                  ->cascadeOnDelete();
        });

        // Group travel plans
        Schema::create('group_quotation_travel_plans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('group_quotation_id')->constrained()->cascadeOnDelete();
            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();
            $table->foreignId('route_id')->constrained('travel_routes')->cascadeOnDelete();
            $table->foreignId('vehicle_type_id')->constrained()->cascadeOnDelete();
            $table->decimal('mileage', 10, 2)->default(0);
            $table->timestamps();
        });

        // Group jeep charges
        Schema::create('group_quotation_jeep_charges', function (Blueprint $table) {
            $table->id();
            $table->foreignId('group_quotation_id')->constrained()->cascadeOnDelete();
            $table->foreignId('travel_plan_id')->nullable()
                  ->constrained('group_quotation_travel_plans')
                  ->nullOnDelete();
            $table->string('pax_range')->nullable();
            $table->decimal('unit_price', 10, 2)->nullable();
            $table->integer('quantity')->nullable();
            $table->decimal('total_price', 10, 2)->nullable();
            $table->decimal('per_person', 10, 2)->nullable();
            $table->timestamps();
        });

        // Group pax slabs
        Schema::create('group_quotation_pax_slabs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('group_quotation_id')->constrained()->cascadeOnDelete();
            $table->foreignId('pax_slab_id')->constrained()->cascadeOnDelete();
            $table->foreignId('vehicle_type_id')->constrained()->cascadeOnDelete();
            $table->integer('exact_pax')->nullable();
            $table->decimal('vehicle_payout_rate', 10, 2)->nullable();
            $table->timestamps();
        });

        // Group site seeings
        Schema::create('group_quotation_site_seeings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('group_quotation_id')->constrained()->cascadeOnDelete();
            $table->string('name')->nullable();
            $table->string('type')->default('site'); // 'site' or 'extra'
            $table->text('description')->nullable();
            $table->decimal('unit_price', 10, 2)->nullable();
            $table->integer('quantity')->nullable();
            $table->decimal('price_per_adult', 10, 2)->nullable();
            $table->timestamps();
        });

        // Group extras
        Schema::create('group_quotation_extras', function (Blueprint $table) {
            $table->id();
            $table->foreignId('group_quotation_id')->constrained()->cascadeOnDelete();
            $table->date('date')->nullable();
            $table->string('description')->nullable();
            $table->decimal('unit_price', 10, 2)->nullable();
            $table->integer('quantity_per_pax')->nullable();
            $table->decimal('total_price', 10, 2)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Drop tables in reverse order to avoid foreign key constraints
        Schema::dropIfExists('group_quotation_extras');
        Schema::dropIfExists('group_quotation_site_seeings');
        Schema::dropIfExists('group_quotation_pax_slabs');
        Schema::dropIfExists('group_quotation_jeep_charges');
        Schema::dropIfExists('group_quotation_travel_plans');
        Schema::dropIfExists('group_additional_rooms');
        Schema::dropIfExists('group_accommodation_room_details');
        Schema::dropIfExists('group_quotation_accommodations');
        Schema::dropIfExists('group_quotations');
    }
};
