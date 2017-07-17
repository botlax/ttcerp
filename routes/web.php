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


//-------------HOME
Route::get('/', 'HomeController@index');

//-------------EMPLOYEES
Route::get('/employees', 'HomeController@employees');
Route::get('/employees/add', 'HomeController@add');
Route::post('/employees/add', 'HomeController@store')->name('emp-add');
Route::get('/cancelled', 'HomeController@cancelled');
Route::get('/employees/{id}', 'HomeController@show')->where('id', '^[0-9]*$');
Route::get('/cancelled/{id}', 'HomeController@showCancel')->where('id', '^[0-9]*$');
Route::get('/employees/{id}/edit', 'HomeController@edit')->where('id', '^[0-9]*$');
Route::post('/employees/{id}/update', 'HomeController@update')->name('emp-update')->where('id', '^[0-9]*$');
Route::get('/employees/{id}', 'HomeController@show')->where('id', '^[0-9]*$');
Route::post('/employees/{id}/delete', 'HomeController@delete')->name('emp-delete')->where('id', '^[0-9]*$');
Route::get('/employees/{id}/cancellation', 'CancelController@create')->where('id', '^[0-9]*$');
Route::post('/employees/{id}/cancellation', 'CancelController@store')->name('cancel-add')->where('id', '^[0-9]*$');
Route::get('/employees/{id}/cancellation/edit', 'CancelController@edit')->where('id', '^[0-9]*$');
Route::post('/employees/{id}/cancellation/edit', 'CancelController@update')->name('cancel-update')->where('id', '^[0-9]*$');
Route::post('/employees/{id}/revive', 'HomeController@revive')->name('emp-revive')->where('id', '^[0-9]*$');
Route::post('/employees/{id}/destroy', 'HomeController@destroy')->name('emp-destroy')->where('id', '^[0-9]*$');
Route::post('/employees/{id}/drop', 'HomeController@drop')->name('emp-drop')->where('id', '^[0-9]*$');
Route::post('/cancel/info', 'AjaxController@info');

Route::get('/employees/search', 'HomeController@empSearch')->name('emp-search');
Route::get('/employees/advanced_search', 'HomeController@advSearch')->name('emp-advsearch');
Route::get('/cancelled/search', 'HomeController@cancelSearch')->name('cancel-search');
Route::get('/employees/summary', 'HomeController@empSummary')->name('emp-summary');

Route::get('/qid-expiry', 'HomeController@qidExpiry');
Route::get('/passport-expiry', 'HomeController@passportExpiry');
Route::get('/hc-expiry', 'HomeController@hcExpiry');
Route::get('/license-expiry', 'HomeController@licenseExpiry');

Route::post('/qid/search', 'HomeController@qidSearch')->name('qid-search');
Route::post('/passport/search', 'HomeController@passSearch')->name('pass-search');
Route::post('/hc/search', 'HomeController@hcSearch')->name('hc-search');
Route::post('/license/search', 'HomeController@licSearch')->name('lic-search');

Route::get('/logs', 'HomeController@logs');
Route::get('/test', 'HomeController@test');
Route::get('/settings', 'HomeController@settings');
Route::post('/settings', 'HomeController@updateSettings')->name('settings');

//-------------ADMIN
Route::get('/admin/password', 'AdminController@password')->name('show-pass');
Route::post('/admin/password', 'AdminController@changePassword')->name('change-pass');
Route::get('/admins', 'AdminController@admins');
Route::post('/admins/{id}/delete', 'AdminController@delete')->name('admin-delete')->where('id', '^[0-9]*$');
Route::get('/admins/{id}/edit', 'AdminController@edit')->where('id', '^[0-9]*$');
Route::post('/admins/{id}/edit', 'AdminController@update')->name('admin-update')->where('id', '^[0-9]*$');
Route::post('/admins/add', 'AdminController@store')->name('admin-add');

//-------------VISA
Route::get('/visa', 'VisaController@index');
Route::get('/visa/used', 'VisaController@used');
Route::get('/visa/add', 'VisaController@create');
Route::post('/visa/add', 'VisaController@store')->name('visa-add');
Route::get('/visa/{id}/edit', 'VisaController@edit')->where('id', '^[0-9]*$');
Route::post('/visa/{id}/edit', 'VisaController@update')->where('id', '^[0-9]*$')->name('visa-update');
Route::post('/visa/{id}/delete', 'VisaController@drop')->name('visa-delete')->where('id', '^[0-9]*$');
Route::get('/visa/search', 'VisaController@search')->name('visa-search')->where('id', '^[0-9]*$');
Route::get('/visa/used/search', 'VisaController@usedSearch')->name('visa-used-search')->where('id', '^[0-9]*$');

