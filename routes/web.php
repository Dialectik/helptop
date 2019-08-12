<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


//Общие маршруты
Route::get('/', 'GuestController@index')->name('welcome');
//Маршруты для работы со справочными материалами
Route::resource('/refer', 'ReferencesController');
//Маршрут страницы раздела
Route::resource('/section', 'SectionController');
//Маршрут страницы категории
Route::resource('/category', 'CategoryController');
//Маршрут страницы видов услуг
Route::resource('/kind', 'KindController');
//Маршрут для запросов данных из таблицы услуг
Route::post('/services/request', 'SRController@_request')->name('services.req');
//Маршрут для вывода следующих 50 записей из таблицы
Route::post('/services/request/offset', 'SRController@requestOffset')->name('services.req_offset');
//Маршрут страницы видов торгов
Route::resource('/biddingtype', 'BiddingTypeController');
//Маршрут страницы услуги
Route::resource('/service', 'ServiceController', ['except' => ['mysell', 'mybuy', 'mysellcreate', 'mybuycreate', 'myselledit', 'mybuyedit', 'destroymysell', 'destroymybuy', 'showuservice']]);
Route::get('/services/user/{id}', 'ServiceController@showuservice')->name('services.showuservice');
//Маршруты выбора города
Route::post('/city', 'CityController@index')->name('city.index');
//Маршрут корзины
Route::resource('/baskets', 'BasketsController');
//Маршрут для измненения пароля
Route::get('/myprofile/changepassword', 'MyprofileController@changePassword')->name('changepassword');
//Маршрут для формы контактов
Route::get('/contacts', 'ContactController@contactForm')->name('contacts');
//Маршрут для отправки письма администратору из контактной формы
Route::post('/sendmail', 'Ajax\ContactController@send');







//jQuery запросы
Route::get('/kind/edit/getcat', 'LLController@getCategory');	
Route::get('/kind/edit/getkind', 'LLController@getKind');
Route::get('/kind/edit/getcities', 'LLController@getCities');	//create - определение списка городов***	
Route::get('/kind/edit/getdistricts', 'LLController@getDistricts');	//create - определение списка районов**
Route::get('/kind/edit/getstreets', 'LLController@getStreets');	//edit - определение списка улиц, когда в области один такой город***
Route::get('/kind/edit/getstreetd', 'LLController@getStreetd');	//create - определение списка улиц, когда в области несколько одинаковых городов (в разных районах)***	
Route::get('/kind/edit/gethouse', 'LLController@getHouse');	//edit - определение списка домов на улице в городе, когда в области один такой город***
Route::get('/kind/edit/gethoused', 'LLController@getHoused');	//create - определение списка домов на улице в городе, когда в области несколько одинаковых городов (в разных районах)***







//Auth::routes();


//Route::get('storage/{filename}', function ($filename)
//{
//    $path = storage_path('public/' . $filename);
//
//    if (!File::exists($path)) {
//        abort(404);
//    }
//
//    $file = File::get($path);
//    $type = File::mimeType($path);
//
//    $response = Response::make($file, 200);
//    $response->header("Content-Type", $type);
//
//    return $response;
//});


