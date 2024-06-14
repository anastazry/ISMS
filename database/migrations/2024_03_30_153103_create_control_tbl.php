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
        Schema::create('control_tbl', function (Blueprint $table) {
            $table->id("control_id");
            $table->unsignedBigInteger("hazard_id")->nullable();
            $table->foreign("hazard_id")->references("hazard_id")->on("hazard_identify_tbl")->onDelete("set null");
            $table->string("opportunity");
            $table->string("new_control");
            $table->string("responsibility");
            $table->integer("status")->nullable();
            $table->date("finish_date")->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('control_tbl');
    }
};
