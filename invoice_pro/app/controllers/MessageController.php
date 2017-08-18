<?php

class MessageController extends \BaseController {

	protected $layout = 'index';
	
	
	/* === VIEW === */
	public function index()
	{
		$message = new Message;
		
		$data = array(
			'received' 	=> $message->getAll(1),
			'sent' 		=> $message->getAll(2),
		);

		$this->layout->content = View::make('messages.index', $data);
	}

	public function create()
	{
		$user = new User;
		
		$data = array(
			'clients' => $user->onlineUsers()
		);		
		
		$this->layout->content = View::make('messages.create', $data);
	}

	public function show($id)
	{
		$message = new Message;
		$data = array(
			'message' => $message->getOne($id, 1)
		);
		
		$this->layout->content = View::make('messages.show', $data);			
	}	
	
	public function edit($id)
	{
		$update = Message::where('id', $id)->where('user_id', Auth::id())->first();
		$update->status = 1;
		$update->save();		
		
		$message = new Message;
		$data = array(
			'message' => $message->getOne($id, 2)
		);
		
		View::share('newMessagesReceived', Message::where('user_id', Auth::id())->where('status', 0)->count());
		
		$this->layout->content = View::make('messages.edit', $data);
	}
	/* === END VIEW === */
	
	
	/* === C.R.U.D. === */
	public function store()
	{
		$rules = array(
			'client'    => 'required',
			'title'     => 'required',
			'content'   => 'required',
		);	
		
		$validator = Validator::make(Input::all(), $rules);	
		
		if ($validator->passes())
		{
			if (Auth::user()->role_id == 2)
			{
				$store			= new Message;
				$store->user_id	= Input::get('client');
				$store->from_id	= Auth::id();
				$store->fill(Input::all());
				$store->save();	
			}
			else
			{
				$store			= new Message;
				$store->user_id	= Input::get('client');
				$store->from_id	= Auth::id();
				$store->fill(Input::all());
				$store->save();	
			}
		}
		else
		{
			if (Input::get('type'))
			{
				return Redirect::to('message/'. Input::get('messageID') . '/edit')->with('message', trans('invoice.validation_error_messages'))->withErrors($validator)->withInput();
			}
			
			return Redirect::to('message/create')->with('message', trans('invoice.validation_error_messages'))->withErrors($validator)->withInput();
		}	
		
		return Redirect::to('message')->with('message', trans('invoice.data_was_saved'));
		
	}
	
	public function update($id)
	{
		$update = Message::where('id', $id)->where('from_id', Auth::id())->first();
		$update->state = 1;
		$update->save();
		
		$delete = Message::where('id', $id)->where('from_id', Auth::id())->where('status', 2)->where('state', 1)->first();
		if ($delete)
		{
			$delete->delete();			
		}		
		
		return Redirect::to('message')->with('message', trans('invoice.data_was_deleted'));	
	}

	public function destroy($id)
	{
		$update = Message::where('id', $id)->where('user_id', Auth::id())->first();
		$update->status = 2;
		$update->save();
		
		$delete = Message::where('id', $id)->where('user_id', Auth::id())->where('status', 2)->where('state', 1)->first();
		if ($delete)
		{
			$delete->delete();			
		}	

		return Redirect::to('message')->with('message', trans('invoice.data_was_deleted'));		
	}
	/* === END C.R.U.D. === */
	
}