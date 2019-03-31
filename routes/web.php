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
/*Route::group(['prefix'=>'admin', 'namespace'=>'Admin', 'middleware' => 'admin'], function(){
	Route::get('/', 'DashboardController@index');
	Route::resource('/categories', 'CategoriesController');
	Route::resource('/users', 'UsersController');
	Route::resource('/services', 'TextsController');	
});*/