<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateKindsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('kinds', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('title');			//Наименование вида
            $table->string('slug');				//Слаг вида
            $table->char('code', 16);				//Код вида
            $table->integer('section_id');		//id раздела услуг
            $table->integer('category_id');		//id категории услуги
            $table->string('keywords')->nullable(); //Ключевые слова
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
        Schema::dropIfExists('kinds');
    }
}
