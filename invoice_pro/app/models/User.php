<?php

use Illuminate\Auth\UserTrait;
use Illuminate\Auth\UserInterface;
use Illuminate\Auth\Reminders\RemindableTrait;
use Illuminate\Auth\Reminders\RemindableInterface;

class User extends Eloquent implements UserInterface, RemindableInterface {

	use UserTrait, RemindableTrait;

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'users';

	/**
	 * The attributes excluded from the model's JSON form.
	 *
	 * @var array
	 */
	protected $hidden = array('password', 'remember_token');



	public function onlineUsers()
	{
		if (Auth::user()->role_id == 2)
		{			
			$query = DB::table('users')
					->join('clients', 'clients.email', '=', 'users.email')
					->select(	'clients.id as userID',	'clients.name as name'
							)
					->where('clients.user_id', Auth::id())
					->get();		
		}
		
		if (Auth::user()->role_id == 3)
		{			
			$query = DB::table('clients')
					->join('user_settings', 'user_settings.user_id', '=', 'clients.user_id')
					->select('user_settings.user_id as userID', 'user_settings.name as name')
					->where('clients.email', Auth::user()->email)
					->get();		
		}		
		
		return $query;	
	}
	
}