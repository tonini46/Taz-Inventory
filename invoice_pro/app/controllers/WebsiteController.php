<?php

class WebsiteController extends \BaseController {

	protected $layout = 'login.index';
	
    public function __construct()
    {
		$app = General::find(1)->first();
		
		View::share('type', $app->type);
		View::share('users', User::where('status', 1)->count() - 1);
	}	
	
	
	/* === VIEW === */
	public function index()
	{
		$app = General::find(1)->first();
		
		$data = array(
			'type'	=> $app->type
		);
		
		if ( $app->type == 1 )
		{
			$this->layout->content = View::make('login.sign-in', $data);
		}
		else
		{
			$this->layout->content = View::make('login.design', $data);
		}	
	}
	/* === END VIEW === */
	
}