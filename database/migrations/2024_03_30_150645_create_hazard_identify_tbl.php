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
        Schema::create('hazard_identify_tbl', function (Blueprint $table) {
            $table->id("hazard_id");
            $table->string("job_sequence");
            $table->string("hazard");
            $table->string("can_cause");
            $table->unsignedBigInteger("hirarc_id")->nullable();
            $table->foreign("hirarc_id")->references("hirarc_id")->on("hirarc_tbl")->onDelete("set null");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('hazard_identify_tbl');
    }
};
