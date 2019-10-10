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
Route::get('/breakfasts/sizes', 'BreakfastController@sizes_list');
Route::get('/breakfasts/sizes/{breakfast}', 'BreakfastController@sizes_list_count');
Route::put('/breakfast/{breakfast}', 'BreakfastController@update');
Route::get('/breakfasts/{breakfast}', 'BreakfastController@read'); 
Route::put('/breakfast/{breakfast}/category', 'BreakfastController@update_category');
Route::put('/breakfast/{breakfast}/size', 'BreakfastController@update_size');


### muscleGain
Route::post('/muscle_gain', 'FixedMealController@create'); 
Route::put('/muscle_gain/{muscle_gain}/update', 'FixedMealController@update'); 
Route::get('/muscle_gains', 'FixedMealController@list');
Route::get('/muscle_gains/{muscle_gain}', 'FixedMealController@read'); 
Route::post('/muscle_gains/truncate_muscle_gain', 'FixedMealController@truncate_muscle_gain'); 
Route::delete('/muscle_gains/{muscle_gain}', 'FixedMealController@remove_muscle_item'); 

### weight loss
Route::post('/weight_loss', 'weightLossController@create'); 
Route::put('/weight_loss/{weight_loss}/update', 'weightLossController@update'); 
Route::get('/weight_losss', 'weightLossController@list');
Route::get('/weight_losss/{weight_loss}', 'weightLossController@read'); 
Route::post('/weight_losss/truncate_weight_loss', 'weightLossController@truncate_weight_loss'); 
Route::delete('/weight_losss/{weight_loss}', 'weightLossController@remove_muscle_item'); 

### healty blanace
Route::post('/healthy_balance', 'healthyBalanceController@create'); 
Route::put('/healthy_balance/{healthy_balance}/update', 'healthyBalanceController@update'); 
Route::get('/healthy_balances', 'healthyBalanceController@list');
Route::get('/healthy_balances/{healthy_balance}', 'healthyBalanceController@read'); 
Route::post('/healthy_balances/truncate_healthy_balance', 'healthyBalanceController@truncate_healthy_balance'); 
Route::delete('/healthy_balances/{healthy_balance}', 'healthyBalanceController@remove_muscle_item'); 

### couple plans
Route::post('/couple_plans', 'couplePlansController@create'); 
Route::put('/couple_plans/{couple_plans}/update', 'couplePlansController@update'); 
Route::get('/couple_planss', 'couplePlansController@list');
Route::get('/couple_planss/{couple_plans}', 'couplePlansController@read'); 
Route::post('/couple_planss/truncate_couple_plans', 'couplePlansController@truncate_couple_plans'); 
Route::delete('/couple_planss/{couple_plans}', 'couplePlansController@remove_muscle_item'); 

### low carb
Route::post('/low_carb', 'lowCarbController@create'); 
Route::put('/low_carb/{low_carb}/update', 'lowCarbController@update'); 
Route::get('/low_carbs', 'lowCarbController@list');
Route::get('/low_carbs/{low_carb}', 'lowCarbController@read'); 
Route::post('/low_carbs/truncate_low_carb', 'lowCarbController@truncate_low_carb'); 
Route::delete('/low_carbs/{low_carb}', 'lowCarbController@remove_muscle_item'); 

### linch packs
Route::post('/lunch_packs', 'lunchPacksController@create'); 
Route::put('/lunch_packs/{lunch_packs}/update', 'lunchPacksController@update'); 
Route::get('/lunch_packss', 'lunchPacksController@list');
Route::get('/lunch_packss/{lunch_packs}', 'lunchPacksController@read'); 
Route::post('/lunch_packss/truncate_lunch_packs', 'lunchPacksController@truncate_lunch_packs'); 
Route::delete('/lunch_packss/{lunch_packs}', 'lunchPacksController@remove_muscle_item'); 

### vegetarian
Route::post('/vegetarian', 'VegetarieanController@create'); 
Route::put('/vegetarian/{vegetarian}/update', 'VegetarieanController@update'); 
Route::get('/vegetarians', 'VegetarieanController@list');
Route::get('/vegetarians/{vegetarian}', 'VegetarieanController@read'); 
Route::post('/vegetarians/truncate_vegetarian', 'VegetarieanController@truncate_vegetarian'); 
Route::delete('/vegetarians/{vegetarian}', 'VegetarieanController@remove_muscle_item'); 

Route::post('/menu', 'MenuController@create'); 
Route::put('/menu/{menu}/update', 'MenuController@update'); 
Route::get('/menus', 'MenuController@list'); 
Route::put('/menu/{menu}/edit_meal', 'MenuController@edit_meal');