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

Route::get('/home', 'HomeController@index')->name('home')->middleware(['auth']);
Route::get('/kebijakan-privasi', 'HomeController@kebijakanPrivasi')->name('kebijakan-privasi');

Route::group(['middleware' => ['web', 'auth']], function () {

    Route::get('/pengaturan', 'UsersController@pengaturan')->name('pengaturan');
    Route::patch('/update-pengaturan/{user}', 'UsersController@updatePengaturan')->name('update-pengaturan');
    Route::get('/profil', 'UsersController@profil')->name('profil');
    Route::patch('/update-profil/{user}', 'UsersController@updateProfil')->name('update-profil');
    Route::post('/update-avatar/{id}', 'UsersController@updateAvatar')->name('update-avatar');

    Route::group(['middleware' => ['can:isPemilik']], function () {
        Route::get('dashboard', 'HomeController@dashboard')->name('dasboard');
    });
    Route::group(['middleware' => ['can:isProdusen']], function () {
        Route::resource('products', 'ProductsController');

    });
    Route::group(['middleware' => ['can:isDistributor']], function () {
        // Route::resource('orders', 'OrdersController');

    });
    Route::group(['middleware' => ['can:isSuperadmin']], function () {
        Route::get('users/cari', 'UsersController@cari')->name('users.cari');
        Route::resource('users', 'UsersController');
    });
});

