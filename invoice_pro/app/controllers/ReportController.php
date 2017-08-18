<?php

class ReportController extends \BaseController {

	protected $layout = 'index';
	
	
	/* === VIEW === */
	public function index()
	{
		$reports = new Report;	
		
		$data = array(
			'invoices'	=> $reports->invoices(),
			'amounts'	=> $reports->amounts(),
			'clients'	=> $reports->clients()
		);
		
		$this->layout->content = View::make('reports.index', $data);
	}
	/* === END VIEW === */

}