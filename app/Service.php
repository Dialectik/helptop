<?php

namespace App;

use DateTime;
use DateTimeZone;
use Auth;
use Carbon\Carbon;  //модуль конвертации дат
use \Storage;
use App\ServiceDesc;
use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;  //модуль формирования слагов
use Illuminate\Database\Eloquent\Collection;

class Service extends Model
{
    use Sluggable;
    
    //const IS_DRAFT = 0;
    //const IS_PUBLIC = 1;
    
    //указание данных, которые будут добавляться при реализации функции add (добавление поста)
    //данный массив затем испол зуется методом fill при добавлении поста
    protected $fillable = ['title', 'period', 'section_id', 'category_id', 'kind_id', 'bidding_type', 'product_code_id'];
    
    //РОДИТЕЛЬСКАЯ связь - создание связи услуги с разделом
    public function section()
    {
		return $this->belongsTo(Section::class);  //принадлежит разделу
	}
    
    //РОДИТЕЛЬСКАЯ связь - создание связи услуги с категорией
    public function category()
    {
		return $this->belongsTo(Category::class);  //принадлежит категории
	}
	
	//РОДИТЕЛЬСКАЯ связь - создание связи услуги с видом услуг
    public function kind()
    {
		return $this->belongsTo(Kind::class);  //принадлежит виду услуг
	}
		
	//РОДИТЕЛЬСКАЯ связь - создание связи услуги с пользователем
	public function author()
	{
		return $this->belongsTo(User::class, 'user_id');  //принадлежит пользователю
	}
	
	//РОДИТЕЛЬСКАЯ связь - типы торгов
	public function biddingType()
	{
		return $this->belongsTo(BiddingType::class, 'bidding_type');  //принадлежит типу торгов
	}
	
	
	
	//ДОЧЕРНЯЯ связь - торги
	public function biddings()
    {
		return $this->hasMany(Bidding::class);
	}
	
	//ДОЧЕРНЯЯ связь - корзина
	public function baskets()
    {
		return $this->hasMany(Basket::class);		//имеет много
	}
	
	//ДОЧЕРНЯЯ связь - реклама
	public function blurbs()
    {
		return $this->hasMany(Blurb::class);		//имеет много
	}
	
	//ДОЧЕРНЯЯ связь - описание услуг
	public function serviceDesc()
    {
		return $this->hasOne(ServiceDesc::class);	//имеет одного
	}
	
	//ДОЧЕРНЯЯ связь - адреса предоставления услуг
	public function address()
    {
		return $this->hasMany(Address::class);		//имеет много
	}
	
	//ДОЧЕРНЯЯ связь - периоды предоставления услуг
	public function distance()
    {
		return $this->hasOne(Distance::class);		//имеет одного
	}
	
	//ДОЧЕРНЯЯ связь - изображения
	public function images()
    {
		return $this->hasMany(Image::class);		//имеет много
	}
	

	
	//создание связи избранных услуг с пользователями
	public function favorites()
	{
		return $this->belongsToMany(  //принадлежит многим
			User::class,
			'favorites', //ссылка на отдельную таблицу связи многих пользователей со многими текстами
			'service_id',   //id услуг (данного класса) в указанной таблице
			'user_id'    //id пользователей (связанного класса) в указанной таблице
		);
	}
        
    //применение функции френдли-ссылок на страницы
	public function sluggable()
    {
        return [
            'slug' => [
                'source' => 'title'
            ]
        ];
    }
    
    //добавление услуги
    public static function add($fields)
    {
		
		$service = new static;   //создание экземпляра класса
		$service->fill($fields); //заполнение переменных класса значенимями из архива $fields
		$service->user_id = Auth::user()->id;


		
//		if(isset($fields['user_id'])){
//			$service->user_id = $fields['user_id'];
//		}else{
//			$service->user_id = 1;
//		}
		
		$service->save();
		
		return $service;
		
	}
	
	//изменение услуги
	public function edit($fields)
	{
		$this->fill($fields);
		$this->save();
	}
	
	//удаление услуги
	public function remove()
	{
		$this->removeImage();  // Удалить картинку услуги до удаления услуги
		$id = $this->id;
		ServiceDesc::where('service_id', $id)->delete(); //Удалить запись в связанной таблице ServiceDesc
		Distance::where('service_id', $id)->delete(); //Удалить запись в связанной таблице Distance
		$this->delete(); //Удалить услугу
	}
	

	//присвоение категории услуге
	public function setCategory($id)
	{
		if($id == null) {return;}   //если не выбрана категория - вернуться
		$this->category_id = $id;   //сохранить айди выбранной категории
		$this->save();              //сохранить запись в базу
	}
	
	//синхронизация массивов идентификаторов тегов и постов
//	public function setTags($ids)
//	{
//		if($ids == null){return;}
//		
//		$this->tags()->sync($ids);
//	}
	
