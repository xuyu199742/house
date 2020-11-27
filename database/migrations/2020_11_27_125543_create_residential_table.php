<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateResidentialTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('residential', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string("name")->nullable();
            $table->string("alias")->nullable();
            $table->string("type")->nullable();
            $table->string("architectural_age")->nullable();
//            $table->bigInteger('number_of_year')->nullable()->comment('产权年限');
//            $table->decimal('area', 20, 2)->nullable()->comment('占地面积');
//            $table->decimal('plot_ratio', 20, 2)->nullable()->comment('容积率');
//            $table->decimal('greening_rate', 20, 2)->nullable()->comment('绿化率');
            $table->string('parking')->nullable()->comment('停车位');
            $table->string('photo')->nullable()->comment('封面图');
            $table->string('park_money')->nullable()->comment('停车费');
            $table->string('park_proportion')->nullable()->comment('车位比例');
            $table->string('address')->nullable()->comment('小区地址');
            $table->string('developer')->nullable()->comment('开发商');
            $table->string('property_phone')->nullable()->comment('物业联系电话');
            $table->string('property_address')->nullable()->comment('物业地址');
//            $table->double('latitude', 18, 14)->nullable()->comment('纬度');
//            $table->double('longitude', 18, 14)->nullable()->comment('经度');
            $table->bigInteger('building_count')->nullable()->comment('楼栋数');
            $table->bigInteger('house_count')->nullable()->comment('户数');
            $table->unsignedBigInteger('properties_id')->nullable();

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
        Schema::dropIfExists('residential');
    }
}
