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

Route::get('pegawai', 'PegawaiController@index')->name('pegawai.index');
Route::post('pegawai', 'PegawaiController@store')->name('pegawai.store');

Route::get('kasbon', 'KasbonController@index')->name('kasbon.index');
Route::post('kasbon', 'KasbonController@store')->name('kasbon.store');
Route::patch('kasbon/setujui/{id}', 'KasbonController@setujui')->name('kasbon.setujui');
Route::post('kasbon/setujui-masal', 'KasbonController@setujui_masal')->name('kasbon.setujui-masal');

Route::fallback(function () {
    abort(404);
});
