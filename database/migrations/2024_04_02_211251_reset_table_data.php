<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
               // Truncate the tables
            Schema::disableForeignKeyConstraints();
            DB::table('titlepage_tbl')->truncate();
            DB::table('hirarc_report_tbl')->truncate();
            DB::table('hirarc_tbl')->truncate();
            DB::table('hazard_identify_tbl')->truncate();
            DB::table('risk_assesment_tbl')->truncate();
            DB::table('control_tbl')->truncate();
            Schema::enableForeignKeyConstraints();
            
            // Reset auto-increment
            DB::statement("ALTER TABLE titlepage_tbl AUTO_INCREMENT = 1");
            DB::statement("ALTER TABLE hirarc_tbl AUTO_INCREMENT = 1");
            DB::statement("ALTER TABLE hazard_identify_tbl AUTO_INCREMENT = 1");
            DB::statement("ALTER TABLE risk_assesment_tbl AUTO_INCREMENT = 1");
            DB::statement("ALTER TABLE control_tbl AUTO_INCREMENT = 1");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
