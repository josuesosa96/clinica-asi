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
    return view('auth/login');
})->middleware('guest');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::post('/create-file', 'HomeController@create')->name('createFile');

Route::post('/get-file', 'HomeController@editFile')->name('editFile');


Route::get('/add-roles/{user}', 'HomeController@addPermissions')->name('addRole');
Route::get('/get-roles/{user}', 'HomeController@getUserRoles')->name('getRoles');
