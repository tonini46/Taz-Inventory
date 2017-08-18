<?php

class Currency extends Eloquent {

	public $timestamps = false;
	
	
	public function defaultCurrency()
	{
		$query = DB::table('user_settings')
				->leftJoin('currencies', 'currencies.id', '=', 'user_settings.currency_id')
				->select('currencies.name', 'currencies.position')
				->where('user_settings.user_id', Auth::id())
				->first();

		return $query;
	}	
	
}