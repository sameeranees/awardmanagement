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


//Route::get('/', 'FrontEndController@index')->name('frontend.index');

Auth::routes();

 Route::get('/home', 'HomeController@index')->name('home');
Route::group(['middleware' => ['auth', 'web']], function () {

	Route::post('change-status', 'Controller@changeStatus')->name('change-status');
	
	Route::get('/dashboard', 'DashboardController@index')->name('dashboard');
	Route::post('users/list', ['as'=>'users.list', 'uses'=>'UsersController@list']);
	Route::post('members/list', ['as'=>'members.list', 'uses'=>'MembersController@list']);
	Route::post('degrees/list', ['as'=>'degrees.list', 'uses'=>'DegreesController@list']);
	Route::post('majors/list', ['as'=>'majors.list', 'uses'=>'MajorsController@list']);
	Route::post('seats/list', ['as'=>'seats.list', 'uses'=>'SeatsController@list']);
	Route::get('seats/print','SeatsController@print');
	Route::resource('seats', 'SeatsController');
	Route::resource('users', 'UsersController');
	Route::resource('roles', 'RolesController');
	Route::resource('members', 'MembersController');
	Route::resource('degrees', 'DegreesController');
	Route::resource('majors', 'MajorsController');

});
