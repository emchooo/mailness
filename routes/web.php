<?php

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

Route::get('lists' , 'ListsController@index')->name('lists.index');
Route::get('lists/create', 'ListsController@create')->name('lists.create');
Route::post('lists/store', 'ListsController@store')->name('lists.store');
Route::get('lists/{lists}/edit', 'ListsController@edit')->name('lists.edit');
Route::put('lists/{lists}/update', 'ListsController@update')->name('lists.update');
Route::delete('/lists/{lists}/delete', 'ListsController@destroy')->name('lists.delete');

Route::get('lists/{id}/contacts', 'ContactController@index')->name('contacts.index');
Route::get('lists/{id}/contacts/create', 'ContactController@create')->name('contacts.create');
Route::post('lists/{id}/contacts', 'ContactController@store')->name('contacts.store');