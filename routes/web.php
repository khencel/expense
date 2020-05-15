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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::get('user/roles', function(){
    return view('user-management/roles');
});

Route::get('user/users', function(){
    return view('user-management/users');
});

Route::get('expense/category', function(){
    return view('expense-management/category');
});

Route::get('expense/expenses', function(){
    return view('expense-management/expenses');
});

Route::get('changePassword', function(){
    return view('changePass');
});
