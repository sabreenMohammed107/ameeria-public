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

Route::get('/', 'HomeController@index')->name('/');

Auth::routes(['register' => false]);

Route::resource('roles', 'RoleController');
Route::resource('users', 'UserController');


Route::resource('units', 'UnitsController');
Route::resource('settings', 'SettingsController');
Route::resource('cities', 'CitiesController');
Route::resource('items', 'ItemsController');
Route::resource('clients', 'ClientController');
Route::resource('invoices', 'InvoiceController');
Route::get('addInvoiceRow/fetch', 'InvoiceController@addRow')->name('addInvoiceRow.fetch');
Route::get('editSelectVal/fetch', 'InvoiceController@editSelectVal')->name('editSelectVal.fetch');
Route::get('selectClient/fetch', 'InvoiceController@selectClient')->name('selectClient.fetch');
Route::get('/invoice/Remove/Item', 'InvoiceController@DeleteOrderItem');
Route::resource('relay', 'RelayInvoiceController');
Route::get('/edit-user-profile/{id}', 'UserController@editProfile');
Route::post('/udate-profile', 'UserController@updateProfile')->name('udate-profile');
Route::post('/invoices/search', 'InvoiceController@search')->name('invoices.search');
