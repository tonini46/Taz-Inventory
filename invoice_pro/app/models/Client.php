<?php

class Client extends Eloquent {


	public function userClients()
	{
		$query = DB::table('clients')
				->leftJoin('invitations', 'invitations.client_id', '=', 'clients.id')
				->select(	'clients.*',
							'invitations.status'
						)				
				->where('clients.user_id', Auth::id())
				->get();
				
		return $query;	
	}
	
	public function details($clientID)
	{
		$query = DB::table('clients')
				->join('invoices', 'invoices.client_id', '=', 'clients.id')
				->join('invoice_statuses', 'invoice_statuses.id', '=', 'invoices.status_id')
				->join('invoice_payments','invoice_payments.invoice_id', '=', 'invoices.id')
				->select(	'clients.name as client', 
							'invoices.id', 'invoices.number', 'invoices.amount', 'invoices.due_date', 
							'invoice_statuses.name as status', 
							DB::raw('SUM(invoice_payments.payment_amount) as paid')
						)				
				->where('clients.id', $clientID)
				->where('clients.user_id', Auth::id())
				->groupBy('invoices.id')
				->get();
				
		return $query;		
	}
	
	public function clientUsers()
	{
		$query = DB::table('clients')
				->leftJoin('user_settings', 'user_settings.user_id', '=', 'clients.user_id')
				->select(	'clients.*', 
							'user_settings.user_id as userID', 'user_settings.name'
						)				
				->where('clients.email', Auth::user()->email)
				->get();
				
		return $query;		
	}
	
}