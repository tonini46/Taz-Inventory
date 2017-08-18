<?php

class AjaxController extends \BaseController {
	
	
	public function productPrice()
	{
		return json_encode( Product::where('id', Input::get('product'))->where('user_id', Auth::id())->first() );
	}
	
}