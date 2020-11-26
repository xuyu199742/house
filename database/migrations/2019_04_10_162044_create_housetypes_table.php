<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateHousetypesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('housetypes', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('house_id');
            $table->string('title');
            $table->string('sale_status')->nullable()->comment('销售状态');
            $table->string('desc')->nullable()->comment('户型解读');
            $table->text('photos')->nullable()->comment('更多图');
            $table->string('area')->nullable()->comment('建筑面积');
            $table->string('real_area')->nullable()->comment('使用面积');
            $table->string('orientation')->nullable()->comment('朝向');
            $table->string('price')->nullable()->comment('售价');
            $table->string('price_type')->nullable()->comment('售价类型, 平米(unit) 或 套(total)');
            $table->integer('bedroom_count')->default(0)->comment('卧室');
            $table->integer('kitchen_count')->default(0)->comment('厨房');
            $table->integer('bathroom_count')->default(0)->comment('卫生间');
            $table->integer('livingroom_count')->default(0)->comment('客厅');
            $table->integer('balcony_count')->default(0)->comment('阳台');
            $table->timestamps();

            $table->foreign('house_id')
                ->references('id')
                ->on('houses')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('housetypes');
    }
}
