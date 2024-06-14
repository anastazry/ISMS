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
        Schema::create('incident_investigation_part_b', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->unsignedBigInteger('investigation_a_id')->nullable();
            // Adding the foreign key constraint
            $table->foreign('investigation_a_id')->references('id')->on('incident_investigation_part_a');

            $table->text('ncr');
            $table->text('mitigative_actions');
            $table->text('cont_improve');
            $table->text('penalty');
            $table->boolean('safety_comittee_know')->default(false);
            $table->boolean('pm_know')->default(false);
            $table->boolean('staff_know')->default(false);
            $table->boolean('others_know')->default(false);
            $table->text('sho_signature');
            $table->date('sho_signature_date');
            $table->unsignedBigInteger('sho_id')->nullable();
            // Adding the foreign key constraint
            $table->foreign('sho_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('incident_investigation_part_b');
    }
};
