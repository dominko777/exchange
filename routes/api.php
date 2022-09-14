<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\BestCourseController;  
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
  

Route::middleware('auth:api')->group(function() {
    Route::get('best-courses', [BestCourseController::class, 'getFiltered']); 
	Route::get('best-courses/{sendCurrency}/{receiveCurrency}', [BestCourseController::class, 'get']);  
});