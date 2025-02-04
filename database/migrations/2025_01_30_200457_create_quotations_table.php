<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('quotations', function (Blueprint $table) {
            $table->id();
            $table->string('quote_reference')->unique(); // Auto-generated format: QT/SP/1001
            $table->string('booking_reference')->nullable(); // Temporary until confirmed, ST/SP/1001
            $table->foreignId('market_id')->constrained()->onDelete('cascade'); // Market selection
            $table->foreignId('customer_id')->nullable()->constrained()->onDelete('set null'); // Customer selection
            $table->date('start_date'); // Tour start date
            $table->date('end_date'); // Tour end date
            $table->integer('duration'); // Auto-calculated from date range
            $table->string('currency')->default('USD'); // Default currency
            $table->decimal('conversion_rate', 10, 2); // Auto-filled conversion rate
            $table->decimal('markup_per_person', 10, 2); // System-defined markup per person
            $table->foreignId('pax_slab_id')->constrained('pax_slabs')->onDelete('cascade'); // Links to selected Pax Slab
            $table->enum('status', ['draft', 'pending', 'approved', 'rejected'])->default('draft'); // Quotation status
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('quotations');
    }
};
