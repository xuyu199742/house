<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateHousesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('houses', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name')->nullable();
            $table->string('status')->default(0);
            $table->string('uuid')->unique();
            $table->text('desc')->nullable()->comment('项目介绍');
            $table->boolean('commentable')->default(true)->comment('是否开放评论');
            $table->string('photo')->nullable()->comment('封面图');
            $table->string('developer')->nullable()->comment('开发商');
            $table->string('property_management')->nullable()->comment('物业公司');
            $table->string('property_type')->nullable()->comment('物业类型');
            $table->string('service_price')->nullable()->comment('物业费');
            $table->bigInteger('number_of_year')->nullable()->comment('产权年限');
            $table->decimal('area', 20, 2)->nullable()->comment('占地面积');
            $table->decimal('house_area', 20, 2)->nullable()->comment('建筑面积');
            $table->decimal('plot_ratio', 20, 2)->nullable()->comment('容积率');
            $table->decimal('greening_rate', 20, 2)->nullable()->comment('绿化率');
            $table->string('parking')->nullable()->comment('停车位');
            $table->bigInteger('building_count')->nullable()->comment('楼栋数');
            $table->bigInteger('house_count')->nullable()->comment('户数');
            $table->text('level_desc')->nullable()->comment('楼层状况');
            $table->string('address')->nullable()->comment('项目地址');
            $table->decimal('price', 20, 2)->nullable()->comment('均价');
            $table->string('display_price')->nullable()->comment('展示价格');
            $table->string('sales_address')->nullable()->comment('售楼处地址');
            $table->string('sales_phone')->nullable()->comment('售楼处电话');
            $table->string('channel')->nullable()->comment('建筑类型');
            $table->bigInteger('district_id')->nullable()->comment('区属id');
            $table->string('district_name')->nullable()->comment('区属');
            $table->bigInteger('block_id')->nullable()->comment('板块id');
            $table->string('block_name')->nullable()->comment('板块');

            $table->date('open_at')->nullable()->comment('开盘时间');
            $table->double('latitude', 18, 14)->nullable()->comment('纬度');
            $table->double('longitude', 18, 14)->nullable()->comment('经度');

            $table->string('sale_status')->nullable()->comment('销售状态');
            $table->string('decorate')->nullable()->comment('装修风格');
            $table->text('search_meta')->nullable()->comment('搜索辅助');
            $table->boolean('is_top')->default(false)->comment('置顶');

            $table->text('around_traffic')->nullable()->comment('周边交通');
            $table->text('around_school')->nullable()->comment('周边学校');
            $table->text('around_shop')->nullable()->comment('周边商场');
            $table->text('around_bank')->nullable()->comment('周边银行');
            $table->text('around_hospital')->nullable()->comment('周边医院');
            $table->text('around_park')->nullable()->comment('周边公园');

            $table->bigInteger('total_view')->nullable()->default(0)->comment('浏览次数');
            $table->bigInteger('total_favor')->nullable()->default(0)->comment('关注人数');

            $table->bigInteger('price_from')->nullable()->comment('单价区间');
            $table->bigInteger('price_to')->nullable()->comment('单价区间');
            $table->bigInteger('amount_from')->nullable()->comment('总价区间');
            $table->bigInteger('amount_to')->nullable()->comment('总价区间');

            $table->bigInteger('area_from')->nullable()->comment('面积区间');
            $table->bigInteger('area_to')->nullable()->comment('面积区间');

            $table->string('search_keywords')->nullable()->comment('搜索关键词');

            $table->boolean('category_1')->default(false)->comment('热门房源');
            $table->boolean('category_2')->default(false)->comment('最新房源');
            $table->boolean('category_3')->default(false)->comment('即将预售');
            $table->boolean('category_4')->default(false)->comment('最新摇号');
            $table->boolean('category_5')->default(false)->comment('摇号剩余');

            $table->integer('room')->nullable()->comment('室');
            $table->integer('hall')->nullable()->comment('厅');
            $table->string('title')->nullable()->comment('标题');
            $table->string('orientation')->nullable()->comment('朝向');
            $table->string('building_type')->nullable()->comment('楼型');
            $table->date('years')->nullable()->comment('年代');
            $table->date('ownership')->nullable()->comment('产权');
            $table->date('community_id')->nullable()->comment('小区id');
            $table->boolean('elevator')->default(false)->comment('电梯');


            $table->unsignedBigInteger('user_id')->nullable()->comment('负责人');

            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('property_types', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('key')->unique();
            $table->string('name');
            $table->timestamps();
        });

        Schema::create('house_property', function (Blueprint $table) {
            $table->unsignedBigInteger('house_id');
            $table->unsignedBigInteger('property_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('house_property');
        Schema::dropIfExists('property_types');
        Schema::dropIfExists('houses');
    }
}
