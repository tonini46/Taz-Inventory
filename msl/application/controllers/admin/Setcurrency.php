<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

/*
 *	@author : Swivernet
 *  @support: support@tazamali.com
 *	date	: 05 June, 2015
 *	Tazamali Group Company Ltd
 *	http://www.tazamali.com
 *  version: 1.0
 */

class Setcurrency extends Admin_Controller
{
	public function __construct()
    {
        parent::__construct();
    }
    //======================================================================
    // CURRENCY MODULE
    //======================================================================

  public function index() {
        // reset the currency
        $currency = $this->input->post('currency');
        $this->session->set_userdata('currency_code', strtoupper($currency));

        // get the last visited uri string and clear the session, in order to keep track of the new selection
        // $previous_url = $this->session->userdata('uri_string');
        // $this->session->unset_userdata('uri_string');

        // redirect to last visited page
        // redirect($previous_url);
    } 
}