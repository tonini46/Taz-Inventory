<?php

class ProductController extends \BaseController {

	protected $layout = 'index';
	
	
	/* === VIEW === */
	public function index()
	{
		$currency = new Currency;	
		
		$data = array(
			'products' 	=> Product::where('user_id', Auth::id())->where('status', 1)->get(),
			'currency'	=> $currency->defaultCurrency()
		);
	
		$this->layout->content = View::make('products.index', $data);
	}

	public function create()
	{
		$this->layout->content = View::make('products.create');
	}

	public function show($id)
	{
		return json_encode( Product::where('id',  Request::segment(2))->where('user_id', Auth::id())->first() );
	}	
	
	public function edit($id)
	{
		$data = array(
			'product'	=> Product::where('id', $id)->where('user_id', Auth::id())->first(),
		);
		
		$this->layout->content = View::make('products.edit', $data);
	}
	/* === END VIEW === */
	
	
	/* === C.R.U.D. === */
	public function store()
	{
		$rules = array(
			'name'		=> 'required',
			'code'		=> 'required',
			'price'		=> 'required',
		);	
		
		$validator = Validator::make(Input::all(), $rules);	
		
		if ($validator->passes())
		{
			$store					= new Product;
			$store->user_id			= Auth::id();
			$store->name			= Input::get('name');
			$store->code			= Input::get('code');
			$store->price			= Input::get('price');
			$store->description		= Input::get('description');
			$store->status			= 1;
			$store->save();		
				
			if( Request::ajax() ) 
			{
				return Product::where('user_id', Auth::id())->where('status', 1)->select('id', 'name')->orderBy('id', 'desc')->get();	
			}		
		}
		else
		{
			return Redirect::to('product/create')->with('message', trans('invoice.validation_error_messages'))->withErrors($validator)->withInput();
		}	
		
		return Redirect::to('product')->with('message', trans('invoice.data_was_saved'));
	}
	
	public function update($id)
	{
		$rules = array(
			'name'		=> 'required',
			'code'		=> 'required',
			'price'		=> 'required',
		);		
		
		$validator = Validator::make(Input::all(), $rules);	
		
		if ($validator->passes())
		{
			$update					= Product::where('id', $id)->where('user_id', Auth::id())->first();
			$update->name			= Input::get('name');
			$update->code			= Input::get('code');
			$update->price			= Input::get('price');
			$update->description	= Input::get('description');
			$update->save();	
		}
		else
		{
			return Redirect::to('product/' . $id . '/edit')->with('message', trans('invoice.validation_error_messages'))->withErrors($validator)->withInput();
		}	
		
		return Redirect::to('product')->with('message', trans('invoice.data_was_updated'));
	}

	public function destroy($id)
	{
		$update 			= Product::where('id', $id)->where('user_id', Auth::id())->first();
		$update->status		= 0;
		$update->save();
		
		return Redirect::to('product')->with('message', trans('invoice.data_was_deleted'));		
	}
	/* === END C.R.U.D. === */

}