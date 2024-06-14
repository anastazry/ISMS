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
        Schema::table('hirarc_tbl', function (Blueprint $table) {
            // Add new column inspection_date
            $table->date('inspection_date')->nullable();

            // Remove existing column approved_by
            $table->dropColumn('approved_by');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('hirarc_tbl', function (Blueprint $table) {
            // Re-add the removed column approved_by
            $table->string('approved_by')->nullable();

            // Remove the newly added column inspection_date
            $table->dropColumn('inspection_date');
        });
    }
};
