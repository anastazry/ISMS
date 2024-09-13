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
        Schema::create('fruits_detaile_tbl', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('dituai')->nullable();
            $table->string('muda')->nullable();
            $table->string('busuk')->nullable();
            $table->string('kosong')->nullable();
            $table->string('panjang')->nullable();
            $table->string('s_lama')->nullable();
            $table->string('s_baru')->nullable();
            $table->string('images-path')->nullable();
            $table->string('location')->nullable();
            $table->date('tarikh')->nullable();
            $table->time('masa')->nullable();
            $table->foreignId('mandor_id')->constrained('users');
            $table->foreignId('assignment_id')->constrained('table_mandor_assignment_tbl');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('fruits_detaile_tbl');
    }
};