	//ПЕРЕКЛЮЧАТЕЛЬ РЕКОМЕНДОВАННЫХ УСЛУГ
	public function setFeatured()  //присвоение свойства "рекомендованные"
	{
		$this->is_featured = 1;
		$this->save();
	}
	public function setStandart()  //удаление свойства "рекомендованные"
	{
		$this->is_featured = 0;
		$this->save();
	}
	public function toggleFeatured($value)  //переключение свойства "рекомендованные"
	{
		if($value == null)
		{
			return $this->setStandart();
		}
		
		return $this->setFeatured();
	}
	
	

	
	
	//Мутатор - изменяет фромат даты для записи в базу  (предположительно часовой пояс пользователя 'Europe/Kiev')
	public function setDateOnAttribute($value, $offset)
	{
//		$date = Carbon::createFromFormat('d-m-Y H:i:s', $value, 'Europe/Kiev')->format('Y-m-d H:i:s');
//		$dateUTC = Carbon::parse($date, 'UTC');
		$date_offset = timezone_name_from_abbr("", $offset, 1);			//Находит ближайшую (указанную в кавычках - если не указано ищет по смещению) аббревиатуру часового пояса в формате 'Europe/Kiev' по смещению в секундах, "1" - учитывает переход на летнее время
		$date = new DateTime($value, new DateTimeZone($date_offset));
		$date->format('Y-m-d H:i:sP');
		$date->setTimezone(new DateTimeZone('UTC'));
		$this->attributes['date_on'] = $date;
		$this->save();
	}
	public function setDateOffAttribute($value, $offset)
	{
//		$date = Carbon::createFromFormat('d-m-Y H:i:s', $value, 'Europe/Kiev')->format('Y-m-d H:i:s');
//		$dateUTC = Carbon::parse($date, 'UTC');
		$date_offset = timezone_name_from_abbr("", $offset, 1);			//Находит ближайшую (указанную в кавычках - если не указано ищет по смещению) аббревиатуру часового пояса в формате 'Europe/Kiev' по смещению в секундах, "1" - учитывает переход на летнее время
		$date = new DateTime($value, new DateTimeZone($date_offset));
		$date->format('Y-m-d H:i:sP');
		$date->setTimezone(new DateTimeZone('UTC'));
		$this->attributes['date_off'] = $date;
		$this->save();
	}
	
	//Аксессор - изменяет формат даты для вывода на странице
	public function getDateAttribute($value, $offset)
	{
		
		//$value_s = date_format($value, 'Y-m-d H:i:s');
		$date_offset = timezone_name_from_abbr("", $offset, 1);			//Находит ближайшую (указанную в кавычках - если не указано ищет по смещению) аббревиатуру часового пояса в формате 'Europe/Kiev' по смещению в секундах, "1" - учитывает переход на летнее время
		
//		$date = new DateTime($value, new DateTimeZone('UTC'));
//		$date->format('d-m-Y H:i:sP');
//		$date->setTimezone(new DateTimeZone($date_offset));
		$date = new Carbon($value, 'UTC');
		$date->setTimezone($date_offset);
		//$dt = Carbon::parse($date);
		//return $dt->day.'-'.$dt->month.'-'.$dt->year.'  '.$dt->hour.':'.$dt->minute.':'.$dt->second;
		$dt = Carbon::createFromFormat('Y-m-d H:i:s', $date, $date_offset)->format('d-m-Y H:i:s ');
		return $dt;
	}
	
	
	//вывод названия раздела
    public function getSectionTitle()
    {
		return $this->section != null ? $this->section->title : null;
	}
	//Вывод категории услуги
	public function getCategoryTitle()
    {
        return ($this->category != null) 
                ?   $this->category->title
                :   'Нет категории';
    }
    //вывод айди категории для данной услуги
    public function getCategoryID()
    {
        return $this->category != null ? $this->category->id : null;
    }
    //вывод названия вида услуги
    public function getKindTitle()
    {
		return $this->kind != null ? $this->kind->title : null;
	}
    //вывод названия типа торгов
    public function biddingTypeTitle()
    {
		return $this->biddingType != null ? $this->biddingType->title : null;
	}
    
    
    
    //вывод краткого описания услуги из связанной таблицы serviceDesc
    public function getContent()
    {
		return $this->serviceDesc != null ? $this->serviceDesc->content : null;
	}
    //вывод полного описания услуги из связанной таблицы serviceDesc
    public function getDescription()
    {
		return $this->serviceDesc != null ? $this->serviceDesc->description : null;
	}
    //вывод объема и структуры из связанной таблицы serviceDesc
    public function getValueService()
    {
		return $this->serviceDesc != null ? $this->serviceDesc->value_service : null;
	}
	//вывод дополнительных материалов к услуге из связанной таблицы serviceDesc
    public function getAddMaterials()
    {
		return $this->serviceDesc != null ? $this->serviceDesc->add_materials : null;
	}
	
	
	//вывод начального срока предоставления услуги из связанной таблицы Distance
	public function getPeriodInitial(){
		return $this->Distance != null ? $this->Distance->period_initial : null;
	}
	//вывод конечного срока предоставления услуги из связанной таблицы Distance
	public function getPeriodDeadline(){
		return $this->Distance != null ? $this->Distance->period_deadline : null;
	}
	//вывод расписание предоставления услуги из связанной таблицы Distance
	public function getPeriodSchedule(){
		return $this->Distance != null ? $this->Distance->schedule : null;
	}
    
   
    
    
    
