<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name')->nullable();
            $table->boolean('is_admin')->default(false);
            $table->string('email')->nullable();
            $table->string('mobile')->nullable();
            $table->string('username')->nullable();
            $table->string('country_code')->nullable();
            $table->string('pure_phone_number')->nullable();
            $table->timestamp('wechat_updated_at')->nullable();
            $table->timestamp('mobile_updated_at')->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password')->nullable();
            $table->string('openid')->nullable();
            $table->string('avatar')->nullable();
            $table->string('gender')->default(0)->nullable();
            $table->string('language')->nullable();
            $table->string('country')->nullable();
            $table->string('city')->nullable();
            $table->string('province')->nullable();
            $table->string('session_key')->nullable();

            $table->string('profile_name')->nullable();
            $table->string('profile_id')->nullable();
            $table->string('qr_url')->nullable()->comment('群二维码');

            $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
}
