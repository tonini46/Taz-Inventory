<?php

class InvoiceController extends \BaseController {

	protected $layout = 'index';
	
	
	/* === VIEW === */
	public function index()
	{
		$invoices	= new Invoice;
		$check	 	= new UserSetting;
		
		$data = array(
			'invoices'			=> $invoices->invoices(),
			'invoiceSettings'	=> InvoiceSetting::where('user_id', Auth::id())->first(),
			'clients' 			=> Client::where('user_id', Auth::id())->count(),
			'products' 			=> Product::where('user_id', Auth::id())->where('status', 1)->count(),
			'payments'			=> Payment::where('user_id', Auth::id())->get(),
			'status'			=> InvoiceStatus::all(),
			'check'				=> $check->checkSettings(),
			'invoicesReceived'	=> $invoices->invoicesReceived(),
			'type'				=> General::find(1)->first()->type
		);
		
		$this->layout->content = View::make('invoices.index', $data);
	}

	public function create()
	{
		$invoiceSettings	= InvoiceSetting::where('user_id', Auth::id())->first();
		
		$data = array(
			'clients' 		=> Client::where('user_id', Auth::id())->get(),
			'products' 		=> Product::where('user_id', Auth::id())->where('status', 1)->get(),
			'currencies'	=> Currency::where('user_id', Auth::id())->get(),
			'taxes'			=> Tax::where('user_id', Auth::id())->get(),
			'payments'		=> Payment::where('user_id', Auth::id())->get(),
			'invoiceCode'	=> isset($invoiceSettings->code) ? $invoiceSettings->code : false,
			'invoiceNumber'	=> isset($invoiceSettings->number) ? $invoiceSettings->number + 1 : false
		);
		
		$this->layout->content = View::make('invoices.create', $data);
	}

	public function show($id)
	{
		$newInvoice = new Invoice;
		$payment	= new InvoicePayment;
		$invoice	= $newInvoice->single($id, Request::segment(3) ? false : true);
		
		if ( $invoice ) 
		{
			$userID = Request::segment(3) ? $invoice->user_id : Auth::id();
			
			$data = array(
				'owner'				=> UserSetting::where('user_id', $userID)->first(),
				'logo'				=> Image::where('user_id', $userID)->first(),
				'invoice' 			=> $invoice,
				'invoiceSettings'	=> InvoiceSetting::where('user_id', $userID)->first(),
				'invoiceProducts'	=> $newInvoice->products($id, Request::segment(3) ? false : true),
				'invoicePayments'	=> $payment->payments($id)
			);
			
			if (Request::segment(3))
			{
				$this->markInvoiceReceived($id);
				View::share('newInvoicesReceived', InvoiceReceived::where('user_id', Auth::id())->where('status', 0)->count());
			}	

			$this->layout->content = View::make('invoices.show', $data);
		}	
		else 
		{
			Auth::logout();
			
			return Redirect::to('login')->with('message', trans('invoice.access_denied'));			
		}			
	}
	
