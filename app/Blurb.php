<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DateTime;
use DateTimeZone;
use Auth;
use Carbon\Carbon;  //модуль конвертации дат
use App\BlurbType;
use App\Service;
use App\ServiceDesc;
use App\BiddingType;

class Blurb extends Model
{
    //указание данных, которые будут добавляться при реализации функции создания записи в БД
    //данный массив затем используется методом fill при добавлении записи
    protected $fillable = ['user_id'];
    
    //РОДИТЕЛЬСКАЯ связь - создание связи рекламы с пользователем
    public function user()
    {
		return $this->belongsTo(User::class);  //принадлежит 
	}
	
	//РОДИТЕЛЬСКАЯ связь - создание связи рекламы с услугой
    public function service()
    {
		return $this->belongsTo(Service::class);  //принадлежит 
	}
    
    //РОДИТЕЛЬСКАЯ связь - Вид рекламы услуги
    public function blurbType()
    {
		return $this->belongsTo(BlurbType::class, 'blurb_type');  //принадлежит 
	}
	
	    
    
    
    
    //получение ID услуги
    public function getServiceID() {
		return $this->Service != null ? $this->Service->id : null;
	}
    
    //вывод названия услуги
    public function getServiceTitle() {
		return $this->Service != null ? $this->Service->title : null;
	}
    
    //вывод кода услуги
	public function getServiceCode(){
		$service_id = $this->service_id;
		return Service::where('id', $service_id) != null ? Service::where('id', $service_id)->pluck('product_code_id')->first() : null;
	}
	
	//вывод типа торгов услуги
    public function getServiceBT() {
		return $this->Service != null ? $this->Service->bidding_type : null;
	}
    
    //вывод вида рекламы из таблицы BlurbType
	public function getBlurbTitle(){
		$blurb_type = $this->blurb_type;
		return BlurbType::where('id', $blurb_type) != null ? BlurbType::where('id', $blurb_type)->pluck('title')->first() : null;
	}
	
	//вывод цены рекламы из таблицы BlurbType
	public function getBlurbPrice(){
		$blurb_type = $this->blurb_type;
		return BlurbType::where('id', $blurb_type) != null ? BlurbType::where('id', $blurb_type)->pluck('blurb_price')->first() : null;
	}
	
	//вывод периода рекламы из таблицы BlurbType
	public function getBlurbPeriod(){
		$blurb_type = $this->blurb_type;
		return BlurbType::where('id', $blurb_type) != null ? BlurbType::where('id', $blurb_type)->pluck('period_blurb')->first() : null;
	}
	
	//вывод названия типа торгов
    public function biddingTypeTitle()
    {
		$bidding_type = $this->Service != null ? $this->Service->bidding_type : null;
		return BiddingType::find($bidding_type) != null ? BiddingType::find($bidding_type)->title : null;
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
    
    //Мутатор - изменяет фромат даты для записи в базу  (предположительно часовой пояс пользователя 'Europe/Kiev')
	public function setDateOnAttribute($value, $offset)
	{
		$date_offset = timezone_name_from_abbr("", $offset, 1);			//Находит ближайшую (указанную в кавычках - если не указано ищет по смещению) аббревиатуру часового пояса в формате 'Europe/Kiev' по смещению в секундах, "1" - учитывает переход на летнее время
		$date = new DateTime($value, new DateTimeZone($date_offset));
		$date->format('Y-m-d H:i:sP');
		$date->setTimezone(new DateTimeZone('UTC'));
		$this->attributes['date_on_blurb'] = $date;
		$this->save();
	}
	public function setDateOffAttribute($value, $offset)
	{
		$date_offset = timezone_name_from_abbr("", $offset, 1);			//Находит ближайшую (указанную в кавычках - если не указано ищет по смещению) аббревиатуру часового пояса в формате 'Europe/Kiev' по смещению в секундах, "1" - учитывает переход на летнее время
		$date = new DateTime($value, new DateTimeZone($date_offset));
		$date->format('Y-m-d H:i:sP');
		$date->setTimezone(new DateTimeZone('UTC'));
		$this->attributes['date_off_blurb'] = $date;
		$this->save();
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

		return '/uploads/services/' . $image;  //если картинка есть - вывести картинку услуги
	}
    
    
}
