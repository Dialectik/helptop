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



Route::get('/', 'GuestController@index')->name('welcome');


//Auth::routes();





//Маршруты для авторизованных пользователей
Route::group(['middleware' => 'auth'], function(){
	Route::post('logout', 'Auth\LoginController@logout')->name('logout');
	Route::get('/home', 'HomeController@index')->name('home');
	
	
	
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
	Route::resource('/users', 'UsersController');
	//Маршруты для работы с услугами
	Route::resource('/services', 'ServicesController');
	//Маршрут для запросов данных из таблицы услуг
	Route::post('/services/request', 'ServiceRequestController@_request')->name('services.request');
	
	Route::get('/kinds/create/getcategory', 'LinkedListsController@getCategory');	
	Route::get('/kinds/edit/getcategory', 'LinkedListsController@getCategory');	
	Route::get('/services/index/getcat', 'LinkedListsController@getCat');	
	Route::get('/services/create/getcat', 'LinkedListsController@getCat');	
	Route::get('/services/edit/getcat', 'LinkedListsController@getCat');	
	Route::get('/services/index/getkind', 'LinkedListsController@getKind');		
	Route::get('/services/create/getkind', 'LinkedListsController@getKind');
	Route::get('/services/create/getsercode', 'LinkedListsController@getSerCode');	//определение кода товара	
	Route::get('/services/edit/getkind', 'LinkedListsController@getKind');
	Route::get('/services/edit/getsercode', 'LinkedListsController@getSerCode');	//определение кода товара	
	Route::get('/categories/create/getsectioncode', 'LinkedListsController@getSectionCode');	
	Route::get('/categories/edit/getsectioncode', 'LinkedListsController@getSectionCode');
	Route::get('/kinds/create/getcategorycode', 'LinkedListsController@getCategoryCode');
	Route::get('/kinds/edit/getcategorycode', 'LinkedListsController@getCategoryCode');	
});
	
	