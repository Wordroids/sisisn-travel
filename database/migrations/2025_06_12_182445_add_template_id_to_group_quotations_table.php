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
        Schema::table('group_quotations', function (Blueprint $table) {
            // Add the column first without constraint
            $table->unsignedBigInteger('template_id')->nullable()->after('is_template');
            
            // Add the foreign key separately with explicit referencing
            $table->foreign('template_id')
                  ->references('id')
                  ->on('quotation_templates')
                  ->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('group_quotations', function (Blueprint $table) {
            $table->dropForeign(['template_id']);
            $table->dropColumn('template_id');
        });
    }
};
