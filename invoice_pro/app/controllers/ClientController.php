<?php

class ClientController extends \BaseController {

	protected $layout = 'index';
	
	
	/* === VIEW === */
	public function index()
	{
		$client = new Client;
		
		$data = array(
			'clients' 	=> $client->userClients(),
			'app'		=> General::find(1)->first()
		);

		$this->layout->content = View::make('clients.index', $data);
	}

	public function create()
	{
		$this->layout->content = View::make('clients.create');
	}

	public function show($id)
	{
		$client = new Client();
		
		$data = array(
			'client' 	=> Client::where('id', $id)->where('user_id', Auth::id())->first(),
			'invoices'	=> $client->details($id)
		);
		
		$this->layout->content = View::make('clients.show', $data);
	}	
	
	public function edit($id)
	{
		$data = array(
			'client' => Client::where('id', $id)->where('user_id', Auth::id())->first()
		);
		
		$this->layout->content = View::make('clients.edit', $data);
	}
	/* === END VIEW === */
	
	
	/* === C.R.U.D. === */
	public function store()
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
		
		$validator = Validator::make(Input::all(), $rules);	
		
		if ($validator->passes())
		{
			$store					= new Client;
			$store->user_id			= Auth::id();
			$store->name			= Input::get('name');
			$store->country			= Input::get('country');
			$store->state			= Input::get('state');
			$store->city			= Input::get('city');
			$store->zip				= Input::get('zip');
			$store->address			= Input::get('address');
			$store->contact			= Input::get('contact');
			$store->phone			= Input::get('phone');
			$store->email			= Input::get('email');
			$store->website			= Input::get('website');
			$store->bank			= Input::get('bank');
			$store->bank_account	= Input::get('bank_account');
			$store->description		= Input::get('description');
			$store->save();	
		}
		else
		{
			return Redirect::to('client/create')->with('message', trans('invoice.validation_error_messages'))->withErrors($validator)->withInput();
		}	
		
		return Redirect::to('client')->with('message', trans('invoice.data_was_saved'));
	}
	
	public function update($id)
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
		
		$validator = Validator::make(Input::all(), $rules);		
		
		if ($validator->passes())
		{		
			$update					= Client::where('id', $id)->where('user_id', Auth::id())->first();
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
			$update->save();
		}
		else
		{
			return Redirect::to('client/' . $id . '/edit')->with('message', trans('invoice.validation_error_messages'))->withErrors($validator)->withInput();
		}
		
		return Redirect::to('client')->with('message', trans('invoice.data_was_updated'));
	}

	public function destroy($id)
	{
		$delete = Client::where('id', $id)->where('user_id', Auth::id());
		$delete->delete();
		
		return Redirect::to('client')->with('message', trans('invoice.data_was_deleted'));		
	}
	/* === END C.R.U.D. === */
	
}