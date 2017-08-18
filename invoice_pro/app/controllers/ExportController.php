<?php

class ExportController extends \BaseController {

	public function exportExcel($id)
	{
		$newInvoice 		= new Invoice;
		$invoice			= $newInvoice->single($id, Request::segment(3) ? false : true);

		if ( $invoice ) 
		{
			$userID = Request::segment(3) ? $invoice->user_id : Auth::id();
			
			$data = array(
				'owner'				=> UserSetting::where('user_id', $userID)->first(),
				'logo'				=> Image::where('user_id', $userID)->first(),
				'invoice' 			=> $invoice,
				'invoiceSettings'	=> InvoiceSetting::where('user_id', $userID)->first(),
				'invoiceProducts'	=> $newInvoice->products($id,  Request::segment(3) ? false : true)
			);		
		}
		else 
		{
			return Redirect::to('invoice')->with('message', trans('invoice.access_denied'));
		}		
		
		Excel::create('New file', function($excel) use ($data) {

			return $excel->sheet('Invoice', function($sheet) use ($data) {

				$sheet->loadView('invoices.export.excel', $data);

			})->export('xlsx');

		});		
	}
	
}