<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAddressesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('addresses', function (Blueprint $table) {
            $table->bigIncrements('id');					
            $table->integer('user_id')->nullable();			//ID пользователя
            $table->integer('service_id')->nullable();		//ID услуги
            $table->string('country')->nullable();			//Страна
            $table->string('region')->nullable();			//Область
            $table->string('district')->nullable();			//Район
            $table->string('city')->nullable();				//Город
            $table->string('index')->nullable();			//Индекс
            $table->string('street')->nullable();			//Улица
            $table->char('house', 16)->nullable();			//Дом
            $table->string('note')->nullable();				//Примечание
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
        Schema::dropIfExists('addresses');
    }
}
