<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BlurbType extends Model
{
    //ДОЧЕРНЯЯ связь - реклама
	public function blurbs()
    {
		return $this->hasMany(Blurb::class, 'blurb_type');		//имеет много
	}
	
	
	
	
	
	
}
