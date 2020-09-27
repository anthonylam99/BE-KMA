<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

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
    return view('app');
});

Auth::routes();


Route::group(['prefix' => 'admin', 'namespace' => 'Web\Admin'], function () {
    Route::group(['namespace' => 'Classes', 'prefix' => 'class'], function () {
        Route::match(['get','post'], 'abc', 'StudentController@addStudent');
        Route::post('add-student', 'StudentController@addStudent');
        Route::post('student-checkin', 'StudentController@checkIn');
        Route::post('delete-student','StudentController@deleteStudentInClass');

        /****************************ROUTE TEACHER******************************/
        Route::post('add-teacher', 'TeacherController@addTeacher');
        Route::post('teacher-checkin','TeacherController@checkIn');
        Route::post('delete-teacher','TeacherController@deleteTeacherInClass');

        /****************************CLASS ROUTE******************************/
        Route::post('add','ClassController@add');
    });
});


Route::get('/home', 'HomeController@index')->name('home');
