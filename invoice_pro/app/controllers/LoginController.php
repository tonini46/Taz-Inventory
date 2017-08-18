<?php

class LoginController extends \BaseController {

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
		
		$this->layout->content = View::make('login.sign-in', $data);
	}
	
	public function createAccount()
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
			$this->layout->content = View::make('login.create-account', $data);
		}		
	}
	
	public function forgotPassword()
	{
		$this->layout->content = View::make('login.password');
	}	
	/* === END VIEW === */
	
	
	/* === C.R.U.D. === */
	public function store()
	{
		$rules = array(
			'create-email'		=> 'required|email',
			'repeat-email'		=> 'required|email|same:create-email',
			'create-password'	=> 'required|min:6',
		);	
		
		$validator = Validator::make(Input::all(), $rules);	
		
		if ($validator->passes())
		{
			if ( User::where('email', Input::get('create-email'))->count() == 0 )
			{
				$store				= new User;
				$store->role_id		= 2;
				$store->email		= Input::get('create-email');
				$store->password	= Hash::make(Input::get('create-password'));
				$store->status		= 0;
				$store->save();	
				
				$settings			= new UserSetting;
				$settings->user_id	= $store->id;
				$settings->status	= 0;
				$settings->save();	
			}
			else
			{
				return Redirect::to('login')->with('message', 'This email address is already registered in our database !');
			}
		}
		else
		{
			return Redirect::to('login')->with('message', "Validation Error Messages ")->withErrors($validator);
		}		
		
		return Redirect::to('login')->with('message', 'Your account was created, an e-mail will be sent after admin approve your account !');
	}
	
	public function auth()
	{
		$rules = array(
			'email'		=> 'required|email',
			'password'	=> 'required|min:6',
		);	
		
		$validator = Validator::make(Input::all(), $rules);
	
		if ($validator->passes())
		{
			if ( Auth::attempt(Input::only('email', 'password'), $remember = false) )
			{
				if ( Auth::user()->status == 1 )
				{
					if ( Auth::user()->role_id == 1 )
					{
						return Redirect::to('admin')->with('message', 'You are successfully logged in !');
					}
					else
					{
						return Redirect::to('dashboard')->with('message', 'You are successfully logged in !');
					}
				}	
				elseif ( Auth::user()->status == 2 )
				{
					return Redirect::to('login')->with('message', 'Your account was banned !');
				}
				else
				{
					return Redirect::to('login')->with('message', 'Your account was not approved yet !');
				}
			}
			else
			{
				return Redirect::to('login')->with('message', 'Your username/password combination was incorrect !');
			}	
		}
		else
		{
			return Redirect::to('login')->with('message', "Validation Error Messages ")->withErrors($validator);
		}
	}

	public function reset()
	{
		$rules = array(
			'email'		=> 'required|email',
		);	
		
		$validator = Validator::make(Input::all(), $rules);	
		
		if ($validator->passes())
		{
			if ( User::where('email', Input::get('email'))->count() == 1 )
			{
				$pass 				= str_random(10);
				
				$update				= User::where('email', Input::get('email'))->first();
				$update->password 	= Hash::make($pass);
				$update->save();
				
				$fromEmail	= User::find(1)->where('role_id', 1)->first()->email;	
				$toEmail	= Input::get('email');;
				$title		= "Reset password";
				$subject	= "Reset password";
				
				$values = array(
					'user'		=> Input::get('email'),
					'password' 	=> $pass
				);	
				
				Mail::send('emails.reset', $values, function($message) use ($fromEmail, $toEmail, $title, $subject)
				{
					$message->from($fromEmail, $title);

					$message->to($toEmail)->subject($subject);

				});					
			}
			else
			{
				return Redirect::to('forgot-password')->with('warning', 'This email is not registered !');
			}
		}
		else
		{
			return Redirect::to('forgot-password')->with('warning', "Validation Error Messages ")->withErrors($validator);
		}

		// return Redirect::to('login')->with('message', 'The password was reset !');
	}	
	
	public function logout()
	{
		Auth::logout();
		
		return Redirect::to('');
	}
	/* === END C.R.U.D. === */
}