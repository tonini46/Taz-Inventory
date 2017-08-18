<?php

class AdminController extends \BaseController {

	protected $layout = 'index';
	

	/* === VIEW === */
	public function index()
	{
		$reports = new Report;
		
		$data = array(
			'users'				=> User::where('role_id', '!=', 1)->count(),
			'invoices'			=> Invoice::all()->count(),
			'usersReport'		=> $reports->adminUsersReport(),
			'invoicesReport'	=> $reports->adminInvoicesReport()
		);
		
		$app = General::find(1)->first();
		
		if ( $app->type == 1 )
		{
			return Redirect::to('dashboard');
		}
		else
		{
			$this->layout->content = View::make('admin.index', $data);
		}		
	}
	/* === END VIEW === */
	

	/* === C.R.U.D. === */
	public function update($id)
	{
		$update 			= User::find($id);
		$update->status		= 1;
		$update->save();
		
		$data = array(
			'text' 	=> trans('invoice.your_account_was_approved')
		);

		$this->sendEmail($update->email, $data);
		
		return Redirect::to('user')->with('message', trans('invoice.account_was_approved'));
	}
	
	public function destroy($id)
	{
		$update 			= User::find($id);
		$update->status		= 2;
		$update->save();
		
		$data = array(
			'text' 	=> trans('invoice.your_account_was_banned')
		);

		$this->sendEmail($update->email, $data);
		
		return Redirect::to('user')->with('message', trans('invoice.account_was_banned'));	
	}	
	
	public function application()
	{
		$update 			= General::find(1);
		$update->type		= Input::get('value');
		$update->save();
		
		return Redirect::to('setting')->with('message', trans('invoice.data_was_updated'));		
	}
	/* === END C.R.U.D. === */	
	
	
	/* === OTHERS === */
	private function sendEmail($contactEmail, $values)
	{
		Mail::send('emails.index', $values, function($message) use ($contactEmail)
		{
			$message->from(Auth::user()->email, trans('invoice.app_name'));

			$message->to($contactEmail)->subject(trans('invoice.app_name'));

		});			
	}
	/* === END OTHERS === */
}