<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the Closure to execute when that URI is requested.
|
*/

$update = new Update;
$update->runUpdate();


$settings = new UserSetting;
App::setLocale(isset($settings->defaultLanguage()->short) ? $settings->defaultLanguage()->short : 'en');


Route::resource('/',				'WebsiteController');
Route::get('login',					'LoginController@index');
Route::post('login',				'LoginController@store');
Route::get('create-account',		'LoginController@createAccount');
Route::post('auth',					'LoginController@auth');
Route::get('forgot-password',		'LoginController@forgotPassword');
Route::post('reset',				'LoginController@reset');
Route::get('logout',				'LoginController@logout');


Route::group(array('before' => 'auth'), function()
{
	Route::group(array('before' => 'admin'), function() 
	{	
		Route::post('admin/application',			'AdminController@application');
		Route::resource('admin',					'AdminController');
		Route::resource('language',					'LanguageController');	
		Route::post('language/translate',			'LanguageController@translate');
		Route::get('user',							'UserController@index');	
	});	

	Route::resource('dashboard',					'DashboardController');	
	Route::resource('estimate',						'EstimateController');	
	Route::get('estimate/{id}/approve',				'EstimateController@approve');
	Route::resource('message',						'MessageController');	
	Route::resource('setting',						'SettingController');	
	
	Route::get('invoice/received/{id}',				'InvoiceController@show');
	Route::get('estimate/received/{id}',			'EstimateController@show');
	Route::get('pdf/received/{id}',					'PdfController@show');
	Route::get('excel/{id}',						'ExportController@exportExcel');
	Route::get('excel/received/{id}',				'ExportController@exportExcel');
	Route::post('setting/defaultLanguage',			'SettingController@defaultLanguage');
	Route::put('user/{id}',							'UserController@update');	
	
	Route::group(array('before' => 'user'), function() 
	{
		Route::resource('client',						'ClientController');	
		Route::resource('currency',						'CurrencyController');	
		Route::resource('invoice',						'InvoiceController');	
		Route::resource('invoiceStatus',				'InvoiceStatusController');	
		Route::resource('newsletter',					'NewsletterController');	
		Route::resource('product',						'ProductController');	
		Route::resource('payment',						'PaymentController');	
		Route::resource('report',						'ReportController');	
		Route::resource('tax',							'TaxController');	
		Route::resource('user',							'UserController');

		Route::post('email/{id}',						'EmailController@show');		
		Route::get('pdf/{id}',							'PdfController@show');
		Route::resource('upload',						'UploadController');
		
		Route::post('invoice/add-payment/{id}',			'InvoiceController@addPayment');
		Route::post('invoice/edit-status/{id}',			'InvoiceController@updateStatus');
		Route::post('invoice/edit-due-date/{id}',		'InvoiceController@updateDueDate');
		Route::post('invoice/number',					'InvoiceController@storeInvoiceNumber');
		Route::post('invoice/code',						'InvoiceController@storeInvoiceCode');
		Route::post('invoice/text',						'InvoiceController@storeInvoiceText');
		
		/* === AJAX === */
		Route::post('/currency/currencyPosition',		array('uses' => 'CurrencyController@currencyPosition',		'as' => 'currency.currencyPosition'));	
		Route::post('/invoice/deleteProduct',			array('uses' => 'InvoiceController@deleteProduct',			'as' => 'invoice.deleteProduct'));
		Route::post('/setting/defaultCurrency',			array('uses' => 'SettingController@defaultCurrency',		'as' => 'setting.defaultCurrency'));
		Route::post('/ajax/productPrice',				array('uses' => 'AjaxController@productPrice',				'as' => 'ajax.productPrice'));	
		/* === END AJAX === */
	});	
});	


App::missing(function($exception)
{
	return Response::view('_messages.error-404', array(), 404);
});