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
Route::get('/','InvoiceController@index')->name('index');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
Route::get('invoice/printt/{id}','InvoiceController@printt')->name('invoice.print');
Route::get('invoice/pdf/{id}','InvoiceController@pdf')->name('invoice.pdf');
Route::get('invoice/send_to_email/{id}','InvoiceController@send_to_email')->name('invoice.send_to_email');
Route::resource('invoice','InvoiceController');
Route::get('change-language/{locale}','GenralController@changelanguages')->name('fronted_change_locale');