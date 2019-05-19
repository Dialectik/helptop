<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDistancesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('distances', function (Blueprint $table) {
            $table->bigIncrements('id');						
            $table->integer('user_id')->nullable();				//ID пользователя
            $table->integer('service_id')->nullable();			//ID услуги
            $table->integer('period_initial')->nullable();		//Период времени после сделки, когда может раньше всего быть предоставлена услуга
            $table->integer('period_deadline')->nullable();		//Период времени после сделки, после которого услуга уже не может быть предоставлена – сделка аннулируется
            $table->string('schedule')->nullable();				//График работы
            $table->string('note')->nullable();					//Примечание
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
        Schema::dropIfExists('distances');
    }
}
