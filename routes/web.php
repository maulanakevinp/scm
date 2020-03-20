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

Auth::routes(['verify' => true]);

Route::get('/', function (){
    return view('home');
});

Route::get('/home', 'HomeController@index')->name('home')->middleware(['auth','verified']);
Route::get('/kebijakan-privasi', 'HomeController@kebijakanPrivasi')->name('kebijakan-privasi');

Route::group(['middleware' => ['web', 'auth', 'verified']], function () {

    Route::get('/ganti-password', 'UsersController@gantiPassword')->name('ganti-password');
    Route::patch('/update-password/{user}', 'UsersController@updatePassword')->name('update-password');
    Route::get('/profil', 'UsersController@profil')->name('profil');
    Route::patch('/update-profil/{user}', 'UsersController@updateProfil')->name('update-profil');

    Route::group(['middleware' => ['can:isPemilik']], function () {
        Route::get('dashboard', 'HomeController@dashboard')->name('dasboard');
    });
    Route::group(['middleware' => ['can:isProdusen']], function () {
        // Route::resource('products', 'ProductsController');

    });
    Route::group(['middleware' => ['can:isDistributor']], function () {
        // Route::resource('orders', 'OrdersController');

    });
    Route::group(['middleware' => ['can:isSuperadmin']], function () {
        Route::resource('users', 'UsersController');
    });
});

