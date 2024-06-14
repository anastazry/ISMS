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
        Schema::table('injured_people', function (Blueprint $table) {
            // Add user_id column as a foreign key to users table
            $table->unsignedBigInteger('user_id')->nullable();

            // Foreign key constraint
            $table->foreign('user_id')->references('id')->on('users')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('injured_people', function (Blueprint $table) {
            // Drop the foreign key constraint first
            $table->dropForeign(['user_id']);

            // Then drop the column
            $table->dropColumn('user_id');
        });
    }
};
