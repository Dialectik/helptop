<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Bidding extends Model
{
    //РОДИТЕЛЬСКАЯ связь - услуга
    public function service()
    {
		return $this->belongsTo(Service::class);  //принадлежит 
	}
	
	
	
	
}
