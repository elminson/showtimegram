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

Route::get('/', 'ImageController@index');

Route::get('/newdesign', 'ImageController@newDesign');

Route::get('/newdesign/post', 'ImageController@postImage');

Route::post('/newdesign/post', 'ImageController@postImage');

Route::post('/image/store', 'ImageController@store');

Route::get('/image/destroy/{id}', ['uses' =>'ImageController@destroy']);

Route::post('/image/destroy', 'ImageController@destroy');

Route::get('/api/v1/posts', 'ImageController@posts');
