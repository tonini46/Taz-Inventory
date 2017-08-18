<?php

class DashboardController extends \BaseController {

	protected $layout = 'index';
	
	
	public function index()
	{
		if (Auth::user()->role_id != 3)
		{
			$invoice = new Invoice;
			$reports = new Report;
			$check	 = new UserSetting;
			$invoice->invoiceStatus();
			
			$data = array(
				'clients'			=> Client::where('user_id', Auth::id())->count(),
				'products'			=> Product::where('user_id', Auth::id())->where('status', 1)->count(),
				'invoices'			=> Invoice::where('user_id', Auth::id())->count(),
				'totalAmount'		=> Invoice::where('user_id', Auth::id())->where('status_id', 1)->sum('amount'),
				'invoiceChart'		=> $invoice->invoiceChart(),
				'reports'			=> $reports->invoices(),
				'lastInvoices'		=> $invoice->lastUnpaidInvoices(),
				'overdueInvoices'	=> $invoice->overdueInvoices(),
				'check'				=> $check->checkSettings()
			);		

			$this->layout->content = View::make('dashboard.index', $data);
		}		
		else
		{
			$invoices	= new Invoice;
			$client 	= Client::where('email', Auth::user()->email)->first();	
		
			$data = array(
				'totalAmount'		=> isset($client->id) ? Invoice::where('client_id', $client->id )->sum('amount') : 0,
				'invoicesReceived'	=> $invoices->invoicesReceived()
			);			
		
			$this->layout->content = View::make('dashboard.client', $data);
		}
	}

}