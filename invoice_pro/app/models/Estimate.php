<?php

class Estimate extends Eloquent {

	protected 	$guarded 	= array('id','user_id');
	protected 	$fillable 	= array('client_id', 'currency_id', 'estimate', 'reference', 'estimate_date', 'expiry_date', 'description', 'terms', 'status');	
	
	public function getAll()
	{
		if (Auth::user()->role_id == 2)
		{
			$query = DB::table('estimates')
					->leftJoin('clients', 'clients.id', '=', 'estimates.client_id')
					->join('currencies', 'currencies.id', '=', 'estimates.currency_id')
					->select(	'estimates.*',
								'clients.name as name',
								'currencies.id as currencyID', 'currencies.name as currency', 'currencies.position'
							)
					->where('estimates.user_id', Auth::id())
					->get();
		}

		return $query;		
	}
	
	public function getOne($id, $owner)
	{
		if ($owner)
		{
			$query = DB::table('estimates')
					->leftJoin('clients', 'clients.id', '=', 'estimates.client_id')
					->join('currencies', 'currencies.id', '=', 'estimates.currency_id')
					->select(	'estimates.*', 'estimates.id as estimateID',
								'clients.name as name',
								'currencies.id as currencyID', 'currencies.name as currency', 'currencies.position'
							)
					->where('estimates.id', $id)
					->where('estimates.user_id', Auth::id())
					->first();					
		}
		else
		{
			$query = DB::table('estimates')
					->leftJoin('clients', 'clients.id', '=', 'estimates.client_id')
					->join('currencies', 'currencies.id', '=', 'estimates.currency_id')
					->select(	'estimates.*', 'estimates.id as estimateID',
								'clients.name as name',
								'currencies.id as currencyID', 'currencies.name as currency', 'currencies.position'
							)
					->where('estimates.id', $id)
					->where('clients.email', Auth::user()->email)
					->first();					
		}				
	
		return $query;		
	}

	public function estimatesReceived()
	{
		$query = DB::table('estimates')
				->leftJoin('user_settings', 'user_settings.user_id', '=', 'estimates.user_id')
				->leftJoin('clients', 'clients.id', '=', 'estimates.client_id')
				->join('currencies', 'currencies.id', '=', 'estimates.currency_id')
				->select(	'estimates.*',
							'user_settings.name as name',
							'currencies.id as currencyID', 'currencies.name as currency', 'currencies.position'
						)
				->where('clients.email', Auth::user()->email)
				->orderBy('expiry_date', 'desc')
				->get();
				
		return $query;
	}
	
	public function checkOwner($estimateID)
	{
		$query = DB::table('estimates')
				->leftJoin('user_settings', 'user_settings.user_id', '=', 'estimates.user_id')
				->leftJoin('clients', 'clients.id', '=', 'estimates.client_id')
				->join('currencies', 'currencies.id', '=', 'estimates.currency_id')
				->select(	'estimates.*',
							'user_settings.name as name',
							'currencies.id as currencyID', 'currencies.name as currency', 'currencies.position'
						)
				->where('clients.email', Auth::user()->email)
				->where('estimates.id', $estimateID)
				->count();
		
		if ($query == 1)	
		{
			return true;
		}
			
		return false;	
	}
	
	public function transformIntoInvoice($id)
	{
		$estimate = Estimate::where('id', $id)->where('client_id', $this->getOne($id, false)->client_id)->first();
		$estimate->status = 1;
		$estimate->save();
		
		$invoiceSettings = InvoiceSetting::where('user_id', $estimate->user_id)->first();

		if (isset($invoiceSettings->number))
		{
			$invoiceNumber 				= $invoiceSettings->number + 1;
			$invoiceSettings->number	= $invoiceNumber;
			$invoiceSettings->save();
		}		

		$store					= new Invoice;
		$store->user_id			= $estimate->user_id;
		$store->client_id		= $estimate->client_id;
		$store->status_id		= 2;
		$store->currency_id		= $estimate->currency_id;
		$store->number			= isset($invoiceSettings->number) ? $invoiceNumber : Input::get('number');
		$store->discount		= $estimate->discount;
		$store->type    		= $estimate->type;
		$store->amount			= $estimate->amount;
		$store->start_date		= date('Y-m-d');
		$store->due_date		= date('Y-m-d', strtotime("+30 days"));
		$store->description		= $estimate->description;
		$store->save();		
		
		$products				= EstimateProduct::where('user_id', $estimate->user_id)->where('estimate_id', $id)->get();
		
		foreach ($products as $p)
		{
			$product 					= new InvoiceProduct;
			$product->user_id			= $estimate->user_id;
			$product->invoice_id		= $store->id;
			$product->product_id		= $p->product_id;
			$product->quantity			= $p->quantity;
			$product->price    			= $p->price;
			$product->tax	    		= $p->tax;
			$product->discount    		= $p->discount;
			$product->discount_type		= $p->discount_type;
			$product->discount_value	= $p->discount_value;
			$product->amount			= $p->amount;
			$product->save();		
		}		
		
		$invoice = new Invoice;
		$invoice->invoiceStatus();				
		
		$invoiceReceived 				= new InvoiceReceived;
		$invoiceReceived->invoice_id	= $store->id;
		$invoiceReceived->user_id		= $estimate->client_id;
		$invoiceReceived->status		= 0;
		$invoiceReceived->save();		
	}
}