//-------------AJAX
Route::post('/employees/search', 'AjaxController@empSearch')->name('empSearch');
Route::post('/employees/all', 'AjaxController@empAll')->name('empAll');
Route::post('/cancelled/search', 'AjaxController@cancelSearch')->name('cancelSearch');
Route::post('/cancelled/all', 'AjaxController@cancelAll')->name('cancelAll');
Route::post('/visa/expand', 'VisaController@expand')->name('visaExpand');
Route::post('/visa/search-expand', 'VisaController@searchExpand')->name('visaSearchExpand');

//-------------FILES
Route::post('/files/{id}/add', 'FileController@store')->name('file-add')->where('id', '^[0-9]*$');
Route::post('/files/{id}/update', 'FileController@update')->name('file-update')->where('id', '^[0-9]*$');
Route::post('/files/{id}/delete', 'FileController@delete')->name('file-delete')->where('id', '^[0-9]*$');

//-------------LICENSE
Route::post('/license/{id}/add', 'LicenseController@store')->name('lic-store')->where('id', '^[0-9]*$');
Route::post('/license/{id}/update', 'LicenseController@update')->name('lic-update')->where('id', '^[0-9]*$');
Route::post('/license/{id}/drop', 'LicenseController@drop')->name('lic-drop')->where('id', '^[0-9]*$');

//-------------WARNING
Route::post('/warning/{id}/add', 'WarningController@store')->name('warning-store')->where('id', '^[0-9]*$');
Route::post('/warning/{id}/update', 'WarningController@update')->name('warning-update')->where('id', '^[0-9]*$');
Route::post('/warning/{id}/drop', 'WarningController@drop')->name('warning-drop')->where('id', '^[0-9]*$');

//-------------ACCIDENT
Route::post('/ot/{id}/add', 'OthersController@store')->name('ot-store')->where('id', '^[0-9]*$');
Route::post('/ot/{id}/update', 'OthersController@update')->name('ot-update')->where('id', '^[0-9]*$');
Route::post('/ot/{id}/drop', 'OthersController@drop')->name('ot-drop')->where('id', '^[0-9]*$');

//-------------OTHERS
Route::post('/ai/{id}/add', 'AIController@store')->name('ai-store')->where('id', '^[0-9]*$');
Route::post('/ai/{id}/update', 'AIController@update')->name('ai-update')->where('id', '^[0-9]*$');
Route::post('/ai/{id}/drop', 'AIController@drop')->name('ai-drop')->where('id', '^[0-9]*$');

//-------------Salary
Route::post('/salary/{id}/add', 'SalaryController@store')->name('sal-store')->where('id', '^[0-9]*$');
Route::post('/salary/{id}/update', 'SalaryController@update')->name('sal-update')->where('id', '^[0-9]*$');
Route::post('/salary/{id}/drop', 'SalaryController@drop')->name('sal-drop')->where('id', '^[0-9]*$');

//-------------VACATION
Route::get('/vacation', 'VacationController@index');
Route::post('/vacation/search', 'VacationController@search')->name('vac-search');
Route::get('/vacation/add', 'VacationController@add');
Route::post('/vacation/{id}/add', 'VacationController@store')->name('vac-store')->where('id', '^[0-9]*$');
Route::get('/vacation/{id}/add', 'VacationController@create')->where('id', '^[0-9]*$');
Route::post('/vacation/{id}/update', 'VacationController@update')->name('vac-update')->where('id', '^[0-9]*$');
Route::post('/vacation/{id}/drop', 'VacationController@drop')->name('vac-drop')->where('id', '^[0-9]*$');
//-------------LEAVE
Route::post('/leave/{id}/add', 'LeaveController@store')->name('leave-store')->where('id', '^[0-9]*$');
Route::post('/leave/{id}/update', 'LeaveController@update')->name('leave-update')->where('id', '^[0-9]*$');
Route::post('/leave/{id}/drop', 'LeaveController@drop')->name('leave-drop')->where('id', '^[0-9]*$');

//-------------EMERGENCY
Route::post('/emergency/add', 'EmergencyController@store')->name('emergency-store')->where('id', '^[0-9]*$');
Route::post('/emergency/{id}/update', 'EmergencyController@update')->name('emergency-update')->where('id', '^[0-9]*$');
Route::post('/emergency/{id}/delete', 'EmergencyController@destroy')->name('emergency-drop')->where('id', '^[0-9]*$');

//-------------BATCH
Route::get('/batch', 'BatchController@index');
Route::post('/batch', 'BatchController@upload')->name('batch-upload');

//-------------AUTH
Auth::routes();