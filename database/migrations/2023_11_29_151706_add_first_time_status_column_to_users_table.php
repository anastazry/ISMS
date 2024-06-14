<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFirstTimeStatusColumnToUsersTable extends Migration
{
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            // Change 'int' to 'integer'
            $table->integer('first_time_status')->default(1);
            $table->integer('accessToken')->default(1);
            $table->string('profile_photo')->nullable();
        });
    }

    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('first_time_status');
            $table->dropColumn('accessToken');
            $table->dropColumn('profile_photo');
        });
    }
}
