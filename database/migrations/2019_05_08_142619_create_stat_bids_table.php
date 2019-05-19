<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStatBidsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('stat_bids', function (Blueprint $table) {
            $table->bigIncrements('id');						
            $table->integer('statistics_id');					//ID статистического пула
            $table->integer('kind_id')->nullable();				//ID вида услуг
            $table->integer('kind_sum')->nullable();			//Суммы по каждому виду услуг зафиксированных случаев в сутки для определенного вида торгов
            $table->tinyInteger('bidding_type')->nullable();	//ID Типа торгов
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
        Schema::dropIfExists('stat_bids');
    }
}
