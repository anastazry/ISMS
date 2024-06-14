<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddForeignKeyToIncident extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('incidents', function (Blueprint $table) {
            $table->foreign('injured_id')
                ->references('id')
                ->on('injured_people');
            $table->foreign('witness_id')
                ->references('id')
                ->on('witness_details'); // Corrected table name
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('incidents', function (Blueprint $table) {
            $table->dropForeign(['injured_id']);
            $table->dropForeign(['witness_id']);
        });
    }
}

