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

Route::get('/menu', function () {
    return view('menu');
})->middleware('auth');

Auth::routes();

Route::get('/secretary-home', 'HomeSecretaryController@index')->middleware('role:super-admin|secretary')->name('secretaryHome');
Route::post('/create-file', 'HomeSecretaryController@create')->middleware('role:super-admin|secretary')->name('createFile');
Route::get('/secretary-edit-file', 'SecretaryEditController@index')->middleware('role:super-admin|secretary')->name('secretaryEdit');
Route::post('/secretary-update-file', 'SecretaryEditController@editFile')->middleware('role:super-admin|secretary')->name('secretaryUpdateFile');

Route::get('/doctor-edit-file', 'DoctorEditController@index')->name('doctorEdit');
Route::post('/doctor-update-file', 'DoctorEditController@editFile')->name('doctorUpdateFile');

Route::get('/lab-edit-file', 'LabEditController@index')->name('LabEdit');
Route::post('/lab-update-file', 'LabEditController@editFile')->name('LabUpdateFile');
Route::post('/get-lab-file', 'LabEditController@getFile')->name('getLabFile');

Route::post('/get-file', 'HomeSecretaryController@getFile')->name('getFile');

Route::get('/add-roles/{user}', 'HomeSecretaryController@addPermissions')->name('addRole');
Route::get('/get-roles/{user}', 'HomeSecretaryController@getUserRoles')->name('getRoles');


Route::get('pdf_view', 'CustomerController@printPDF') ->name ('pdfview');
Route::get('pdf_viewSEC', 'CustomerControllerSEC@printPDF') ->name ('pdfviewSEC');
