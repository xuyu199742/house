<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateShortcutsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('shortcuts', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('status')->default(1)->comment('状态: 1-启用; 0-未启用');
            $table->string('photo')->nullable();
            $table->string('desc')->nullable();
            $table->string('link_data')->nullable();
            $table->string('order')->nullable()->default(0);
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
        Schema::dropIfExists('shortcuts');
    }
}
