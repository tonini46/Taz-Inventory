<?php

class EstimateController extends \BaseController {

	protected $layout = 'index';

	
	/* === VIEW === */
	public function index()
	{
		$estimate 	= new Estimate;
		$check	 	= new UserSetting;
		
		if (Auth::user()->role_id == 2)
		{
			$data = array(
				'estimates' 		=> $estimate->getAll(),
				'invoiceSettings'	=> InvoiceSetting::where('user_id', Auth::id())->first(),
				'clients' 			=> Client::where('user_id', Auth::id())->count(),
				'products' 			=> Product::where('user_id', Auth::id())->where('status', 1)->count(),
				'payments'			=> Payment::where('user_id', Auth::id())->get(),
				'status'			=> InvoiceStatus::all(),
				'check'				=> $check->checkSettings(),
				'estimatesReceived'	=> $estimate->estimatesReceived()
			);		
		}
		
		if (Auth::user()->role_id == 3)
		{
			$data = array(
				'estimatesReceived'	=> $estimate->estimatesReceived()
			);
		}

		$this->layout->content = View::make('estimates.index', $data);
	}

	public function create()
	{
		if (Auth::user()->role_id == 3)
		{
			return Redirect::to('dashboard')->with('message', trans('invoice.access_denied') );	
		}
		
		$user = new User;
		
		$data = array(
			'clients' 		=> $user->onlineUsers(),
			'products' 		=> Product::where('user_id', Auth::id())->where('status', 1)->get(),
			'currencies'	=> Currency::where('user_id', Auth::id())->get(),
			'taxes'			=> Tax::where('user_id', Auth::id())->get()
		);

		$this->layout->content = View::make('estimates.create', $data);
	}

	public function show($id)
	{
		$estimate 			= new Estimate;
		$estimateProduct	= new EstimateProduct;
		$estimateDetails	= $estimate->getOne($id, Request::segment(3) ? false : true);	
		
		if (!$estimateDetails)
		{
			return Redirect::to('dashboard')->with('message', trans('invoice.access_denied') );	
		}
		
		$data = array(
			'estimate'			=> $estimateDetails,
			'estimateProducts'	=> $estimateProduct->getEstimateProducs($id, Request::segment(3) ? false : true),
		);
		
		$this->layout->content = View::make('estimates.show', $data);	
	}	
	
	public function edit($id)
	{	
		if (Auth::user()->role_id == 3)
		{
			return Redirect::to('dashboard')->with('message', trans('invoice.access_denied') );	
		}

		$client				= new Client;
		$estimate 			= new Estimate;
		$estimateProduct	= new EstimateProduct;
		
		$data = array(
			'clients' 			=> $client->userClients(),
			'estimate'			=> $estimate->getOne($id, true),
			'estimateProducts'	=> $estimateProduct->getEstimateProducs($id, true),
			'products' 			=> Product::where('user_id', Auth::id())->where('status', 1)->get(),
			'currencies'		=> Currency::where('user_id', Auth::id())->get(),
			'taxes'				=> Tax::where('user_id', Auth::id())->get()
		);
		
		$this->layout->content = View::make('estimates.edit', $data);
	}
	/* === END VIEW === */
	
	
	/* === C.R.U.D. === */
	public function store()
	{
		if (Auth::user()->role_id == 3)
		{
			return Redirect::to('dashboard')->with('message', trans('invoice.access_denied') );	
		}
		
		$rules = array(
			'client_id'     	=> 'required',
			'estimate_date'		=> 'required',
			'expiry_date'		=> 'required',
			'currency_id'		=> 'required'
		);	
		
		$validator = Validator::make(Input::all(), $rules);	
		
		if ($validator->passes())
		{
			$invoice				= new Invoice;
			$store					= new Estimate;
			$store->user_id 		= Auth::id();
			$store->discount		= Input::get('invoiceDiscount') ? Input::get('invoiceDiscount') : 0;
			$store->type    		= Input::get('invoiceDiscountType') ? Input::get('invoiceDiscountType') : 0;
			$store->amount			= $invoice->totalInvoice(Input::get('qty'), Input::get('price'), Input::get('taxes'), Input::get('discount'), Input::get('discountType'), Input::get('invoiceDiscount'), Input::get('invoiceDiscountType'));				
			$store->fill(Input::all());
			$store->save();	
			
			$products				= Input::get('products');
			
			foreach ($products as $k => $v)
			{
				$product 					= new EstimateProduct;
				$product->user_id			= Auth::id();
				$product->estimate_id		= $store->id;
				$product->product_id		= $v;
				$product->quantity			= Input::get('qty')[$k];
				$product->price    			= Input::get('price')[$k];
				$product->tax	    		= Input::get('taxes')[$k];
				$product->discount    		= Input::get('discount')[$k] ? Input::get('discount')[$k] : 0;
				$product->discount_type		= Input::get('discountType')[$k] ? Input::get('discountType')[$k] : 0;
				$product->discount_value	= $invoice->totalProduct(1, Input::get('qty')[$k], Input::get('price')[$k], Input::get('taxes')[$k], Input::get('discount')[$k], Input::get('discountType')[$k]);	
				$product->amount			= $invoice->totalProduct(2, Input::get('qty')[$k], Input::get('price')[$k], Input::get('taxes')[$k], Input::get('discount')[$k], Input::get('discountType')[$k]);	
				$product->save();		
			}		
		}
		else
		{
			return Redirect::to('estimate/create')->with('message', trans('invoice.validation_error_messages'))->withErrors($validator)->withInput();
		}	
		
		return Redirect::to('estimate')->with('message', trans('invoice.data_was_saved'));
	}
	
	public function update($id)
	{
		if (Auth::user()->role_id == 3)
		{
			return Redirect::to('dashboard')->with('message', trans('invoice.access_denied') );	
		}
		
		$rules = array(
			'client_id'     	=> 'required',
			'estimate_date'		=> 'required',
			'expiry_date'		=> 'required'
		);		
		
		$validator = Validator::make(Input::all(), $rules);		
		
		if ($validator->passes())
		{		
			$update = Estimate::where('id', $id)->where('user_id', Auth::id())->first();
			$update->fill(Input::all());
			$update->save();
		}
		else
		{
			return Redirect::to('estimate/' . $id . '/edit')->with('message', trans('invoice.validation_error_messages'))->withErrors($validator)->withInput();
		}
		
		return Redirect::to('estimate')->with('message', trans('invoice.data_was_updated'));
	}

	public function destroy($id)
	{
		if (Auth::user()->role_id == 3)
		{
			return Redirect::to('dashboard')->with('message', trans('invoice.access_denied') );	
		}		

		$delete = Estimate::where('id', $id)->where('user_id', Auth::id());
		$delete->delete();			
		
		$delete = EstimateProduct::where('estimate_id', $id)->where('user_id', Auth::id());
		$delete->delete();
		
		return Redirect::to('estimate')->with('message', trans('invoice.data_was_deleted'));
	}
	/* === END C.R.U.D. === */
	
	
	/* === OTHERS === */
	public function approve($id)
	{
		$estimate = new Estimate;

		if ($estimate->checkOwner($id))
		{
			$estimate->transformIntoInvoice($id);
		}	
		else
		{
			return Redirect::to('dashboard')->with('message', trans('invoice.access_denied') );	
		}

		return Redirect::to('estimate')->with('message', trans('invoice.data_was_updated'));
	}
	/* === END OTHERS === */
}