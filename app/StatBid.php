<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class StatBid extends Model
{
    //РОДИТЕЛЬСКАЯ связь - статистика
    public function statistics()
    {
		return $this->belongsTo(Statistics::class);  //принадлежит 
	}
	
	
	
	
	
	
	
}
