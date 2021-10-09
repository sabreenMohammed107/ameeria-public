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

Route::get('/', 'HomeController@index')->name('home');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::resource('roles', 'RoleController');
Route::resource('users', 'UserController');
//Me
Route::resource('units', 'Admin\UnitsController');
Route::resource('settings', 'Admin\SettingsController');
Route::resource('cities', 'Admin\CitiesController');
Route::resource('items', 'Admin\ItemsController');
Route::resource('clients', 'Admin\ClientController');
Route::resource('invoices', 'Admin\InvoiceController');
Route::get('addInvoiceRow/fetch', 'Admin\InvoiceController@addRow')->name('addInvoiceRow.fetch');
Route::get('editSelectVal/fetch', 'Admin\InvoiceController@editSelectVal')->name('editSelectVal.fetch');
Route::get('selectClient/fetch', 'Admin\InvoiceController@selectClient')->name('selectClient.fetch');
Route::get('/invoice/Remove/Item', 'Admin\InvoiceController@DeleteOrderItem');
Route::resource('relay', 'Admin\RelayInvoiceController');
