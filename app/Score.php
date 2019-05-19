<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Score extends Model
{
    //РОДИТЕЛЬСКАЯ связь - создание связи счета с пользователем
    public function user()
    {
		return $this->belongsTo(User::class);  //принадлежит 
	}
    
    
    
    
}
