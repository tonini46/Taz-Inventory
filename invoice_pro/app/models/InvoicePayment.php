<?php

class InvoicePayment extends Eloquent {

	public $timestamps = false;
	
	
	public function balance($invoiceID)
	{
		$invoice 	= Invoice::where('user_id', Auth::id())->where('id', $invoiceID)->first();
		$payments	= InvoicePayment::select(DB::raw('SUM(invoice_payments.payment_amount) as paid'))
						->where('invoice_id', $invoiceID)
						->where('user_id', Auth::id())
						->first();
		
		$update		= Invoice::where('user_id', Auth::id())->where('id', $invoiceID)->first();
		$update->status_id	= 1;
		
		if ( $invoice->amount != $payments['paid'] )
		{
			$update->status_id	= 3;
		}
		
		$update->save();	
	}
	
	public function payments($invoiceID)
	{
		$query = DB::table('invoice_payments')
				->join('payments', 'payments.id', '=', 'invoice_payments.payment_id')	
				->where('invoice_payments.invoice_id', $invoiceID)
				->where('invoice_payments.user_id', Auth::id())
				->get();		
		
		return $query;	
	}
	
}