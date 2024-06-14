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
        Schema::create('incidents', function (Blueprint $table) {
            Schema::dropIfExists('incidents');
            $table->string('reportNo')->primary();
            $table->string('dept_name');
            $table->string('project_site');
            $table->string('incident_location');
            $table->primary('reportNo');
            $table->timestamps();
            $table->unsignedBigInteger('injured_id');
            $table->unsignedBigInteger('witness_id');
            $table->unsignedBigInteger('user_id');
            $table->foreign('witness_id')->references('id')->on('witness_details');
            $table->foreign('injured_id')->references('id')->on('injured_people');
            $table->foreign('user_id')->references('id')->on('users');
            $table->time('incident_title');
            $table->time('incident_time');
            $table->string('incident_desc');
            $table->string('incident_image');
            $table->string('notes');
        });
    }

    

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('incidents');
    }
};
