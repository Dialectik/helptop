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
            $table->string('name');
            $table->string('email')->unique();                  //почта пользователя (уникальный идентификатор)
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password')->nullable();
            $table->integer('is_admin')->default(0);            //переключатель админ-неадмин
            $table->integer('is_seller')->default(0);           //Продавец (доп. Регистрация)
            $table->integer('status_ban')->default(0);          //переключатель разбанен-забанен
            $table->boolean('activated')->default(0);           //Признак активированного пользователя (по умолчанию - не активирован)
            $table->string('avatar')->nullable();               //аватарка пользователя
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
