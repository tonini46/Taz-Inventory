<?php

class TaxController extends \BaseController {

	protected $layout = 'index';
	
	
	/* === C.R.U.D. === */
	public function store()
	{
		$store			= new Tax;
		$store->user_id	= Auth::id();
		$store->value	= Input::get('value');
		$store->save();	

		return Redirect::to('setting')->with('message', trans('invoice.data_was_saved'));
	}
	
	public function update($id)
	{
		$update			= Tax::where('id', $id)->where('user_id', Auth::id())->first();
		$update->value	= Input::get('value');
		$update->save();	

		return Redirect::to('setting')->with('message', trans('invoice.data_was_updated'));
	}

	public function destroy($id)
	{
		$delete = Tax::where('id', $id)->where('user_id', Auth::id());
		$delete->delete();
		
		return Redirect::to('setting')->with('message', trans('invoice.data_was_deleted'));		
	}
	/* === END C.R.U.D. === */

}