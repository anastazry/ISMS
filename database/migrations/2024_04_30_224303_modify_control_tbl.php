<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('control_tbl', function (Blueprint $table) {
            // Make 'opportunity' column nullable
            $table->string('opportunity')->nullable()->change();
            
            // Make 'new_control' column nullable
            $table->string('new_control')->nullable()->change();
            
            // Make 'status' column nullable
            $table->string('status')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('control_tbl', function (Blueprint $table) {
            // Revert the 'opportunity' column to non-nullable
            $table->string('opportunity')->nullable(false)->change();
            
            // Revert the 'new_control' column to non-nullable
            $table->string('new_control')->nullable(false)->change();
            
            // Revert the 'status' column to non-nullable
            $table->string('status')->nullable(false)->change();
        });
    }
};
