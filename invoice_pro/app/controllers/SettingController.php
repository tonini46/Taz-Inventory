<?php

class SettingController extends \BaseController {

	protected $layout = 'index';
	
	
	public function index()
	{
		$settings = new UserSetting;
		
		$data = array(
			'company' 			=> UserSetting::where('user_id', Auth::id())->first(),
			'logo'				=> Image::where('user_id', Auth::id())->first(),
			'taxes' 			=> Tax::where('user_id', Auth::id())->get(),
			'invoiceSettings'	=> InvoiceSetting::where('user_id', Auth::id())->first(),
			'invoiceStatus'		=> InvoiceStatus::all(),
			'currencies'		=> Currency::where('user_id', Auth::id())->get(),
			'payments'			=> Payment::where('user_id', Auth::id())->get(),		
			'app'				=> General::find(1)->first(),
			'languages'			=> Language::all(),
			'defaultLanguage'	=> $settings->defaultLanguage(),
			'newsletter'		=> Newsletter::where('user_id', Auth::id())->first()
		);		
	
		if ( Auth::user()->role_id == 1 )
		{
			$this->layout->content = View::make('settings.admin', $data);
		}	
		else
		{
			$this->layout->content = View::make('settings.index', $data);
		}
	}

	
	/* === C.R.U.D. === */
	public function update($id)
	{
		$rules = array(
			'name'     	=> 'required'
		);
			
		if (Auth::user()->role_id == 2)
		{
			$rules = array(
				'name'     	=> 'required',
				'country'	=> 'required',
				'state'		=> 'required',
				'city'		=> 'required',
				'zip'		=> 'required',
				'address'	=> 'required',
				'contact'	=> 'required',
				'phone'		=> 'required',
				'email'		=> 'required|email',
				'website'	=> 'url',
			);	
		}

		$validator = Validator::make(Input::all(), $rules);		
		
		if ($validator->passes())
		{		
			$update					= UserSetting::where('user_id', Auth::id())->first();
			$update->name			= Input::get('name');
			$update->country		= Input::get('country');
			$update->state			= Input::get('state');
			$update->city			= Input::get('city');
			$update->zip			= Input::get('zip');
			$update->address		= Input::get('address');
			$update->contact		= Input::get('contact');
			$update->phone			= Input::get('phone');
			$update->email			= Input::get('email');
			$update->website		= Input::get('website');
			$update->bank			= Input::get('bank');
			$update->bank_account	= Input::get('bank_account');			
			$update->description	= Input::get('description');			
			$update->status			= 1;
			$update->save();
		}
		else
		{
			return Redirect::to('setting')->with('message', trans('invoice.validation_error_messages'))->withErrors($validator)->withInput();
		}	
		
		return Redirect::to('setting')->with('message', trans('invoice.data_was_updated'));
	}
	/* === END C.R.U.D. === */	
	
	
	/* === OTHERS === */
	public function defaultLanguage()
	{
		$rules = array(
			'language'	=> 'required',
		);	
		
		$validator = Validator::make(Input::all(), $rules);		
		
		if ($validator->passes())
		{		
			$update					= UserSetting::where('user_id', Auth::id())->first();
			$update->language_id	= Input::get('language');
			$update->save();		
		}
		else
		{
			return Redirect::to('setting')->with('message', trans('invoice.validation_error_messages'))->withErrors($validator)->withInput();
		}			
		
		return Redirect::to('setting')->with('message', trans('invoice.data_was_updated'));
	}
	/* === END OTHERS === */
	
	
	/* === AJAX === */
	public function defaultCurrency()
	{
		$update					= UserSetting::where('user_id', Auth::id())->first();
		$update->currency_id	= Input::get('itemID');
		$update->save();
		
		$data = array(
			'company' 		=> UserSetting::where('user_id', Auth::id())->first(),
			'currencies'	=> Currency::where('user_id', Auth::id())->get(),
		);		
	
		Session::flash('ajaxMessage', trans('invoice.data_was_updated'));	
		
		return View::make('settings.currency', $data);	
	}
	/* === END AJAX === */
	
}