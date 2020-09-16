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
Route::group(['prefix' => 'v1', 'namespace' => 'Api\V1'], function () {
    Route::post('get-access-token', 'AccessTokenController@getAccessToken');
});

Route::group(['prefix' => 'student', 'namespace' =>'Student'], function(){
    Route::get('list-all','StudentController@allList');
});

/********************Admin Route ******************************** */
// Route::group(['middleware'  => 'auth:sanctum'], function () {
//     Route::group(['middleware' => 'admin', 'prefix' => 'admin', 'namespace' => 'Admin'], function(){
//         Route::group(['namespace' => 'Classes','prefix' => 'class'], function(){
//             Route::post('add-student','StudentController@addStudent');
//             Route::post('student-checkin','StudentController@checkIn');
//             Route::post('add-teacher','TeacherController@addTeacher');
//         });
//     });

// });

Route::group(['prefix' => 'admin', 'namespace' => 'Admin'], function () {
    Route::group(['namespace' => 'Classes', 'prefix' => 'class'], function () {
        Route::post('add-student', 'StudentController@addStudent');
        Route::post('student-checkin', 'StudentController@checkIn');
        Route::post('add-teacher', 'TeacherController@addTeacher');
        Route::post('delete-student','StudentController@deleteStudentInClass');
    });
});


/*******************Student Route*************************************/
Route::group(['middleware'  => 'auth:sanctum'], function () {
    Route::group(['middleware' => 'student', 'prefix' => 'student', 'namespace' => 'Student'], function () {
    });
});

Route::group(['prefix' => 'users', 'namespace' => 'User'], function () {
    Route::post('register', 'UserController@add');
    Route::get('admin-home', function () {
        return "admin-home";
    })->middleware('admin');
});
Route::group(['namespace' => 'User'],  function () {
    Route::get('me', 'UserController@getMe');
});
