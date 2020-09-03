<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddActionsToUserTable extends Migration
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
            $table->string('mark_red')->nullable();
            $table->string('mark_incomplete')->nullable();
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
            $table->dropColumn('mark_red');
            $table->dropColumn('mark_incomplete');
        });
    }
}
