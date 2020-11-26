<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSponsorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sponsors', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('status')->default(1)->nullable()->comment('状态: 1-启用; 0-未启用');
            $table->string('position')->nullable();
            $table->string('sub_position')->nullable();
            $table->string('photo')->nullable();
            $table->string('title')->nullable();
            $table->string('desc')->nullable();
            $table->string('link_type')->nullable()->comment('链接类型: 网页, 小程序内页面');
            $table->string('link_data')->nullable();
            $table->integer('order')->nullable()->default(0);
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
        Schema::dropIfExists('sponsors');
    }
}
