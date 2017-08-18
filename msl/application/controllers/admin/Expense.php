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

class Expense extends Admin_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('expense_model');
        $this->load->model('global_model');

        $this->load->helper('ckeditor');
        $this->data['ckeditor'] = array(
            'id' => 'ck_editor',
            'path' => 'asset/js/ckeditor',
            'config' => array(
                'toolbar' => 'Full',
                'width' => '100%',
                'height' => '150px',
            ),
        );

    }



    /*** Add expense ***/
    public function add_expense($id = null)
    {
        $this->tbl_expense('expense_id');

        if ($id) {
            $data['expense'] = $this->global_model->get_by(array('expense_id'=>$id), true);
            if(empty($data['expense'])){
                $type = 'error';
                $message = 'There is no Record Found!';
                set_message($type, $message);
                redirect('admin/expense/manage_expense');
            }
        }


        $data['code'] = $data['code'] = rand(10000000, 99999);
        $data['country'] = $this->global_model->get_countries();
        $data['title'] = 'Add Expense';  // title page
        $data['editor'] = $this->data;
        $data['subview'] = $this->load->view('admin/expense/add_expense', $data, true);
        $this->load->view('admin/_layout_main', $data);
    }

    /*** Save expense ***/
    public function save_expense($id = null)
    {
        $data = $this->expense_model->array_from_post(array(
            'expense_name',
            'expense_note',
            'country_id',
            'expense_date'
             ));
        
        $data['expense_amount'] = currency_to_db($this->input->post('expense_amount'));
        $data['expense_attachment'] = "";
        if(empty($id)) {
        $data['expense_code'] = "";
        }

        $this->tbl_expense('expense_id');
        $expense_id = $this->global_model->save($data, $id);

        if(empty($id)) {
            $expense_code['expense_code'] = $this->input->post('expense_code').$expense_id;
            $this->global_model->save($expense_code, $expense_id);

        $this->global_model->log('added an expense:'.$data['expense_name']);
        }
        else{
        $this->global_model->log('Updated an expense:'.$data['expense_name']);
        }
        $type = 'success';
        $message = 'Expense Information Saved Successfully!';
        set_message($type, $message);
        redirect('admin/expense/manage_expense');
    }

    /*** Manage expense ***/
    public function manage_expense()
    {

        $this->tbl_expense('expense_id');
        if($this->session->userdata('user_type') == 1){
        $data['expense'] = $this->global_model->get();
        }
        else if($this->session->userdata('user_type') == 0){
        $data['expense'] = $this->expense_model->get_expense($this->session->userdata('user_country'));
        }
        $data['title'] = 'Manage Expense';
        $data['subview'] = $this->load->view('admin/expense/manage_expense', $data, true);
        $this->load->view('admin/_layout_main', $data);
    }

    /*** Delete expense ***/
    public function delete_expense($id=null)
    {
        $this->expense_model->_table_name = 'tbl_expense';
        $this->expense_model->_primary_key = 'expense_id';
        $this->expense_model->delete($id);  // delete by id
        $this->global_model->log('deleted an expense');
        // massage for employee
        $type = 'error';
        $message = 'Expense Successfully Deleted from System';
        set_message($type, $message);
        redirect('admin/expense/manage_expense');
    }

    /*** Check Duplicate expense  **
    public function check_expense_phone($phone=null, $expense_id = null)
    {
        $this->tbl_expense('expense_id');
        if(empty($expense_id))
        {
            $result = $this->global_model->get_by(array('phone'=>$phone), true);
        }else{
            //$result = $this->expense_model->check_expense_phone($phone, $expense_id);
            $result = $this->global_model->get_by(array('phone'=>$phone, 'expense_id !=' => $expense_id ), true);
        }

        if($result)
        {
            echo 'This phone number already exist!';
        }

    }*/
}
