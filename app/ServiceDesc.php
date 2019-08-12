<?php

namespace App;

use \Storage;
use Auth;
use App\Service;
use Carbon\Carbon;  //модуль конвертации дат
use Illuminate\Database\Eloquent\Model;

class ServiceDesc extends Model
{
    
    //РОДИТЕЛЬСКАЯ связь - основной класс услуги
    public function service()
    {
		return $this->belongsTo(Service::class);  //принадлежит 
	}

	//Доступ к дате начала публикации
	public function getServiceDateOn()
    {
		return $this->service != null ? $this->service->date_on : null;
	}
	
	//Доступ к дате окончания публикации
	public function getServiceDateOff()
    {
		return $this->service != null ? $this->service->date_off : null;
	}
	
	//Доступ к названию услуги
	public function getServiceTitle()
    {
		return $this->service != null ? $this->service->title : null;
	}
	
	//вывод названия вида услуги
    public function getKindTitle()
    {
		return $this->service != null ? $this->service->getKindTitle() : null;
	}

	//вывод картинки
	public function getImage()
	{
		$id = $this->service_id;
		$image = ServiceDesc::where('service_id', $id)->pluck('image')->first();
		if($image == null)
		{
			return '/img/no-image.png';     //если у услуги нет картинки - загрузить по умолчанию
		}
//		return Storage::url('/uploads/' . $image);  //если картинка есть - вывести картинку услуги
		return '/uploads/' . $image;  //если картинка есть - вывести картинку услуги
	}
	
		//Аксессор - изменяет формат даты для вывода на странице
	public function getDateAttribute($value, $offset)
	{
		$date_offset = timezone_name_from_abbr("", $offset, 1);			//Находит ближайшую (указанную в кавычках - если не указано ищет по смещению) аббревиатуру часового пояса в формате 'Europe/Kiev' по смещению в секундах, "1" - учитывает переход на летнее время
		$date = new Carbon($value, 'UTC');
		$date->setTimezone($date_offset);
		$dt = Carbon::createFromFormat('Y-m-d H:i:s', $date, $date_offset)->format('d-m-Y H:i:s ');
		return $dt;
	}



}
