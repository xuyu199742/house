<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateHotsearchesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hotsearches', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('word');
            $table->boolean('hot')->default(false)->nullable();
            $table->string('link_data')->nullable();
            $table->integer('order')->default(0)->nullable();
            $table->dateTime('start')->nullable()->comment('生效时间');
            $table->dateTime('end')->nullable()->comment('失效时间');
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
        Schema::dropIfExists('hotsearches');
    }
}
