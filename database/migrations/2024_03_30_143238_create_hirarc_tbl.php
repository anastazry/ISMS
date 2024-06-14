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
        Schema::create('hirarc_tbl', function (Blueprint $table) {
            $table->id("hirarc_id");
            $table->string('desc_job');
            $table->string('location');
            $table->string('prepared_by');
            $table->string('approved_by');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('hirarc_tbl');
    }
};
