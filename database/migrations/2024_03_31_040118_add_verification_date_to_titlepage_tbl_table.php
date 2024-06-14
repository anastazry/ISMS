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
        Schema::table('titlepage_tbl', function (Blueprint $table) {
            $table->date("verification_date");
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('titlepage_tbl', function (Blueprint $table) {
            $table->dropForeign(['verification_date']);
        });
    }
};
