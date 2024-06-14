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
        Schema::create('incident_investigation_part_a', function (Blueprint $table) {
            $table->id();
            $table->timestamps();

            $table->unsignedBigInteger('hirarc_id')->nullable();
            // Adding the foreign key constraint
            $table->foreign('hirarc_id')->references('hirarc_id')->on('hirarc_tbl')->onDelete('set null');

            $table->string('reportNo');
            // Adding the foreign key constraint
            $table->foreign('reportNo')->references('reportNo')->on('incidents');

            $table->text('investigation_team');
            $table->string('incident_category');
            $table->string('incidentWhenAndWhere');
            $table->string('incident_desc');
            $table->string('property_damage');
            $table->text('investigation_findings');
            $table->string('status');
            $table->text('project_site');
            $table->text('incident_drawing');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('incident_investigation_part_a');
    }
};
