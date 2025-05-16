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
        Schema::table('quotation_jeep_charges', function (Blueprint $table) {
        $table->foreignId('travel_plan_id')->nullable()->after('quotation_id')
              ->constrained('quotation_travel_plans')->onDelete('cascade');
    });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('quotation_jeep_charges', function (Blueprint $table) {
        $table->dropForeign(['travel_plan_id']);
        $table->dropColumn('travel_plan_id');
    });
    }
};
