<?php

class UserSetting extends Eloquent {

	public $timestamps = false;
	
	
	public function checkSettings()
	{
		$email = DB::table('user_settings')
				->where('user_id', Auth::id())	
				->first();

		$logo = DB::table('images')
				->where('user_id', Auth::id())	
				->first();
		
		$tax = DB::table('taxes')
				->where('user_id', Auth::id())	
				->count();			
		
		$currency = DB::table('currencies')
				->where('user_id', Auth::id())	
				->count();		
		
		$payment = DB::table('payments')
				->where('user_id', Auth::id())	
				->count();
				
		return array(
			'email'		=> $email->email 		? 1 : 0,
			'logo'		=> isset($logo->name) 	? 1 : 0,
			'tax'		=> $tax > 0				? 1	: 0,
			'currency'	=> $currency > 0		? 1	: 0,
			'payment'	=> $payment > 0			? 1	: 0,
		);
	}

	public function defaultLanguage()
	{
		$query = DB::table('user_settings')
				->join('languages', 'languages.id', '=', 'user_settings.language_id')
				->select('languages.id', 'languages.name', 'languages.short')
				->where('user_settings.user_id', Auth::id() ? Auth::id() : 1)
				->first();
				
		return isset($query) ? $query : 'en';
	}
}