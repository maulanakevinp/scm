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
    Route::get('/users/get-updated-at/{id}', 'UsersController@getUpdatedAt');
    Route::get('/users/get-created-at/{id}', 'UsersController@getCreatedAt');

    Route::group(['middleware' => ['can:isPemilik']], function () {
        Route::get('/dashboard', 'HomeController@dashboard')->name('dasboard');
    });
    Route::group(['middleware' => ['can:isProdusen']], function () {
        Route::get('/product/get-updated-at/{id}', 'ProductController@getUpdatedAt');
        Route::get('/product/get-created-at/{id}', 'ProductController@getCreatedAt');
        Route::get('/product/cari', 'ProductController@cari')->name('product.cari');
        Route::get('/product/order/{order}', 'OrderController@edit')->name('order.edit');
        Route::post('/product/update-foto/{id}', 'ProductController@updateFoto')->name('product.update-foto');
        Route::resource('/product', 'ProductController');
    });
    Route::group(['middleware' => ['can:isDistributor']], function () {
        Route::get('/belanja/cari', 'OrderController@cari')->name('belanja.cari');
        Route::get('/belanja', 'OrderController@belanja')->name('belanja');
        Route::get('/belanja/pesan/{product}', 'OrderController@create')->name('pesan');
        Route::get('/order/cari', 'OrderController@cariPesanan')->name('order.cari');
        Route::post('/order/update-bukti-transfer/{id}', 'OrderController@updateBuktiTransfer')->name('order.update-bukti-transfer');
        Route::post('/order/store/{product}', 'OrderController@store')->name('order.store');
        Route::resource('/order', 'OrderController')->except(['create','store','edit']);
    });
    Route::group(['middleware' => ['can:isSuperadmin']], function () {
        Route::get('/users/cari', 'UsersController@cari')->name('users.cari');
        Route::resource('users', 'UsersController');
    });
});

