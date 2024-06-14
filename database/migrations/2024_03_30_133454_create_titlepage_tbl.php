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
        Schema::create('titlepage_tbl', function (Blueprint $table) {
            $table->id('tpage_id'); // Define tpage_id as a primary key
            $table->date('insp_date');
            $table->string('verified_by');
            $table->string('ver_signature_image');
            $table->date('approval_date');
            $table->string('approved_by');
            $table->string('appr_signature_img');
            $table->unsignedBigInteger('user_id')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('titlepage_tbl');
    }
};
