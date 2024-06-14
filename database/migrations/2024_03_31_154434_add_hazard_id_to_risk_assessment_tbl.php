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
        Schema::table('risk_assesment_tbl', function (Blueprint $table) {
            $table->unsignedBigInteger('hazard_id')->nullable();
            // Adding the foreign key constraint
            $table->foreign('hazard_id')->references('hazard_id')->on('hazard_identify_tbl')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('risk_assesment_tbl', function (Blueprint $table) {
                // Drop the foreign key constraint
                $table->dropForeign(['hazard_id']);

                // Drop the column
                $table->dropColumn('hazard_id');
        });
    }
};