	public function edit($id)
	{
		$newInvoice 		= new Invoice;
		$invoice			= $newInvoice->single($id, true);
		
		if ( $invoice ) 
		{
			$data = array(
				'invoice'			=> $invoice,
				'invoiceCode'		=> InvoiceSetting::where('user_id', Auth::id())->first(),
				'clients' 			=> Client::where('user_id', Auth::id())->get(),
				'client'			=> Invoice::find($id)->client,
				'invoiceProducts'	=> $newInvoice->products($id, true),
				'products' 			=> Product::where('user_id', Auth::id())->where('status', 1)->get(),
				'currencies'		=> Currency::where('user_id', Auth::id())->get(),
				'taxes'				=> Tax::where('user_id', Auth::id())->get(),
				'payments'			=> Payment::where('user_id', Auth::id())->get()
			);
			
			$this->layout->content = View::make('invoices.edit', $data);
		}
		else 
		{
			Auth::logout();
			
			return Redirect::to('login')->with('message', trans('invoice.access_denied'));			
		}
	}
	/* === END VIEW === */
	
	
	/* === C.R.U.D. === */
	public function store()
	{
		$rules = array(
			'client'	=> 'required',
			'number'	=> 'required',
			'currency'	=> 'required',			
			'startDate'	=> 'required',
			'endDate'	=> 'required'
		);	
		
		$validator = Validator::make(Input::all(), $rules);	
		
		if ($validator->passes())
		{
			$invoiceSettings = InvoiceSetting::where('user_id', Auth::id())->first();

			if (isset($invoiceSettings->number))
			{
				$invoiceNumber 				= $invoiceSettings->number + 1;
				$invoiceSettings->number	= $invoiceNumber;
				$invoiceSettings->save();
			}		

			$store					= new Invoice;
			$store->user_id			= Auth::id();
			$store->client_id		= Input::get('client');
			$store->status_id		= 2;
			$store->currency_id		= Input::get('currency');
			$store->number			= isset($invoiceSettings->number) ? $invoiceNumber : Input::get('number');
			$store->discount		= Input::get('invoiceDiscount') ? Input::get('invoiceDiscount') : 0;
			$store->type    		= Input::get('invoiceDiscountType') ? Input::get('invoiceDiscountType') : 0;
			$store->amount			= $store->totalInvoice(Input::get('qty'), Input::get('price'), Input::get('taxes'), Input::get('discount'), Input::get('discountType'), Input::get('invoiceDiscount'), Input::get('invoiceDiscountType'));
			$store->start_date		= Input::get('startDate');
			$store->due_date		= Input::get('endDate');
			$store->description		= Input::get('description');
			$store->save();

			$products				= Input::get('products');
			
			foreach ($products as $k => $v)
			{
				$product 					= new InvoiceProduct;
				$product->user_id			= Auth::id();
				$product->invoice_id		= $store->id;
				$product->product_id		= $v;
				$product->quantity			= Input::get('qty')[$k];
				$product->price    			= Input::get('price')[$k];
				$product->tax	    		= Input::get('taxes')[$k];
				$product->discount    		= Input::get('discount')[$k] ? Input::get('discount')[$k] : 0;
				$product->discount_type		= Input::get('discountType')[$k] ? Input::get('discountType')[$k] : 0;
				$product->discount_value	= $store->totalProduct(1, Input::get('qty')[$k], Input::get('price')[$k], Input::get('taxes')[$k], Input::get('discount')[$k], Input::get('discountType')[$k]);	
				$product->amount			= $store->totalProduct(2, Input::get('qty')[$k], Input::get('price')[$k], Input::get('taxes')[$k], Input::get('discount')[$k], Input::get('discountType')[$k]);	
				$product->save();		
			}
			
			if (Input::get('paymentAmount') && Input::get('paymentDate') && Input::get('paymentMethod'))
			{
				$payment 					= new InvoicePayment;
				$payment->user_id			= Auth::id();
				$payment->invoice_id		= $store->id;
				$payment->payment_id		= Input::get('paymentMethod');
				$payment->payment_date		= Input::get('paymentDate');
				$payment->payment_amount	= Input::get('paymentAmount');
				$payment->save();	

				$payment->balance($store->id);			
			}
			
			$invoice = new Invoice;
			$invoice->invoiceStatus();
			
			$email 	= Client::where('id', Input::get('client'))->first();
			$user 	= UserSetting::where('email', $email->email)->first();			
			
			if ($user)
			{
				$invoiceReceived 				= new InvoiceReceived;
				$invoiceReceived->invoice_id	= $store->id;
				$invoiceReceived->user_id		= $user->user_id;
				$invoiceReceived->status		= 0;
				$invoiceReceived->save();
			}
		}
		else
		{
			return Redirect::to('invoice/create')->with('message', trans('invoice.validation_error_messages'))->withErrors($validator)->withInput();
		}	
		
		return Redirect::to('invoice')->with('message', trans('invoice.data_was_saved'));
	}
	
	public function update($id)
	{
		$rules = array(
			'client'	=> 'required',
			'number'	=> 'required',
			'currency'	=> 'required',			
			'startDate'	=> 'required',
			'endDate'	=> 'required'
		);	
		
		$validator = Validator::make(Input::all(), $rules);	
		
		if ($validator->passes())
		{
			$delete = InvoiceProduct::where('user_id', Auth::id())->where('invoice_id', $id);
			$delete->delete();	
			
			$update					= Invoice::where('id', $id)->where('user_id', Auth::id())->first();
			$update->client_id		= Input::get('client');
			$update->currency_id	= Input::get('currency');
			$update->number			= Input::get('number');
			$update->discount		= Input::get('invoiceDiscount') ? Input::get('invoiceDiscount') : 0;
			$update->type    		= Input::get('invoiceDiscountType') ? Input::get('invoiceDiscountType') : 0;
			$update->amount			= $update->totalInvoice(Input::get('qty'), Input::get('price'), Input::get('taxes'), Input::get('discount'), Input::get('discountType'), Input::get('invoiceDiscount'), Input::get('invoiceDiscountType'));
			$update->start_date		= Input::get('startDate');
			$update->due_date		= Input::get('endDate');
			$update->description	= Input::get('description');
			$update->save();	
			
			$products				= Input::get('products');
			
			foreach ($products as $k => $v)
			{
				$product 					= new InvoiceProduct;
				$product->user_id			= Auth::id();
				$product->invoice_id		= $update->id;
				$product->product_id		= $v;
				$product->quantity			= Input::get('qty')[$k];
				$product->price    			= Input::get('price')[$k];
				$product->tax	    		= Input::get('taxes')[$k];
				$product->discount    		= Input::get('discount')[$k] ? Input::get('discount')[$k] : 0;
				$product->discount_type		= Input::get('discountType')[$k] ? Input::get('discountType')[$k] : 0;
				$product->discount_value	= $update->totalProduct(1, Input::get('qty')[$k], Input::get('price')[$k], Input::get('taxes')[$k], Input::get('discount')[$k], Input::get('discountType')[$k]);	
				$product->amount			= $update->totalProduct(2, Input::get('qty')[$k], Input::get('price')[$k], Input::get('taxes')[$k], Input::get('discount')[$k], Input::get('discountType')[$k]);	
				$product->save();				
			}
			
			$payment	= new InvoicePayment;
			$payment->balance($update->id);
		}
		else
		{
			return Redirect::to('invoice/' . $id . '/edit')->with('message', trans('invoice.validation_error_messages'))->withErrors($validator)->withInput();
		}					

		return Redirect::to('invoice/' . $id)->with('message', trans('invoice.data_was_updated'));
	}