    //вывод даты для на странице в определенном формате 
    public function getDate()
    {
		return Carbon::createFromFormat('d/m/y', $this->date)->format('F d, Y');
	}
	
	
	// ++++++++
	//Проверка наличия максимального значения из предыдущих
	public function hasPrevious()
	{
		return self::where('id', '<', $this->id)->max('id');
	}
		
	//Вернуть максимальное значение из предыдущих
	public function getPrevious()
	{
		$postID = $this->hasPrevious();
		return self::find($postID);
	}
    	
    	
	//Проверка наличия минимального значения из следующих
	public function hasNext()
	{
		return self::where('id', '>', $this->id)->min('id');
	}
	
	//Вернуть минимальное значение из следующих
	public function getNext()
	{
		$postID = $this->hasNext();
		return self::find($postID);
	}
//	
//	
//	public function related()
//	{
//		return self::all()->except($this->id);
//	}
	// ++++++++
	
	
	//проверка наличия у услуги категории
//	public function hasCategory()
//	{
//		return $this->category != null ? true : false;
//	}
	
	//запрос данных по просмотрам
	public static function getPopularPosts()
	{
		return self::orderBy('views', 'desc')->take(3)->get();
	}
	
	//запрос данных по популярным услугам
	public static function getFeaturedPosts()
	{
		return self::where('is_featured', 1)->take(3)->get();
	}
	
	//запрос данных по последним услугам
	public static function getRecentPosts()
	{
		return self::orderBy('date_on', 'desc')->take(4)->get();
	}
	

	
	    	    //вывод картинки
	public function getImage()
	{
		$id = $this->id;
		$image = ServiceDesc::where('service_id', $id)->pluck('image')->first();
		
		if($image == null)
		{
			return '/img/no-image.png';     //если у услуги нет картинки - загрузить по умолчанию
		}
		
		
		return Storage::url('/uploads/' . $image);  //если картинка есть - вывести картинку услуги
	}
	
	
       	//загрузка картинки услуги
	public function uploadImage($image)
	{
		if($image == null){return;}   //если картинка не загружена - вернуться
		
		$this->removeImage();//удаление старой картинки перед заменой на новую
		
		$filename = str_random(20) . '.' . $image->extension();  //генерация имени картинки 
		$image->storeAs('uploads', $filename);  //загрузка картинки в папку uploads и присвоение файлу картинки сгенерированного названия
		
		$existing_desc = ServiceDesc::where('service_id', $this->id)->pluck('service_id')->first(); //Поиск в таблице доп описания записи для текущей услуги
		
		//Если записи нет (и значит нет записи о загруженной картинке)
		if(!$existing_desc){
			$new_image = new ServiceDesc;         //Создание нового объекта Описания услуги для сохранения картинки и ID услуги
			$new_image->service_id = $this->id;
			$new_image->image = $filename;  //присвоение имени файла картинки соответствующей записи доп описания услуги (присвоение картинки полю image в БД)
			$new_image->save();  //сохранение записи в дополнительной таблице с картинкой услуги
		}else{
			//Поиск существующей записи
			$id = ServiceDesc::where('service_id', $this->id)->pluck('id')->first();
			$new_i = ServiceDesc::find($id);
			//присвоение имени файла картинки соответствующей записи доп описания услуги (присвоение картинки полю image в БД)
			$new_i->image = $filename;   
			$new_i->save();  //сохранение записи в дополнительной таблице с картинкой услуги
		}
		
	}
    
        //удаление картинки
	public function removeImage()
	{
		$id = $this->id;
		$image = ServiceDesc::where('service_id', $id)->pluck('image')->first();
		if($image != null)    //если картинка была у услуги
		{
			Storage::delete('uploads/' . $image);  //удаление старой картинки
			ServiceDesc::where('service_id', $id)->image = null;  //Убрать из связанной таблицы ServiceDesc название удаленной картинки
		}
		
	}
	
	//Увеличитель просмотров
	public function addViews()  
	{
		$id = $this->id;
		$sd = ServiceDesc::where('service_id', $id)->pluck('id')->first();
		if($sd != null){
			$view = ServiceDesc::find($id);
			$view->views += 1;
			$view->save();				//сохранение записи о просмотрах в дополнительной таблице
		}
	}
    
    
}