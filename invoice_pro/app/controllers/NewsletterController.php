<?php

class NewsletterController extends \BaseController {

	protected $layout = 'index';
	

	/* === VIEW === */
	public function show($id)
	{
		$store				= new Invitation;
		$store->user_id		= Auth::id();
		$store->client_id	= $id;
		$store->status		= 1;
		$store->save();		
	
		$text = Newsletter::where('user_id', Auth::id())->first();
		
		$data = array(
			'title'		=> isset($text->title) 		? $text->title 		: '',
			'content' 	=> isset($text->content)	? $text->content	: ''
		);
		
		$contactEmail = Client::where('id', $id)->where('user_id', Auth::id())->first()->email;
		
		
		Mail::send('emails.invitation', $data, function($message) use ($contactEmail)
		{
			$message->from(Auth::user()->email, trans('invoice.app_name'));

			$message->to($contactEmail)->subject(trans('invoice.invitation'));

		});	
		
		return Redirect::to('client')->with('message', trans('invoice.an_invitation_was_sent'));
	}	
	/* === END VIEW === */
	
	
	/* === C.R.U.D. === */
	public function store()
	{
		$store				= new Newsletter;
		$store->user_id		= Auth::id();
		$store->title		= Input::get('title');
		$store->content		= Input::get('content');
		$store->save();	

		return Redirect::to('setting')->with('message', trans('invoice.data_was_saved'));
	}
	
	public function update($id)
	{
		$update				= Newsletter::where('id', $id)->where('user_id', Auth::id())->first();
		$update->title		= Input::get('title');
		$update->content	= Input::get('content');
		$update->save();	

		return Redirect::to('setting')->with('message', trans('invoice.data_was_updated'));
	}
	/* === END C.R.U.D. === */

}