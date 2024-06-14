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
            $table->unsignedBigInteger('hirarc_id')->nullable();
            // Adding the foreign key constraint
            $table->foreign('hirarc_id')->references('hirarc_id')->on('hirarc_tbl')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('risk_assesment_tbl', function (Blueprint $table) {
            // Drop the foreign key constraint
            $table->dropForeign(['hirarc_id']);

            // Drop the column
            $table->dropColumn('hirarc_id');
        });
    }
};
