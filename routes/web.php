<?php

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

Route::group(['prefix'=>'/'],function(){

    Route::get('/', 'GateController@Home')->name('HomePage');

    Route::get('login','GateController@loginForm')->name('loginForm');

    Route::group(['prefix'=>'user'],function(){
        Route::group(['middleware' => ['auth']], function () {
            Route::get('create','UserController@create')->name('User.create');

            Route::post('/store','UserController@store')->name('User.store');

            Route::get('/dashboard', 'UserController@dashboard')->name('User.dashboard');

            Route::get('logout','GateController@logout')->name('User.logOut');
        });
        Route::post('/login','UserController@login')->name('User.logIn');
    });

    Route::group(['prefix' => 'department'], function () {
        Route::group(['middleware' => ['auth']], function () {
            Route::get('/create', 'DepartmentController@create')->name('Department.create');

            Route::post('/store', 'DepartmentController@store')->name('Department.create');

            Route::post('/search','DepartmentController@search')->name('Department.Search');

            Route::get('/{Department}/edit', 'DepartmentController@edit')->name('Department.edit');

            Route::post('/{Department}/update', 'DepartmentController@update')->name('Department.update');

            Route::get('/{department}/delete', 'DepartmentController@delete')->name('Department.delete');

            Route::get('/get_offices/{dept_name}','DepartmentController@get_offices')->name('Department.offices');

            Route::get('/{department}/offices','DepartmentController@offices')->name('Department.officesTable');
        });
    });

    Route::group(['prefix' => 'office'], function () {
        Route::group(['middleware' => ['auth']], function () {
            Route::get('/create', 'OfficeController@create')->name('Office.create');

            Route::post('/store', 'OfficeController@store')->name('Office.create');

            Route::post('/search','OfficeController@search')->name('Office.Search');

            Route::get('/{Office}/edit', 'OfficeController@edit')->name('Office.edit');

            Route::post('/{Office}/update', 'OfficeController@update')->name('Office.update');

            Route::get('/{office}/delete', 'OfficeController@delete')->name('Office.delete');
        });
    });


    Route::group(['prefix'=>'person'],function(){
        Route::group(['middleware' => ['auth']], function () {
            Route::get('/', 'personController@index')->name('Persons');

            Route::get('/create', 'personController@create')->name('Person.Create');

            Route::post('/store','PersonController@store')->name('Person.CreateOrUpdate');

            Route::get('/{Person}/delete', 'PersonController@delete')->name('Person.delete');

            Route::get('/{Person}/edit', 'PersonController@edit')->name('Person.edit');

            Route::post('/{Person}/update', 'PersonController@update')->name('Person.update');

            Route::post('/search','PersonController@searchDelete')->name('Person.searchDelete');

            Route::get('/checkPhone/{number}','PersonController@checkPhone')->name('Person.checkPhone');

        });
        Route::get('/search/{keyword}','PersonController@search');
    });

});
