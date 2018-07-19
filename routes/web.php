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

/*Route::get('/', function () {
    return view('frontend.index');
});*/

Route::get('/', 'FrontEndController@index')->name('frontend.index');

Auth::routes();

// Route::get('/home', 'HomeController@index')->name('home');
Route::group(['middleware' => ['auth', 'web']], function () {

	Route::post('change-status', 'Controller@changeStatus')->name('change-status');
	
	Route::get('/dashboard', 'DashboardController@index')->name('dashboard');
	Route::post('users/list', ['as'=>'users.list', 'uses'=>'UsersController@list']);
	Route::resource('users', 'UsersController');
	Route::resource('roles', 'RolesController');

});
