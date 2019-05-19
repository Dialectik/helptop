<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Deal extends Model
{
    //РОДИТЕЛЬСКАЯ связь - создание связи сделки с пользователем
    public function user()
    {
		return $this->belongsTo(User::class);  //принадлежит 
	}
    
    
    //ДОЧЕРНЯЯ связь - история
	public function history()
    {
		return $this->hasOne(History::class);
	}
    
    
}
