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

Route::middleware('auth:api')->group(function(){
    // role
    Route::get('user/role/index','API\RoleController@index');
    Route::post('user/role/store','API\RoleController@store');
    Route::get('user/role/show/{id}','API\RoleController@show');
    Route::put('user/role/update/{id}','API\RoleController@update');
    Route::get('user/role/delete/{id}','API\RoleController@destroy');

    // user
    Route::get('user/index','API\UserController@index');
    Route::post('user/store','API\UserController@store');
    Route::get('user/show/{id}','API\UserController@show');
    Route::put('user/update/{id}','API\UserController@update');
    Route::get('user/delete/{id}','API\UserController@destroy');
    Route::post('user/changePassword','API\UserController@changePassword');


    // category
    Route::get('category/index','API\CategoryController@index');
    Route::post('category/store','API\CategoryController@store');
    Route::get('category/show/{id}','API\CategoryController@show');
    Route::put('category/update/{id}','API\CategoryController@update');
    Route::get('category/delete/{id}','API\CategoryController@destroy');

    // expense
    Route::get('expense/index','API\ExpenseController@index');
    Route::post('expense/store','API\ExpenseController@store');
    Route::get('expense/show/{id}','API\ExpenseController@show');
    Route::put('expense/update/{id}','API\ExpenseController@update');
    Route::get('expense/delete/{id}','API\ExpenseController@destroy');

});