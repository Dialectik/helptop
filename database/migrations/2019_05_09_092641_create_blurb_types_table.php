<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBlurbTypesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('blurb_types', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('title');						//Название вида рекламы
            $table->string('slug');							//Слаг названия рекламы
            $table->tinyInteger('code');					//Код вида рекламы
            $table->integer('blurb_price')->nullable();		//Стоимость вида рекламы
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
        Schema::dropIfExists('blurb_types');
    }
}
