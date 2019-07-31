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
Auth::routes();

Route::middleware('auth')->group(function () {
    Route::get('lists' , 'ListsController@index')->name('lists.index');
    Route::get('lists/create', 'ListsController@create')->name('lists.create');
    Route::post('lists/store', 'ListsController@store')->name('lists.store');
    Route::get('lists/{lists}', 'ListsController@show')->name('lists.show');
    Route::get('lists/{lists}/edit', 'ListsController@edit')->name('lists.edit');
    Route::put('lists/{lists}/update', 'ListsController@update')->name('lists.update');
    Route::delete('lists/{lists}/delete', 'ListsController@destroy')->name('lists.delete');


    Route::get('lists/{lists}/contacts', 'ContactController@index')->name('contacts.index');
    Route::get('lists/{lists}/contacts/create', 'ContactController@create' )->name('contacts.create');
    Route::get('lists/{lists}/contacts/{contact}', 'ContactController@show')->name('contacts.show');
    Route::post('lists/{lists}/contacts', 'ContactController@store')->name('contacts.store');
    Route::get('lists/{lists}/contacts/{contact}/edit', 'ContactController@edit')->name('contacts.edit');
    Route::put('lists/{lists}/contacts/{contact}/update', 'ContactController@update')->name('contacts.update');
    Route::delete('contact/{contact}/delete', 'ContactController@destroy')->name('contacts.delete');
});




Route::get('/home', 'HomeController@index')->name('home');