	public function destroy($id)
	{
		$delete = Invoice::where('id', $id)->where('user_id', Auth::id());
		$delete->delete();
		
		return Redirect::to('invoice')->with('message', trans('invoice.data_was_deleted'));		
	}
	/* === END C.R.U.D. === */
	
	
	/* === OTHERS === */
	public function addPayment($id)
	{
		$rules = array(
			'amount'	=> 'required',
			'date'		=> 'required|date',
			'payment'	=> 'required',
		);	
		
		$validator = Validator::make(Input::all(), $rules);	
		
		if ($validator->passes())
		{		
			$store 					= new InvoicePayment;
			$store->user_id			= Auth::id();
			$store->invoice_id		= Request::segment(3);
			$store->payment_id		= Input::get('payment');
			$store->payment_date	= Input::get('date');
			$store->payment_amount	= Input::get('amount');
			$store->save();	

			$store->balance(Request::segment(3));
		}	
		else
		{
			return Redirect::to('invoice')->with('message', trans('invoice.validation_error_messages'))->withErrors($validator)->withInput();
		}	
		
		return Redirect::to('invoice')->with('message', trans('invoice.data_was_saved'));		
	}
	
	public function storeInvoiceNumber()
	{
		$update = InvoiceSetting::where('user_id', Auth::id())->first();
		
		if ( $update )
		{
			$update->number		= Input::get('value');
			$update->save();
			
			return Redirect::back()->with('message', trans('invoice.data_was_updated'));	
		}
		else
		{
			$store 				= new InvoiceSetting;
			$store->user_id		= Auth::id();
			$store->number		= Input::get('value');
			$store->save();
			
			return Redirect::back()->with('message', trans('invoice.data_was_saved'));	
		}
	}	
	
	public function storeInvoiceCode()
	{
		$update = InvoiceSetting::where('user_id', Auth::id())->first();
		
		if ( $update )
		{
			$update->code		= Input::get('value');
			$update->save();
			
			return Redirect::back()->with('message', trans('invoice.data_was_updated'));	
		}
		else
		{
			$store 				= new InvoiceSetting;
			$store->user_id		= Auth::id();
			$store->code		= Input::get('value');
			$store->save();
			
			return Redirect::back()->with('message', trans('invoice.data_was_saved'));	
		}
	}	
	
	public function storeInvoiceText()
	{
		$update = InvoiceSetting::where('user_id', Auth::id())->first();
		
		if ( $update )
		{
			$update->text		= Input::get('description');
			$update->save();
			
			return Redirect::back()->with('message', trans('invoice.data_was_updated'));	
		}
		else
		{
			$store 				= new InvoiceSetting;
			$store->user_id		= Auth::id();
			$store->text		= Input::get('description');
			$store->save();
			
			return Redirect::back()->with('message', trans('invoice.data_was_saved'));	
		}
	}	
	
	public function updateStatus($id)
	{
		$update					= Invoice::where('id', $id)->where('user_id', Auth::id())->first();
		$update->status_id		= Input::get('status');
		$update->save();
		
		return Redirect::to('invoice')->with('message', trans('invoice.data_was_updated'));			
	}	
	
	public function updateDueDate($id)
	{
		$update					= Invoice::where('id', $id)->where('user_id', Auth::id())->first();
		$update->status_id		= 2;
		$update->due_date		= Input::get('endDate');
		$update->save();
		
		return Redirect::to('invoice')->with('message', trans('invoice.data_was_updated'));			
	}	
	
	public function deleteProduct()
	{
		$delete = InvoiceProduct::where('id', Input::get('id'))->where('user_id', Auth::id());
		$delete->delete();
	}
	
	private function markInvoiceReceived($invoiceID)
	{
		$invoice = InvoiceReceived::where('invoice_id', $invoiceID)->where('user_id', Auth::id())->first();
		
		if ($invoice)
		{
			$update				= $invoice ;
			$update->status		= 1;
			$update->save();	
		}
		else
		{
			$store				= new InvoiceReceived;
			$store->invoice_id	= $invoiceID;
			$store->user_id		= Auth::id();
			$store->status		= 1;
			$store->save();				
		}
	}
	/* === END OTHERS === */

}