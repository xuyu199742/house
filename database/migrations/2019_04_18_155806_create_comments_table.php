<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCommentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('comments', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('commentable_type')->nullable();
            $table->unsignedBigInteger('commentable_id')->nullable();
            $table->unsignedBigInteger('parent_id')->nullable();
            $table->text('content');
            $table->string('nickname')->nullable();
            $table->string('avatar')->nullable();
            $table->string('status')->nullable();
            $table->boolean('approved')->default(false);
            $table->string('audit_desc')->nullable()->comment('审核原因');
            $table->string('ip')->nullable();
            $table->boolean('elite')->default(false)->comment('精华');
            $table->unsignedBigInteger('user_id')->nullable();
            $table->string('memo')->nullable();
            $table->integer('like_count')->default(0);
            $table->integer('tread_count')->default(0);
            $table->timestamps();
            $table->softDeletes();
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('comments');
    }
}
