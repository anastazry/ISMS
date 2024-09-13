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
        Schema::create('table_mandor_assignment_tbl', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('peringkat');
            $table->string('blok');
            $table->string('n_lot');
            $table->string('n_p_tuai');
            $table->foreignId('mandor_id')->constrained('users');
            $table->string('k_penuai');
            $table->string('status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('table_mandor_assignment_tbl');
    }
};
