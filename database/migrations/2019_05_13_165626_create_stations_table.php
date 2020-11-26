<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('stations', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('subway_id');
            $table->string('name');
            $table->integer('status')->default(1);
            $table->double('latitude', 18, 14)->nullable()->comment('纬度');
            $table->double('longitude', 18, 14)->nullable()->comment('经度');
            $table->timestamps();
        });

        Schema::create('house_station', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('house_id');
            $table->unsignedBigInteger('station_id');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('house_station');
        Schema::dropIfExists('stations');
    }
}
