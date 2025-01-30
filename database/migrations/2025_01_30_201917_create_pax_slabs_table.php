<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('pax_slabs', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // Pax Slab name (e.g., "01 Pax", "02 Pax", "03 Pax", etc.)
            $table->integer('min_pax'); // Minimum pax count for this slab
            $table->integer('max_pax'); // Maximum pax count for this slab
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('pax_slabs');
    }
};
