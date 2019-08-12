<?php

namespace App;

use App\Service;
use \Storage;
use Carbon\Carbon;  //модуль конвертации дат
use DateTime;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    //константы для значений забанен - разбанен
	const IS_BANNED = 1;
    const IS_ACTIVE = 0;
    
    //указание данных, которые будут добавляться при реализ. функции add (добавл. пользователя)
    //данный массив затем используется методом fill при добавлении пользователя
    protected $fillable = [
        'name', 'email', 'activated',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
    
    //ДОЧЕРНЯЯ связь - связь пользователя с услугами, которые он может предлагать на сайте
    public function services()
    {
		return $this->hasMany(Service::class);
	}
	
	//ДОЧЕРНЯЯ связь - личная информация
	public function personal()
    {
		return $this->hasOne(Personal::class);
	}
	
	//ДОЧЕРНЯЯ связь - счет пользователя
	public function score()
    {
		return $this->hasOne(Score::class);
	}
	
	//ДОЧЕРНЯЯ связь - сделки пользователя - продавца
    public function dealSeller()
    {
		return $this->hasMany(Deal::class, 'user_seller_id');
	}
	//ДОЧЕРНЯЯ связь - сделки пользователя - покупателя
    public function dealBuyer()
    {
		return $this->hasMany(Deal::class, 'user_buyer_id');
	}
	
	//ДОЧЕРНЯЯ связь - 	рейтинг и отзывы оцениваемого пользователя
	public function ratingRated()
    {
		return $this->hasMany(Rating::class, 'user_rated_id');
	}
	//ДОЧЕРНЯЯ связь - 	рейтинг и отзывы пользователя дающего оценку
	public function ratingAuditor()
    {
		return $this->hasMany(Rating::class, 'user_auditor_id');
	}
	
	//ДОЧЕРНЯЯ связь - 	история продавца 
	public function historySeller()
    {
		return $this->hasMany(History::class, 'user_seller_id');
	}
	//ДОЧЕРНЯЯ связь - 	история покупателя
	public function historyBuyer()
    {
		return $this->hasMany(History::class, 'user_buyer_id');
	}
	
	//ДОЧЕРНЯЯ связь - реклама
	public function blurbs()
    {
		return $this->hasMany(Blurb::class);
	}
		
	//ДОЧЕРНЯЯ связь - адреса предоставления услуг пользователем
	public function address()
    {
		return $this->hasMany(Address::class);
	}	
	
	//ДОЧЕРНЯЯ связь - промежутки времени в которые предоставляется услуга
	public function distance()
    {
		return $this->hasOne(Distance::class);
	}
	
	//ДОЧЕРНЯЯ связь - 	банк изображений
	public function images()
    {
		return $this->hasMany(Image::class);
	}

    
    //добавление нового пользователя
	public static function add($fields)
	{
		$user = new static;       //создать новый экземпляр класса
		$user->fill($fields);     //заполнить переменные экземпляра значениями из архива $fields
				
		$user->save();            //записать значения экземпляра в базу
		
		return $user;		      //вернуть ссылку на экземпляр класса
	}
    
    //редактирование пользователя
	public function edit($fields)
	{
		$this->fill($fields);     //обновить переменные экземпляра значениями из архива $fields
		
		$this->save();            //записать значения экземпляра в базу
	}
	
	//создание пароля
	public function generatePassword($password)
	{
		if($password != null)
		{
			$this->password = bcrypt($password);//хеширование пароля и присвоение
			$this->save();  //сохранение записи в ббазе
		}
	}
    
    //загрузка картинки аватара
	public function uploadAvatar($image)
	{
		if($image == null){return;}   //если картинка не загружена - вернутся
		
		$this->removeAvatar();//удаление старого аватара перед заменой на новый
		
		$filename = str_random(10) . '.' . $image->extension();  //генерация имени картинки 
		$image->storeAs('uploads/users', $filename);  //загрузка картинки в папку uploads/users и присвоение файлу картинки сгенерированного названия
		$this->avatar = $filename;  //присвоение картинки посту (присвоение картинки полю avatar в БД)
		$this->save();  //сохранение записи в базе
	}
	
	//удаление аватара
	public function removeAvatar()
	{
		if($this->avatar != null)    //если аватарка была у пользователя
		{
			Storage::delete('uploads/users/' . $this->avatar);  //удаление старой картинки
		}
	}
	
	//вывод картинки аватара
	public function getImage()
	{
		if($this->avatar == null)
		{
			return '/img/no-avatar.png';  //если нет аватарки выводить картинку по умолчанию
		}
		
		return '/uploads/users/' . $this->avatar;  //вывод аватарки на странице
	}
	
	//***ПЕРЕКЛЮЧАТЕЛЬ АДМИНА
	public function makeAdmin()  //назначение пользователя администратором
	{
		$this->is_admin = 1;
		$this->save();
	}
	public function makeNormal()//присвоения статуса обычного пользователя (не админа)
	{
		$this->is_admin = 0;
		$this->save();
	}
	public function toggleAdmin($value)//переключение административного статуса пользователя
	{
		if($value == null)
		{
			return $this->makeNormal();
		}
		
		return $this->makeAdmin();
	}
	
	//***ПЕРЕКЛЮЧАТЕЛЬ БАНА
	
	public function ban() //присвоения статуса забаненного пользователя
	{
		$this->status_ban = User::IS_BANNED;
		$this->save();
	}
	public function unbun() //разбанить пользователя
	{
		$this->status_ban = User::IS_ACTIVE;
		$this->save();
	}
	public function toggleBun($value) //переключатель "забанить/разбанить"
	{
		if($value == null)
		{
			return $this->unbun();
		}
		
		return $this->ban();
	}
    
       
    //удаление пользователя
	public function remove()
	{
		$this->removeAvatar();  //удаление аватара перед удалением пользов.
		$this->delete();
	}
    
	//вывод Отчества из связанной таблицы Personal
	public function getPatronymic()  {
		return $this->Personal != null ? $this->Personal->patronymic : null;
	}
	//вывод Фамилии из связанной таблицы Personal
	public function getLastName()  {
		return $this->Personal != null ? $this->Personal->last_name : null;
	}
	//вывод Описания фирмы из связанной таблицы Personal
	public function getDescription()  {
		return $this->Personal != null ? $this->Personal->description : null;
	}
	//вывод Пола из связанной таблицы Personal
	public function getSex()  {
		if(isset($this->Personal->sex)){
			$sex[0] = $this->Personal->sex;
			switch ($sex[0]) {
			    case 1:
			        $sex[1] = "Женский";
			        break;
			    case 2:
			        $sex[1] = "Мужской";
			        break;
			}
		}else{
			$sex[0] = null;
			$sex[1] = "- выберите пол -";
		}
		return $sex;
	}
	//вывод Семейного положения из связанной таблицы Personal
	public function getMaritalStatus()  {
		if(isset($this->Personal->marital_status)){
			$marital_status[0] = $this->Personal->marital_status;
			switch ($marital_status[0]) {
			    case 1:
			        $marital_status[1] = "Женат/За мужем";
			        break;
			    case 2:
			        $marital_status[1] = "Не в браке";
			        break;
			}
		}else{
			$marital_status[0] = null;
			$marital_status[1] = "- Вы в браке? -";
		}
		return $marital_status;
	}
	//вывод Наличия детей из связанной таблицы Personal
	public function getChildren()  {
		if(isset($this->Personal->children)){
			$children[0] = $this->Personal->children;
			switch ($children[0]) {
			    case 1:
			        $children[1] = "Есть";
			        break;
			    case 2:
			        $children[1] = "Нет";
			        break;
			}
		}else{
			$children[0] = null;
			$children[1] = "- Есть дети? -";
		}
		return $children;
	}
	//вывод Наличия автомобиля из связанной таблицы Personal
	public function getCar()  {
		if(isset($this->Personal->car)){
			$car[0] = $this->Personal->car;
			switch ($car[0]) {
			    case null:
			        $car[1] = "- Не указано -";
			        break;
			    case 1:
			        $car[1] = "Есть";
			        break;
			    case 2:
			        $car[1] = "Нет";
			        break;
			}
		}else{
			$car[0] = null;
			$car[1] = "- Не указано -";
		}
		return $car;
	}
	//вывод Номера телефона 
	public function getPhone()  {
		$phone = $this->phone;
		if($phone){
			$phone_output = "+38(".substr($phone, 0, 3).")".substr($phone, 3, 3)."-".substr($phone, 6, 2)."-".substr($phone, 8, 2);
			return $phone_output;
		}
		return $phone;
	}
	
    //Аксессор - изменяет формат даты для вывода на странице
	public function getDateBirthday()
	{
		if(isset($this->Personal->date_birthday)){
			$date_birthday_in = $this->Personal->date_birthday;
			$date = new Carbon($date_birthday_in);
			$dt = Carbon::parse($date);  //Разделить дату на компоненты
			$date_birthday = array("year" =>  $dt->year, "month" =>  $dt->month, "day" => $dt->day);
			return $date_birthday;
		}
	}
    
    
    
}
