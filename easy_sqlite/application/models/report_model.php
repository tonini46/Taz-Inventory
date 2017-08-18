<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

/*
 *	@author : CodesLab
 *  @support: support@codeslab.net
 *	date	: 05 June, 2015
 *	Easy Inventory
 *	http://www.codeslab.net
 *  version: 1.0
 */

class Report_Model extends MY_Model
{
    //put your code here
    public $_table_name;
    public $_order_by;
    public $_primary_key;

    public function get_invoice_by_date($start_date, $end_date, $country)
    {
        $this->db->select('tbl_invoice.*', false);
        $this->db->select('tbl_order.*', false);
        $this->db->from('tbl_invoice');
        $this->db->join('tbl_order', 'tbl_order.order_id  =  tbl_invoice.order_id', 'left');
        if ($start_date == $end_date) {
            $this->db->like('tbl_invoice.invoice_date', $start_date);
        } else {
            $this->db->where('tbl_invoice.invoice_date >=', $start_date);
            $this->db->where('tbl_invoice.invoice_date <=', $end_date.'23:59:59');
        }
        
        $this->db->where('tbl_order.country_id', $country);
        
        $query_result = $this->db->get();
        $result = $query_result->result();

        return $result;
    }

    public function get_purchase_by_date($start_date, $end_date, $country)
    {
        $this->db->select('tbl_purchase.*', false);
        $this->db->from('tbl_purchase');
        if ($start_date == $end_date) {
            $this->db->like('datetime', $start_date);
        } else {
            $this->db->where('datetime >=', $start_date);
            $this->db->where('datetime <=', $end_date.'23:59:59');
        }

        $this->db->where('tbl_purchase.country_id', $country);

        $query_result = $this->db->get();
        $result = $query_result->result();

        return $result;
    }

    public function get_expense_by_date($start_date, $end_date, $country, $total)
    {
        if($total == 0)
        $this->db->select('tbl_expense.*', false);
        else
        $this->db->select_sum('tbl_expense.expense_amount','total');

        $this->db->from('tbl_expense');
        if ($start_date == $end_date) {
            $this->db->like('expense_date', $start_date);
        } else {
            $this->db->where('expense_date >=', $start_date);
            $this->db->where('expense_date <=', $end_date.'23:59:59');
        }

        $this->db->where('tbl_expense.country_id', $country);

        $query_result = $this->db->get();
        $result = $query_result->result();

        return $result;
    }

    public function get_product_sales_by_date($start_date, $end_date, $country, $total,$product)
    {
        if($total == 0)
        $this->db->select_sum('tbl_order_details.sub_total','sub_total');
        else if($total == 1)
        $this->db->select_sum('tbl_order_details.product_tax','total_tax');
        else{
        $this->db->select('tbl_order_details.*', false);
        $this->db->select('tbl_order.order_id,tbl_order.order_date,tbl_order.order_no,tbl_order.country_id', false);
        }
        $this->db->from('tbl_order_details');
        $this->db->join('tbl_order', 'tbl_order.order_id  =  tbl_order_details.order_id', 'left');

        if ($start_date == $end_date) {
            $this->db->like('tbl_order.order_date', $start_date);
        } else {
            $this->db->where('tbl_order.order_date >=', $start_date);
            $this->db->where('tbl_order.order_date <=', $end_date.'23:59:59');
        }
        
        $this->db->where('tbl_order_details.product_code', $product);
        $this->db->where('tbl_order.country_id', $country);
        
        $query_result = $this->db->get();
        $result = $query_result->result();

        return $result;

        /*if($total == 0)
        $this->db->select('tbl_expense.*', false);
        else
        $this->db->select_sum('tbl_expense.expense_amount','total');

        $this->db->from('tbl_expense');
        if ($start_date == $end_date) {
            $this->db->like('expense_date', $start_date);
        } else {
            $this->db->where('expense_date >=', $start_date);
            $this->db->where('expense_date <=', $end_date.'23:59:59');
        }

        $this->db->where('tbl_expense.country_id', $country);

        $query_result = $this->db->get();
        $result = $query_result->result();

        return $result;*/
    }

}
