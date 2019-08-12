<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUkraine2sTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ukraine2s', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('region')->nullable();	//Область
			$table->string('district')->nullable();	//Район
			$table->string('city')->nullable();		//Город
			$table->string('index')->nullable();	//Индекс
			$table->string('street')->nullable();	//Улица
			$table->string('house', 700)->nullable();	//Дома
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
        Schema::dropIfExists('ukraine2s');
    }
}
