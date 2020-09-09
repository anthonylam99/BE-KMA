<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
Route::post('add', 'UserController@add');
Route::post('login', 'UserController@login');

Route::group(['prefix' => 'v1', 'namespace' => 'Api\V1'], function () {
    Route::post('get-access-token', 'AccessTokenController@getAccessToken');

});


Route::group(['middleware'  => 'auth:sanctum'], function () {
    Route::group(['middleware' => 'admin', 'prefix' => 'admin', 'namespace' => 'Admin'], function(){
        Route::group(['namespace' => 'Classes','prefix' => 'class'], function(){
            Route::post('add-student','StudentController@addStudent');
            Route::post('student-checkin','StudentController@checkIn');
        });
    });
    Route::group(['prefix' => 'user'], function () {

        Route::get('home', 'UserController@home')->middleware(['admin', 'student']);
        Route::get('admin-home', function () {
            return "admin-home";
        })->middleware('admin');
    });
});
