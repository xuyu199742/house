<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTagsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tags', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->string('color')->nullable();
            $table->string('text_color')->nullable();
            $table->string('type')->nullable();
            $table->boolean('enable')->default(true);
            $table->timestamps();
        });

        Schema::create('house_tag', function (Blueprint $table) {
            $table->integer('house_id');
            $table->integer('tag_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('house_tag');
        Schema::dropIfExists('tags');
    }
}
