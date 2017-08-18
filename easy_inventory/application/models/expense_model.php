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

class Expense_Model extends MY_Model
{
    public $_table_name;
    public $_order_by;
    public $_primary_key;

    public function get_expense_info($id = null) // this function is to get all expense info from tbl expense and tbl_expense_group
    {
        $this->db->select('tbl_expense.*', false);
        $this->db->from('tbl_expense');
        if (!empty($id)) {
            //specific expense information needed
            $this->db->where('tbl_expense.expense_id', $id);
            $query_result = $this->db->get();
            $result = $query_result->row();
        } else {
            //all expense information needed
            $query_result = $this->db->get();
            $result = $query_result->result();
        }

        return $result;
    }

    public function get_expense($id)
    {
        $this->db->select('tbl_expense.*', false);
        $this->db->from('tbl_expense');
        $this->db->where('country_id', $id);
            $query_result = $this->db->get();
            $result = $query_result->result();
        
        return $result;
    }

//    public function check_expense_phone($phone, $expense_id)
//    {
//        $this->db->select('tbl_expense.*', false);
//        $this->db->from('tbl_expense');
//        $this->db->where('expense_id !=', $expense_id);
//        $this->db->where('phone', $phone);
//        $query_result = $this->db->get();
//        $result = $query_result->row();
//        return $result;
//    }

    public function get_new_expense_detail()
    {
        // this function is to get all expense info blank
        $post = new stdClass();
        $post->expense_id = '';
        $post->expense_code = '';
        $post->expense_name = '';
        $post->expense_note = '';
        $post->expense_amount = '';
        $post->expense_attachment = '';
        $post->country_id = '';
        $post->expense_date = '';

        return $post;
    }
}
