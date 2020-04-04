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
    Route::get('/profil', 'UsersController@profil')->name('profil');
    Route::post('/update-avatar/{id}', 'UsersController@updateAvatar')->name('update-avatar');
    Route::post('/users/get-updated-at', 'UsersController@getUpdatedAt');
    Route::post('/users/get-created-at', 'UsersController@getCreatedAt');
    Route::patch('/update-pengaturan/{user}', 'UsersController@updatePengaturan')->name('update-pengaturan');
    Route::patch('/update-profil/{user}', 'UsersController@updateProfil')->name('update-profil');

    Route::group(['middleware' => ['can:isPemilik']], function () {
        Route::get('/dashboard', 'HomeController@dashboard')->name('dasboard');
    });
    Route::group(['middleware' => ['can:isProdusen']], function () {
        Route::get('/product/{product}/pesanan-masuk', 'ProductController@show')->name('product.pesanan-masuk');
        Route::get('/product/{product}/pesanan-masuk/cari', 'ProductController@show')->name('product.cari-pesanan-masuk');
        Route::get('/product/{product}/pesanan-dalam-proses', 'ProductController@show')->name('product.pesanan-dalam-proses');
        Route::get('/product/{product}/pesanan-dalam-proses/cari', 'ProductController@show')->name('product.cari-pesanan-dalam-proses');
        Route::get('/product/{product}/pesanan-dalam-pengiriman', 'ProductController@show')->name('product.pesanan-dalam-pengiriman');
        Route::get('/product/{product}/pesanan-dalam-pengiriman/cari', 'ProductController@show')->name('product.cari-pesanan-dalam-pengiriman');
        Route::get('/product/{product}/pesanan-selesai', 'ProductController@show')->name('product.pesanan-selesai');
        Route::get('/product/{product}/pesanan-selesai/cari', 'ProductController@show')->name('product.cari-pesanan-selesai');
        Route::get('/product/cari', 'ProductController@cari')->name('product.cari');
        Route::get('/product/order/{order}', 'OrderController@edit')->name('order.edit');
        Route::post('/product/get-updated-at', 'ProductController@getUpdatedAt');
        Route::post('/product/get-created-at', 'ProductController@getCreatedAt');
        Route::post('/product/update-foto/{id}', 'ProductController@updateFoto')->name('product.update-foto');
        Route::patch('/product/order/{order}', 'OrderController@verification')->name('order.verification');
        Route::resource('/product', 'ProductController');
    });
    Route::group(['middleware' => ['can:isDistributor']], function () {
        Route::get('/belanja/cari', 'OrderController@cari')->name('belanja.cari');
        Route::get('/belanja', 'OrderController@belanja')->name('belanja');
        Route::get('/belanja/pesan/{product}', 'OrderController@create')->name('pesan');
        Route::get('/order/cari', 'OrderController@cariPesanan')->name('order.cari');
        Route::post('/order/update-bukti-transfer/{id}', 'OrderController@updateBuktiTransfer')->name('order.update-bukti-transfer')->middleware('verified');
        Route::post('/order/store/{product}', 'OrderController@store')->name('order.store')->middleware('verified');
        Route::resource('/order', 'OrderController')->except(['create','store','edit'])->middleware('verified');
    });
    Route::group(['middleware' => ['can:isSuperadmin']], function () {
        Route::get('/users/cari', 'UsersController@cari')->name('users.cari');
        Route::resource('users', 'UsersController');
    });
});

