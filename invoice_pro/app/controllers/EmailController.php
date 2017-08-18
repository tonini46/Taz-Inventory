<?php

class EmailController extends \BaseController {

	protected $layout = 'index';
	
	
	/* === VIEW === */
	public function show($id)
	{
		$invoice	= new Invoice;
		$single		= $invoice->single($id, true);
		
		$data = array(
			'owner'				=> UserSetting::where('user_id', Auth::id())->first(),
			'logo'				=> Image::where('user_id', Auth::id())->first(),
			'invoice' 			=> $single,
			'invoiceSettings'	=> InvoiceSetting::where('user_id', Auth::id())->first(),
			'invoiceProducts'	=> $invoice->products($id, true),
		);
		
		$pathToFile 	= storage_path() . '/pdf/' . 'invoice_' . $single->number . '_' . date('Y-m-d') .'.pdf';
		$pdf 			= PDF::loadView('invoices.themes.theme_01', $data)->setPaper('letter')->setOrientation('portrait');
		$pdf->save($pathToFile);

		$contactEmail	= $single->email;
		$userDetails	= UserSetting::where('user_id', Auth::id())->first();	
		$userEmail		= $userDetails->email;
		
		$values = array(
			'text' 	=> trans('invoice.new_invoice_from') . $userDetails->name
		);		
		
		Mail::send('emails.index', $values, function($message) use ($userEmail, $contactEmail, $pathToFile)
		{
			$message->from($userEmail, trans('invoice.app_name'));

			$message->to($contactEmail)->subject(trans('invoice.new_invoice'));
			
			$message->attach($pathToFile);

		});	
		
		unlink($pathToFile);
		
		return Redirect::back()->with('message', trans('invoice.email_was_sent_to_client'));
	}	
	/* === END VIEW === */

}