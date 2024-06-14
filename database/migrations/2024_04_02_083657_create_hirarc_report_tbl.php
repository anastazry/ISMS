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
        Schema::create('hirarc_report_tbl', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('tpage_id')->nullable();
            $table->unsignedBigInteger('hirarc_id')->nullable();
            $table->foreign('tpage_id')->references('tpage_id')->on('titlepage_tbl')->onDelete('set null');
            $table->foreign('hirarc_id')->references('hirarc_id')->on('hirarc_tbl')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('hirarc_report_tbl');
    }
};
