<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DateTime;
use DateTimeZone;
use DateInterval;
use Auth;
use Carbon\Carbon;  //модуль конвертации дат
use App\BlurbType;
use App\Blurb;

class Score extends Model
{
    //указание данных, которые будут добавляться при реализации функции создания записи в БД
    //данный массив затем используется методом fill при добавлении записи
    protected $fillable = ['user_id'];
    
    //РОДИТЕЛЬСКАЯ связь - создание связи счета с пользователем
    public function user()
    {
		return $this->belongsTo(User::class);  //принадлежит 
	}
	
	//РОДИТЕЛЬСКАЯ связь - создание связи счета с услугой
    public function service()
    {
		return $this->belongsTo(Service::class);  //принадлежит
	}
	
	//РОДИТЕЛЬСКАЯ связь - создание связи счета с видом рекламы
//    public function blurbType()
//    {
//		return $this->belongsTo(BlurbType::class);  //принадлежит 
//	}
	
	
	
	
	
	
	//вывод вида рекламы из таблицы BlurbType
	public function getBlurbTitle(){
		$blurb_type_id = $this->service->blurb_type_id;
		return BlurbType::where('id', $blurb_type_id) != null ? BlurbType::where('id', $blurb_type_id)->pluck('title')->first() : null;
	}
	
	//вывод тарифа на публикацию из таблицы BiddingRate
	public function getRateBiddingTitle(){
		$rate_bidding_id = $this->service->rate_bidding_id;
		$bidding_type = $this->service->bidding_type;
		$rate_bidding_title = (isset($rate_bidding_id) && null != BiddingRate::where('id', $rate_bidding_id)) ? 'По тарифу "'.BiddingType::where('id', $bidding_type)->pluck('title')->first().'" - '.BiddingRate::where('id', $rate_bidding_id)->pluck('rate_bidding')->first().' грн' : null;
		return $rate_bidding_title;
	}
	
	//вывод кода услуги
	public function getServiceCode(){
		$service_id = $this->service_id;
		return Service::where('id', $service_id) != null ? Service::where('id', $service_id)->pluck('product_code_id')->first() : null;
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
	
	//Аксессор - изменяет формат даты для вывода на странице *** Формат 'Y-m-d H:i:s'
	public function getDateAttributeYmd($value, $offset)
	{
		$date_offset = timezone_name_from_abbr("", $offset, 1);			//Находит ближайшую (указанную в кавычках - если не указано ищет по смещению) аббревиатуру часового пояса в формате 'Europe/Kiev' по смещению в секундах, "1" - учитывает переход на летнее время
		$date = new Carbon($value, 'UTC');
		$date->setTimezone($date_offset);
		$dt = Carbon::createFromFormat('Y-m-d H:i:s', $date, $date_offset)->format('Y-m-d H:i:s');
		return $dt;
	}
    
    
    
    
}
