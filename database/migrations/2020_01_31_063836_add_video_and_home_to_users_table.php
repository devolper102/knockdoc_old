<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddVideoAndHomeToUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('user_metas', function (Blueprint $table) {
            //
             $table->string('willing_video')->nullable();
             $table->string('willing_home_visit')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('user_metas', function (Blueprint $table) {
            //
            
            $table->dropColumn('willing_video');
            $table->dropColumn('willing_home_visit');
        });
    }
}
