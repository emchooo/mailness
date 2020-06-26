<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::redirect('/', '/dashboard');

Auth::routes();

Route::get('lists/{listUuid}/subscribe', 'ListsController@subscribe')->name('lists.subscribe');
Route::post('lists/{listUuid}/subscribe', 'ListsController@subscribeStore')->name('lists.subscribe.store');
Route::get('lists/{listUuid}/subscribe/success', 'ListsController@subscribeSuccess')->name('lists.subscribe.success');
Route::get('unsubscribe/{contact_uuid}/{campaign_uuid?}', 'UnsubscribeController@unsubscribe')->name('unsubscribe.contact');
Route::get('lists/{list_uuid}/{contact_uuid}/confirm', 'ListsController@subscribeConfirm')->name('subscribe.confirm');

Route::get('t/{link_uuid}/{contact_uuid?}', 'TrackClickController@index')->name('open.link');
Route::get('w/{campaign_uuid}/{contact_uuid?}', 'TrackOpenController@index')->name('open.mail');

Route::post('notifications/ses', 'Notifications\SESNotificationsController@index');

Route::middleware('auth')->group(function () {
    Route::get('settings', 'SettingController@index')->name('settings.index');
    Route::post('settings/update', 'SettingController@update')->name('settings.update');

    Route::get('settings/sending', 'SettingController@sending')->name('settings.sending');
    Route::get('settings/aws', 'SettingController@aws')->name('settings.create.aws');
    Route::post('settings/aws', 'SettingController@saveAws')->name('settings.save.aws');
    Route::get('settings/smtp', 'SettingController@smtp')->name('settings.smtp');
    Route::post('settings/smtp', 'SettingController@saveSmtp')->name('settings.save.smtp');
    Route::get('settings/smtp/edit', 'SettingController@editSmtp')->name('settings.edit.smtp');
    Route::post('settings/smtp/update', 'SettingController@updateSmtp')->name('settings.update.smtp');

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

    Route::post('lists/{lists}/contacts/export/{type?}', 'ExportController@export')->name('contacts.export');
    Route::get('lists/{lists}/import', 'ImportController@create')->name('contacts.import');
    Route::post('lists/{lists}/import', 'ImportController@store')->name('contacts.import.save');
    Route::get('lists/{lists}/import/{id}/map', 'ImportController@map')->name('contacts.import.map');
    Route::post('lists/{lists}/import/{id}/process', 'ImportController@importProcess')->name('contacts.import.process');

    Route::get('lists/{lists}/parse', 'ContactController@importParse');

    Route::get('lists/{lists}/contacts', 'ContactController@index')->name('contacts.index');
    Route::get('lists/{lists}/contacts/create', 'ContactController@create')->name('contacts.create');
    Route::get('lists/{lists}/contacts/{contact}', 'ContactController@show')->name('contacts.show');
    Route::post('lists/{lists}/contacts', 'ContactController@store')->name('contacts.store');
    Route::get('lists/{lists}/contacts/{contact}/edit', 'ContactController@edit')->name('contacts.edit');
    Route::put('lists/{lists}/contacts/{contact}/update', 'ContactController@update')->name('contacts.update');
    Route::delete('contact/{contact}/delete', 'ContactController@destroy')->name('contacts.delete');
    Route::post('lists/{lists}/contacts/{contact}/unsubscribe', 'ContactController@unsubscribe')->name('contacts.unsubscribe');

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
    Route::post('campaigns/{campaign}/retry_failed', 'CampaignController@retry')->name('campaigns.retry_failed');

    Route::get('campaigns/{campaign}/report', 'ReportController@show')->name('campaigns.report');
    Route::get('campaigns/{campaign}/report/opens', 'ReportController@opens')->name('campaigns.report.opens');
    Route::get('campaigns/{campaign}/report/clicks', 'ReportController@clicks')->name('campaigns.report.clicks');
    Route::get('campaigns/{campaign}/report/unsubscribed', 'ReportController@unsubscribed')->name('campaigns.report.unsubscribed');
    Route::get('campaigns/{campaign}/report/failed', 'ReportController@failed')->name('campaigns.report.failed');
    Route::get('reports', 'ReportController@index')->name('reports.index');

    Route::get('dashboard', 'DashboardController@show')->name('dashboard.show');
});
