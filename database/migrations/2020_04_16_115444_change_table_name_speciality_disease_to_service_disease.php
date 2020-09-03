<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeTableNameSpecialityDiseaseToServiceDisease extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::rename('speciality_disease', 'service_disease');
        Schema::table('service_disease', function (Blueprint $table) {
            //
            $table->renameColumn('speciality_id', 'service_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('speciality_disease', function (Blueprint $table) {
            //
        });
    }
}
