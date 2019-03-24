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

Route::get('/', function () {
    return view('welcome');
});







Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');




//Маршруты для админов
/*Route::group(['prefix'=>'admin', 'namespace'=>'Admin', 'middleware' => 'admin'], function(){
	Route::get('/', 'DashboardController@index');
	Route::resource('/categories', 'CategoriesController');
	Route::resource('/users', 'UsersController');
	Route::resource('/services', 'TextsController');	
});*/