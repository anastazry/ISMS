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
        Schema::table('incident_investigation_part_a', function (Blueprint $table) {
            $table->boolean('interview_victims_or_witness')->default(false);
            $table->foreign('reportNo')->references('reportNo')->on('incidents');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('incident_investigation_part_a', function (Blueprint $table) {
            //
        });
    }
};
