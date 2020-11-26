<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTabsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tabs', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name')->nullable();
            $table->string('photo')->nullable();
            $table->string('photo_selected')->nullable();
            $table->string('link_type')->nullable();
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
        Schema::dropIfExists('tabs');
    }
}