//Маршруты для авторизованных пользователей
Route::group(['middleware' => 'auth'], function(){
	Route::post('logout', 'Auth\LoginController@logout')->name('logout');
	Route::get('/home', 'HomeController@index')->name('home');
	//Маршрут сделок
	Route::resource('/deals', 'DealsController', ['except' => ['prove', 'annul']]);
	Route::post('/deals/prove', 'DealsController@prove')->name('deals.prove');
	Route::post('/deals/annul', 'DealsController@annul')->name('deals.annul');
	//Маршрут сообщений
	Route::resource('/messages', 'MessagesController');
	//Маршрут для рейтинга
	Route::resource('/ratings', 'RatingsController');
	//Маршрут для настроек профиля
	Route::resource('/myprofile', 'MyprofileController', ['except' => ['changePassword']]);
	//Маршрут для счета
	Route::resource('/scores', 'ScoresController', ['except' => ['refill']]);
	Route::post('/scores/refill', 'ScoresController@refill')->name('scores.refill');
	//Маршрут страницы услуги
	Route::get('/service/mysell/list', 'ServiceController@mysell')->name('service.mysell');
	Route::get('/service/mysell/create', 'ServiceController@mysellcreate')->name('service.mysell.create');
	Route::get('/service/mysell/{id}/edit', 'ServiceController@myselledit')->name('service.mysell.edit');
	Route::delete('/service/mysell/destroy/{id}', 'ServiceController@destroymysell')->name('service.destroymysell');
	Route::get('/service/mybuy/list', 'ServiceController@mybuy')->name('service.mybuy');
	Route::get('/service/mybuy/create', 'ServiceController@mybuycreate')->name('service.mybuy.create');
	Route::get('/service/mybuy/{id}/edit', 'ServiceController@mybuyedit')->name('service.mybuy.edit');
	Route::delete('/service/mybuy/destroy/{id}', 'ServiceController@destroymybuy')->name('service.destroymybuy');
	//Маршрут для рекламы
	Route::resource('/blurbs', 'BlurbsController', ['except' => ['adversell', 'adverbuy']]);
	Route::get('/blurbs/adver/mysell', 'BlurbsController@adversell')->name('blurbs.adversell');
	Route::get('/blurbs/adver/mybuy', 'BlurbsController@adverbuy')->name('blurbs.adverbuy');
	
	
	
	
	
	
	
});





//Маршруты для гостей сайта
Route::group(['middleware' => 'guest', 'namespace'=>'Auth'], function(){
	//Маршруты аутентификации
	Route::get('/register', 'AuthController@registerForm')->name('register');
	Route::post('/register', 'AuthController@register');
	Route::get('/login', 'AuthController@loginForm')->name('login');
	Route::post('/login', 'AuthController@login')->name('login_post');
	// Activation user.
	Route::get('/activate', 'AuthController@activate');
	
	//URL для сброса пароля...
	//POST запрос для отправки email письма пользователю для сброса пароля
	Route::post('password/email', 'ForgotPasswordController@sendResetLinkEmail')->name('password.email');
	//ссылка для сброса пароля (можно размещать в письме)
	Route::get('password/reset', 'ForgotPasswordController@showLinkRequestForm')->name('password.request');
	//страница с формой для сброса пароля
	Route::get('password/reset/{token}', 'ResetPasswordController@showResetForm')->name('password.reset');
	//POST запрос для сброса старого и установки нового пароля
	Route::post('password/reset', 'ResetPasswordController@reset')->name('password.update');








	
	
	
	
});











