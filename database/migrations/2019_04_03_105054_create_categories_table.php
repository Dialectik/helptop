<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('categories', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('title');					//Наименование категории
            $table->string('slug');						//Слаг категории
            $table->char('code', 8);					//Код категории
            $table->integer('section_id');  			//id раздела услуг
            $table->string('keywords')->nullable(); 	//Ключевые слова
            $table->string('description')->nullable();	//Описание для тега
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
        Schema::dropIfExists('categories');
    }
}
