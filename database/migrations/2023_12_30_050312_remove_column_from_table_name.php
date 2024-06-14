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
        Schema::table('incidents', function (Blueprint $table) {
            // $table->drop(['witness_id']);
            $table->dropColumn('witness_id');
            // $table->drop(['injured_id']);
            $table->dropColumn('injured_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('incidents', function (Blueprint $table) {
            $table->unsignedBigInteger('injured_id')->nullable();
            $table->foreign('injured_id')->references('id')->on('injured_people');
            $table->unsignedBigInteger('witness_id')->nullable();
            $table->foreign('witness_id')->references('id')->on('witness_details');
        });
    }
};
