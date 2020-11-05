<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInseeLocalisationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('insee_localisations', function (Blueprint $table) {
            $table->id();
            $table->string('insee_city_code')->index('insee_code');
            $table->string('city_name')->index('city_name');
            $table->string('city_name_uppercase')->index('city_name_uppercase');
            $table->string('city_zipcode')->index('zipcode');
            $table->string('city_name_normalize')->nullable();
            $table->string('city_locality_name_normalize')->nullable();
            $table->string('department_code')->index('department_code');
            $table->string('department_name');
            $table->string('region_code')->index('region_code');
            $table->string('region_name');
            $table->decimal('lat', 10,8)->nullable();
            $table->decimal('lng', 11,8)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('insee_localisation');
    }
}
