<?php

class CurrencyController extends \BaseController {

	protected $layout = 'index';
	
	
	/* === C.R.U.D. === */
	public function store()
	{
		$store				= new Currency;
		$store->user_id		= Auth::id();
		$store->name		= Input::get('value');
		$store->position	= 1;
		$store->save();	

		return Redirect::to('setting')->with('message', trans('invoice.data_was_saved'));
	}
	
	public function update($id)
	{
		$update				= Currency::where('id', $id)->where('user_id', Auth::id())->first();
		$update->name		= Input::get('value');
		$update->save();	

		return Redirect::to('setting')->with('message', trans('invoice.data_was_updated'));
	}

	public function destroy($id)
	{
		$delete = Currency::where('id', $id)->where('user_id', Auth::id());
		$delete->delete();
		
		return Redirect::to('setting')->with('message', trans('invoice.data_was_deleted'));		
	}
	/* === END C.R.U.D. === */

	
	/* === AJAX === */
	public function currencyPosition()
	{
		$update				= Currency::where('id', Input::get('itemID'))->where('user_id', Auth::id())->first();
		$update->position	= Input::get('itemValue');
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