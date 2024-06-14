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
        Schema::create('injured_people', function (Blueprint $table) {
            $table->id();
            $table->string('incident_id');
            $table->foreign('incident_id')->references('reportNo')->on('incidents');
            $table->string('injured_name');
            $table->string('injured_ic');
            $table->string('injured_nationality');
            $table->string('injured_company');
            $table->string('injured_trades');
            $table->integer('total_lost_days'); // Corrected data type
            $table->string('incident_type');
            $table->timestamps();
        });
        
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('injured_people');
    }
};
