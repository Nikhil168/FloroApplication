<?php

use Illuminate\Http\Request;


Route::post('login', 'API\UserController@login');
Route::get('getall', 'API\UserController@index');
//Route::get('/export/users', 'ExportUserController@exportUsers')->name('usersExport');
Route::group(['middleware' => 'auth:api'], function(){
   
    Route::get('logout', 'API\UserController@logout');
    Route::get('sortBy', 'API\UserController@sort');
    Route::post('create', 'API\UserController@store');
    Route::delete('delete/{id}', 'API\UserController@destroy');
    Route::post('users/{id}', 'API\UserController@update');
    Route::get('search', 'API\UserController@getSearchResults');
    Route::get('/export/users', 'ExportUserController@exportUsers')->name('usersExport');
    Route::get('/download/users', 'ExportUserController@showUsersDownload')->name('showUsersDownload');
    Route::get('/download/users-file', 'ExportUserController@downloadUsers')->name('usersDownload');   
       
});
 

