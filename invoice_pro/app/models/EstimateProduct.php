<?php

class EstimateProduct extends Eloquent {

	public $timestamps = false;
	
	
	public function getEstimateProducs($estimateID, $owner)
	{
		if ($owner)
		{
			$query = DB::table('estimate_products')
					->leftJoin('products', 'products.id', '=', 'estimate_products.product_id')
					->select(	'estimate_products.*', 
								'products.name', 'products.description'
							)
					->where('estimate_products.estimate_id', $estimateID)
					->where('estimate_products.user_id', Auth::id())
					->get();
		}
		else
		{
			$query = DB::table('estimate_products')
					->leftJoin('products', 'products.id', '=', 'estimate_products.product_id')
					->leftJoin('estimates', 'estimates.id', '=', 'estimate_products.estimate_id')
					->leftJoin('clients', 'clients.id', '=', 'estimates.client_id')
					->select(	'estimate_products.*', 
								'products.name', 'products.description'
							)
					->where('estimate_products.estimate_id', $estimateID)
					->where('clients.email', Auth::user()->email)
					->get();
		}		
		
		return $query;		
	}

}