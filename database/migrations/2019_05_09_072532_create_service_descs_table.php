<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateServiceDescsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('service_descs', function (Blueprint $table) {
            $table->bigIncrements('id');				
            $table->integer('service_id');					//ID услуги
            $table->text('content')->nullable();                      	//Полное описание услуги
            $table->text('description')->nullable();      	//Краткое описание услуги
            $table->text('value_service')->nullable();      //Объем одной единицы услуги (описательно)
            $table->text('add_materials')->nullable();      //Дополнительные материалы, не входящие в стоимость услуги (количество и приблизительная стоимость на единицу услуги)
            $table->string('image')->nullable();          	//Картинка для услуги
            $table->integer('views')->default(0);         	//Количество просмотров
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
        Schema::dropIfExists('service_descs');
    }
}
