<?php

class Update extends Eloquent {

	
	const SOLSO_VERSION = '1.2';
	
	
	public function runUpdate()
	{
		$generals = DB::table('generals')->first();
		
		if ( $generals->version != self::SOLSO_VERSION )
		{
			DB::unprepared( file_get_contents(app_path().'/database/sql/update-' . self::SOLSO_VERSION . '.sql') );
			
			DB::table('generals')
					->where('id', 1)
					->update(array('version' => self::SOLSO_VERSION));			
		}	
	}	
	
}