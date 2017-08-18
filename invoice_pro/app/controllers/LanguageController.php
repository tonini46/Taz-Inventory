<?php

class LanguageController extends \BaseController {

	protected $layout = 'index';
	
	
	/* === VIEW === */
	public function index()
	{
		$data = array(
			'languages'	=> Language::all(),
		);
	
		$this->layout->content = View::make('admin.languages.index', $data);
	}

	public function create()
	{
		$this->layout->content = View::make('admin.languages.create');
	}

	public function show($id)
	{
		$data = array(
			'original'		=> File::getRequire(base_path().'/app/lang/_default/default.php'),
			'translated'	=> File::getRequire(base_path().'/app/lang/' . Language::where('id', $id)->first()->short . '/invoice.php')
		);
		
		$this->layout->content = View::make('admin.languages.show', $data);
	}
	
	public function edit($id)
	{
		$data = array(
			'language' => Language::where('id', $id)->first()
		);
		
		$this->layout->content = View::make('admin.languages.edit', $data);
	}
	/* === END VIEW === */
	
	
	/* === C.R.U.D. === */
	public function store()
	{
		$rules = array(
			'name'			=> 'required',
			'short_name'	=> 'required'
		);	
		
		$validator = Validator::make(Input::all(), $rules);		
		
		if ($validator->passes())
		{
			$dir = strtolower(Input::get('short_name'));
			
			if (!File::exists(app_path() . '/lang/' . $dir))
			{
				$store				= new Language;
				$store->name		= Input::get('name');
				$store->short		= $dir;
				$store->save();				
				
				File::copyDirectory( app_path() . '/lang/_original', app_path() . '/lang/' . $dir, 0777);
			}
			else
			{
				Session::flash('validationMessage', trans('invoice.directory_exist'));	
				
				return Redirect::to('language/create')->with('message', trans('invoice.validation_error_messages'))->withErrors($validator)->withInput();	
			}
		}
		else
		{
			return Redirect::to('language/create')->with('message', trans('invoice.validation_error_messages'))->withErrors($validator)->withInput();
		}	
		
		return Redirect::to('language')->with('message', trans('invoice.data_was_saved'));
	}
	
	public function update($id)
	{
		$rules = array(
			'name'			=> 'required'
		);	
		
		$validator = Validator::make(Input::all(), $rules);		
		
		if ($validator->passes())
		{	
			$update				= Language::where('id', $id)->first();
			$update->name		= Input::get('name');
			$update->save();
		}
		else
		{
			return Redirect::to('language/'. $id . '/edit')->with('message', trans('invoice.validation_error_messages'))->withErrors($validator)->withInput();
		}	
		
		return Redirect::to('language')->with('message', trans('invoice.data_was_saved'));		
	}

	public function destroy($id)
	{
		$delete = Language::where('id', $id)->first();
		$delete->delete();
		
		return Redirect::to('language')->with('message', trans('invoice.data_was_deleted'));		
	}
	/* === END C.R.U.D. === */

	
	/* === OTHERS === */
	public function translate()
	{
		$dir 	= Language::where('id', Input::get('languageID'))->first()->short;
		$words	= Input::get('words');
		
		$contents = "
		<?php
		return array(";
		
		foreach ($words as $k => $v)
		{
			$contents .= '"' . $k . '" => "' . $v . '", ';
		}
	
		$contents .= ");";
		
		File::put( app_path() . '/lang/' . $dir . '/invoice.php', $contents);
		
		return Redirect::to('language')->with('message', trans('invoice.data_was_saved'));
	}
	/* === END OTHERS === */
}