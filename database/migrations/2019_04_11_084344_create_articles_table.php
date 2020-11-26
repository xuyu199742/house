<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateArticlesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('articles', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('title');
            $table->string('status')->nullable();
            $table->string('desc')->nullable();
            $table->unsignedBigInteger('media_id')->nullable();
            $table->string('photo')->nullable();
            $table->string('original_link')->nullable()->comment('原文链接');
            $table->string('category')->nullable();
            $table->string('link_data')->nullable();
            $table->boolean('commentable')->default(true)->nullable();
            $table->mediumText('content')->nullable();
            $table->timestamps();
        });

        Schema::create('article_house', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('article_id');
            $table->unsignedBigInteger('house_id');
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
        Schema::dropIfExists('article_house');
        Schema::dropIfExists('articles');
    }
}
