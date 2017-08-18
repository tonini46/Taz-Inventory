<?php

class Message extends Eloquent {

	protected 	$guarded 	= array('id','user_id', 'from_id');
	protected 	$fillable 	= array('title', 'content', 'status', 'state');


	public function getAll($type)
	{
		if ($type == 1)
		{
			$query = DB::table('messages')
					->join('user_settings', 'user_settings.user_id', '=', 'messages.from_id')
					->select(	'messages.*',
								'user_settings.name as name'
							)
					->where('messages.user_id', Auth::id())
					->whereIn('messages.status', array(0, 1))
					->get();
		}

		if ($type == 2)
		{
			$query = DB::table('messages')
					->join('user_settings', 'user_settings.user_id', '=', 'messages.from_id')
					->select(	'messages.*',
								'user_settings.name as name'
							)
					->where('messages.from_id', Auth::id())
					->where('messages.state', '=', 0)
					->whereIn('messages.status', array(0, 1, 2))
					->get();
		}

		return $query;
	}

	public function getOne($id, $type)
	{
		if ($type == 1)
		{
			$query = DB::table('messages')
					->join('user_settings', 'user_settings.user_id', '=', 'messages.from_id')
					->select(	'messages.*',
								'user_settings.name as name'
							)
					->where('messages.from_id', Auth::id())
					->where('messages.id', $id)
					->first();
		}		
		
		if ($type == 2)
		{
			$query = DB::table('messages')
					->join('user_settings', 'user_settings.user_id', '=', 'messages.from_id')
					->select(	'messages.*',
								'user_settings.name as name'
							)
					->where('messages.user_id', Auth::id())
					->where('messages.id', $id)
					->first();
		}
		
		return $query;
	}

}