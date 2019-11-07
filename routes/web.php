<?php

// Route::get('/', function () {
//     return view('welcome');
// });

Route::redirect('/', '/dashboard');

Auth::routes();

Route::get('lists/{listUuid}/subscribe', 'ListsController@subscribe')->name('lists.subscribe');
Route::post('lists/{listUuid}/subscribe', 'ListsController@subscribeStore')->name('lists.subscribe.store');
Route::get('lists/{listUuid}/subscribe/success', 'ListsController@subscribeSuccess')->name('lists.subscribe.success');

Route::middleware('auth')->group(function () {
    Route::get('settings', 'SettingController@index')->name('settings.index');
    Route::post('settings/update', 'SettingController@update')->name('settings.update');
    Route::post('settings/aws', 'SettingController@updateAws')->name('settings.update.aws');

    Route::get('lists', 'ListsController@index')->name('lists.index');
    Route::get('lists/create', 'ListsController@create')->name('lists.create');
    Route::post('lists/store', 'ListsController@store')->name('lists.store');
    Route::get('lists/{lists}', 'ListsController@show')->name('lists.show');
    Route::get('lists/{lists}/edit', 'ListsController@edit')->name('lists.edit');
    Route::put('lists/{lists}/update', 'ListsController@update')->name('lists.update');
    Route::delete('lists/{lists}/delete', 'ListsController@destroy')->name('lists.delete');

    Route::get('lists/{lists}/fields', 'FieldController@index')->name('fields.index');
    Route::get('lists/{lists}/fields/create', 'FieldController@create')->name('fields.create');
    Route::post('lists/{lists}/fields/store', 'FieldController@store')->name('fields.store');
    Route::get('lists/{lists}/fields/{field}/edit', 'FieldController@edit')->name('fields.edit');
    Route::put('lists/{lists}/fields/{field}/update', 'FieldController@update')->name('fields.update');
    Route::delete('lists/{lists}/fields/{field}/delete', 'FieldController@destroy')->name('fields.delete');

    Route::post('lists/{lists}/contacts/export', 'ContactController@export')->name('contacts.export');
    Route::get('lists/{lists}/import', 'ContactController@import')->name('contacts.import');
    Route::post('lists/{lists}/import', 'ContactController@importSave')->name('contacts.import.save');
    Route::get('lists/{lists}/import/{id}/map', 'ContactController@map')->name('contacts.import.map');
    Route::post('lists/{lists}/import/{id}/process', 'ContactController@importProcess')->name('contacts.import.process');

    Route::get('lists/{lists}/parse', 'ContactController@importParse');

    Route::get('lists/{lists}/contacts', 'ContactController@index')->name('contacts.index');
    Route::get('lists/{lists}/contacts/create', 'ContactController@create')->name('contacts.create');
    Route::get('lists/{lists}/contacts/{contact}', 'ContactController@show')->name('contacts.show');
    Route::post('lists/{lists}/contacts', 'ContactController@store')->name('contacts.store');
    Route::get('lists/{lists}/contacts/{contact}/edit', 'ContactController@edit')->name('contacts.edit');
    Route::put('lists/{lists}/contacts/{contact}/update', 'ContactController@update')->name('contacts.update');
    Route::delete('contact/{contact}/delete', 'ContactController@destroy')->name('contacts.delete');

    Route::get('lists/{lists}/forms', 'FormController@index')->name('forms.index');
    Route::get('lists/{lists}/forms/hosted', 'FormController@hosted')->name('forms.hosted');

    Route::get('templates', 'TemplateController@index')->name('templates.index');
    Route::get('templates/create', 'TemplateController@create')->name('templates.create');
    Route::post('templates/store', 'TemplateController@store')->name('templates.store');
    Route::get('templates/{template}/edit', 'TemplateController@edit')->name('templates.edit');
    Route::get('templates/{template}', 'TemplateController@show')->name('templates.show');
    Route::put('templates/{template}/store', 'TemplateController@update')->name('templates.update');
    Route::delete('templates/{template}/delete', 'TemplateController@destroy')->name('templates.delete');
    Route::get('templates/{template}/preview', 'TemplateController@preview')->name('templates.preview');

    Route::get('campaigns', 'CampaignController@index')->name('campaigns.index');
    Route::get('campaigns/create', 'CampaignController@create')->name('campaigns.create');
    Route::post('campaigns/store', 'CampaignController@store')->name('campaigns.store');
    Route::get('campaigns/{campaign}', 'CampaignController@show')->name('campaigns.show');
    Route::post('campaigns/{campaign}/send/test', 'CampaignController@sendTestMail')->name('campaigns.send.test');
    Route::post('campaigns/{campaign}/send', 'CampaignController@send')->name('campaigns.send');
    Route::get('campaigns/{campaign}/edit', 'CampaignController@edit')->name('campaigns.edit');
    Route::put('campaigns/{campaign}/update', 'CampaignController@update')->name('campaigns.update');
    Route::delete('campaigns/{campaign}/delete', 'CampaignController@destroy')->name('campaigns.delete');
    Route::post('campaigns/{campaign}/duplicate', 'CampaignController@duplicate')->name('campaigns.duplicate');

    Route::get('campaigns/{campaign}/report', 'ReportController@show')->name('campaigns.report');
    Route::get('reports', 'ReportController@index')->name('reports.index');

    Route::get('dashboard', 'DashboardController@show')->name('dashboard.show');
});

Route::get('/home', 'HomeController@index')->name('home');
