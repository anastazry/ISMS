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
            $table->string('verified_by')->nullable()->change();
            $table->date('approval_date')->nullable()->change();
            $table->date('verification_date')->nullable()->change();
            $table->string('approved_by')->nullable()->change();
            $table->string('appr_signature_img')->nullable()->change();
            $table->string('ver_signature_image')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
