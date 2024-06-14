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
        Schema::create('risk_assesment_tbl', function (Blueprint $table) {
            Schema::dropIfExists('risk_assesment_tbl');
            $table->id("risk_id");
            $table->unsignedBigInteger("hirarc_id")->nullable();
            $table->foreign("hirarc_id")->references("hirarc_id")->on("hirarc_tbl")->onDelete("set null");
            $table->string("risk_desc");
            $table->string("current_control");
            $table->integer("likelihood");
            $table->integer("severity");
            $table->integer("score");
            $table->string("index");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('risk_assesment_tbl');
    }
};
