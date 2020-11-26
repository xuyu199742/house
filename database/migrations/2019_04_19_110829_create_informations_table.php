<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInformationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('informations', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('title');
            $table->mediumText('content');
            $table->string('type')->nullable();
            $table->string('photo')->nullable();
            $table->string('link')->nullable();
            $table->string('category')->nullable();
            $table->unsignedBigInteger('house_id')->nullable();
            $table->boolean('notify')->default(false);
            $table->string('message_title')->nullable();
            $table->text('message_content')->nullable();
            $table->unsignedBigInteger('media_id')->nullable();
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
        Schema::dropIfExists('informations');
    }
}
