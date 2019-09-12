<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// History
Route::get('/history', 'HistoryController@list');


// Users
Route::post('/user/login', 'UserController@login');

// user management 
Route::post('/user/request_reset_password', 'UserController@request_reset_password');
Route::post('/user/reset_password', 'UserController@reset_password');

#### File Upload Response
Route::post('/file', 'FileController@upload_file'); 
Route::get('/file', 'FileController@read_file');

### File Save Slide
Route::post('/slide', 'SlideController@create_or_update');

### Breakfast 
Route::post('/breakfast', 'BreakfastController@create'); 
Route::get('/breakfasts', 'BreakfastController@list');
Route::put('/breakfast/{breakfast}', 'BreakfastController@update');
Route::get('/breakfasts/{breakfast}', 'BreakfastController@read');
Route::put('/breakfast/{breakfast}/category', 'BreakfastController@update_category');