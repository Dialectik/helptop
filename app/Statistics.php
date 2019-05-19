<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Statistics extends Model
{
    //ДОЧЕРНЯЯ связь - Статистика по торгам и видам
	public function statBid()
    {
		return $this->hasMany(StatBid::class);  //имеет много
	}
    
    
    
    
    
    
    
    
}
