<?php

class BaseController extends Controller {

	/**
	 * Setup the layout used by the controller.
	 *
	 * @return void
	 */
	protected function setupLayout()
	{
		if ( ! is_null($this->layout))
		{
			$this->layout = View::make($this->layout);
		}
	}

	
	public function __construct()
	{
		if (Auth::check())
		{
			View::share('newInvoicesReceived', InvoiceReceived::where('user_id', Auth::id())->where('status', 0)->count());
			View::share('newMessagesReceived', Message::where('user_id', Auth::id())->where('status', 0)->count());			
		}
	}
}