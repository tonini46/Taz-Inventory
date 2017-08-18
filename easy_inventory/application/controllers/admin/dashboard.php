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

class Dashboard extends Admin_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('dashboard_model');
        $this->load->model('global_model');
        $this->load->model('order_model');
        $this->load->model('customer_model');

    }

    /*** Dashboard ***/

    public function index()
    {
        
        // recent order
        $data['order_info'] = $this->dashboard_model->recently_added_order();

        // recent activity
        $data['activity_info'] = $this->dashboard_model->recent_activity();
//echo json_encode($data['activity_info']); exit;
        //recently added product
        $data['product_info'] = $this->dashboard_model->recently_added_product();

        if($this->session->userdata('user_type') == 1){
        //total order
        $this->tbl_order('order_id');
        $data['total_order'] = count($this->global_model->get());

        //total invoice
        $this->tbl_invoice('invoice_id');
        $data['total_invoice'] = count($this->global_model->get());

        //total customer
        $this->tbl_customer('customer_id');
        $data['total_customer'] = count($this->global_model->get());
        }
        
        else{
        //total order
        $this->tbl_order('order_id');
        $data['total_order'] = count($this->order_model->get_all_order());

        //total invoice
        $this->tbl_invoice('invoice_id');
        $data['total_invoice'] = count($this->order_model->get_all_invoice());

        //total customer
        $this->tbl_customer('customer_id');
        $data['total_customer'] = count($this->customer_model->get_customer($this->session->userdata('user_country')));
        }

        //total product
        $this->tbl_product('product_id');
        $data['total_product'] = count($this->global_model->get());

        //total buying, selling, tax
        $data['total_expense'] = $this->dashboard_model->get_expense();

        //total buying, selling, tax
        $data['total'] = $this->dashboard_model->get_revenue();

        //discount
        $data['discount'] = $this->dashboard_model->get_discount();


        $data['year'] = date('Y');

        $data['yearly_sales_report'] = $this->get_yearly_sales_report($data['year']);  // get yearly report
        $data['title'] = 'Measurement Systems Limited'; // title
        //echo json_encode($data['yearly_sales_report']); exit;
        $data['subview'] = $this->load->view('admin/dashboard', $data, true); // sub view
        $this->load->view('admin/_layout_main', $data); // main page
    }

    /*** Get Yearly Report ***/
    public function get_yearly_sales_report($year)
    {

        for ($i = 1; $i <= 12; $i++) {
            if ($i >= 1 && $i <= 9) {
                $start_date = $year.'-'.'0'.$i.'-'.'01';
                $end_date = $year.'-'.'0'.$i.'/'.'31';
            } else {
                $start_date = $year.'-'.$i.'-'.'01';
                $end_date = $year.'-'.$i.'-'.'31';
            }

            $get_all_report[$i] = $this->dashboard_model->get_all_report_by_date($start_date, $end_date);
        }

        return $get_all_report;
    }

    /*** Login ***/
    public function login()
    {
        $data['title'] = 'Login';
        $this->load->view('admin/login');
    }


}