//Маршруты для админов
Route::group(['prefix'=>'admin', 'namespace'=>'Admin', 'middleware' => 'admin'], function(){
	Route::get('/', 'DashboardController@index');
	//Маршруты для создания и редактирования разделов, категорий и видов услуг
	Route::resource('/sections', 'SectionsController', ['except' => ['update', 'destroy']]);
	Route::post('/sections/update', 'SectionsUpdateController@update')->name('sections.update');
	Route::post('/sections/destroy', 'SectionsDeleteController@destroy')->name('sections.destroy');
	Route::resource('/categories', 'CategoriesController', ['except' => ['update', 'destroy']]);
	Route::post('/categories/update', 'CategoriesUpdateController@update')->name('categories.update');
	Route::post('/categories/destroy', 'CategoriesDeleteController@destroy')->name('categories.destroy');
	Route::resource('/kinds', 'KindsController', ['except' => ['update', 'destroy']]);
	Route::post('/kinds/update', 'KindsUpdateController@update')->name('kinds.update');
	Route::post('/kinds/destroy', 'KindsDeleteController@destroy')->name('kinds.destroy');
	//Маршруты для работы с пользователями
	Route::resource('/users', 'UsersController', ['except' => ['editstatus', 'updatestatus']]);
	Route::get('/users/editstatus/{id}', 'UsersController@editstatus')->name('users.editstatus');
	Route::post('/users/updatestatus/new', 'UsersController@updatestatus')->name('users.updatestatus');
	//Маршруты для работы с услугами
	Route::resource('/services', 'ServicesController');
	//Маршрут для запросов данных из таблицы услуг
	Route::post('/services/request', 'ServiceRequestController@_request')->name('services.request');
	//Маршрут для вывода следующих 50 записей из таблицы
	Route::post('/services/request/offset', 'ServiceRequestController@requestOffset')->name('services.request_offset');
	//Маршрут для вывода предыдущих 50 записей из таблицы
	Route::post('/services/request/offset/return', 'ServiceRequestController@requestOffsetReturn')->name('services.request_offset_return');
	//Маршруты для работы с типами торгов
	Route::resource('/bidding_type', 'BiddingTypeController');
	//Маршруты для работы со справочными материалами
	Route::resource('/references', 'ReferencesController');
	//Маршруты для корректрировки тарифов выставления услуг
	Route::resource('/bidding_rates', 'BiddingRateController');
	//Маршруты для корректрировки тарифов рекламы услуг
	Route::resource('/blurb_types', 'BlurbTypeController');
	//Маршрут для рейтинга
	Route::resource('/ratingusers', 'RatingusersController');
	//Маршрут для счета
	Route::resource('/scoreusers', 'ScoreusersController', ['except' => ['showone', 'create']]);
	Route::get('/scoreusers/show/{id}', 'ScoreusersController@showone')->name('scoreusers.showone');
	Route::post('/scoreusers/create', 'ScoreusersController@create')->name('scoreusers.create');
	
	
	
	
	
	
	
	
	
	//jQuery запросы
	Route::get('/kinds/create/getcategory', 'LinkedListsController@getCategory');	
	Route::get('/kinds/edit/getcategory', 'LinkedListsController@getCategory');	
	Route::get('/services/index/getcat', 'LinkedListsController@getCat');	
	Route::get('/services/create/getcat', 'LinkedListsController@getCat');	
	Route::get('/services/edit/getcat', 'LinkedListsController@getCat');	
	Route::get('/services/index/getkind', 'LinkedListsController@getKind');		
	Route::get('/services/create/getkind', 'LinkedListsController@getKind');
	//Route::get('/services/create/getsercode', 'LinkedListsController@getSerCode');	//определение кода товара	
	Route::get('/services/create/getcities', 'LinkedListsController@getCities');	//create - определение списка городов***	
	Route::get('/services/edit/getcities', 'LinkedListsController@getCities');	//edit - определение списка городов***	
	Route::get('/services/index/getcities', 'LinkedListsController@getCities');	//index - определение списка городов***	
	Route::get('/services/create/getdistricts', 'LinkedListsController@getDistricts');	//create - определение списка районов***	
	Route::get('/services/edit/getdistricts', 'LinkedListsController@getDistricts');	//edit - определение списка районов***
	Route::get('/services/index/getdistricts', 'LinkedListsController@getDistricts');	//index - определение списка районов***
	Route::get('/services/create/getstreets', 'LinkedListsController@getStreets');	//create - определение списка улиц, когда в области один такой город***
	Route::get('/services/edit/getstreets', 'LinkedListsController@getStreets');	//edit - определение списка улиц, когда в области один такой город***
	Route::get('/services/create/getstreetd', 'LinkedListsController@getStreetd');	//create - определение списка улиц, когда в области несколько одинаковых городов (в разных районах)***
	Route::get('/services/edit/getstreetd', 'LinkedListsController@getStreetd');	//edit - определение списка улиц, когда в области несколько одинаковых городов (в разных районах)***
	Route::get('/services/create/gethouse', 'LinkedListsController@getHouse');	//create - определение списка домов на улице в городе, когда в области один такой город***
	Route::get('/services/edit/gethouse', 'LinkedListsController@getHouse');	//edit - определение списка домов на улице в городе, когда в области один такой город***
	Route::get('/services/create/gethoused', 'LinkedListsController@getHoused');	//create - определение списка домов на улице в городе, когда в области несколько одинаковых городов (в разных районах)***
	Route::get('/services/edit/gethoused', 'LinkedListsController@getHoused');	//edit - определение списка домов на улице в городе, когда в области несколько одинаковых городов (в разных районах)***
	Route::get('/services/edit/getkind', 'LinkedListsController@getKind');
	//Route::get('/services/edit/getsercode', 'LinkedListsController@getSerCode');	//определение кода товара	
	Route::get('/categories/create/getsectioncode', 'LinkedListsController@getSectionCode');	
	Route::get('/categories/edit/getsectioncode', 'LinkedListsController@getSectionCode');
	Route::get('/kinds/create/getcategorycode', 'LinkedListsController@getCategoryCode');
	Route::get('/kinds/edit/getcategorycode', 'LinkedListsController@getCategoryCode');	
});
	
	