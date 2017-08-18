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

class Settings extends Admin_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('settings_model');
        $this->load->model('global_model');
        $this->load->model('crate_model');

    }

    /*** Business Settings ***/
    public function business_profile($val = null)
    {
        //echo json_encode($this->crate_model->get_c_rate_rule_info('KES')); exit;
        $this->settings_model->_table_name = 'tbl_business_profile';
        $this->settings_model->_order_by = 'business_profile_id';

        $result = $this->settings_model->get_by(array('business_profile_id' => 1), true);
        if ($result) {
            $data['business_info'] = $result;
        }

        // view page
        $data['title'] = 'Business Profile';
        $data['subview'] = $this->load->view('admin/settings/business_profile', $data, true);
        $this->load->view('admin/_layout_main', $data);
    }

    /*** Save Business Information ***/
    public function save_business_profile($id = null)
    {
        $this->settings_model->_table_name = 'tbl_business_profile';
        $this->settings_model->_primary_key = 'business_profile_id';
        $data = $this->settings_model->array_from_post(array('company_name', 'email', 'address', 'phone', 'currency','forex'));

        //logo Upload
        if ($_FILES['logo']['name']) { // logo name is exist
            $old_path = $this->input->post('old_path');
            if ($old_path) {
                unlink($old_path);
            }
            $val = $this->settings_model->uploadImage('logo'); // upload the image
            $val == true || redirect('admin/dashboard/general_settings');
            $data['logo'] = $val['path'];
            $data['full_path'] = $val['fullPath'];
        }
        $this->settings_model->save($data, $id); // save
        // redirect with msg
        $type = 'success';
        $message = 'Business Information Successfully Save!';
        set_message($type, $message);
        redirect('admin/settings/business_profile');
    }

    /*** New Tax Rule ***/
    public function tax($id = null)
    {
        $this->tbl_tax('tax_id');
        $data['tax_info'] = $this->global_model->get();

        if (!empty($id)) { //condition check
            $where = array('tax_id' => $id);
            $data['tax'] = $this->settings_model->check_by($where, 'tbl_tax');

            if (empty($data['tax'])) {
                // massage
                $type = 'error';
                $message = 'No Record Found';
                set_message($type, $message);
                redirect('admin/settings/tax');
            }
        }

        $data['country'] = $this->global_model->get_countries();
//echo json_encode($data); exit;
        //view page
        $data['title'] = 'Manage Tax Rules';
        $data['subview'] = $this->load->view('admin/settings/tax', $data, true);
        $this->load->view('admin/_layout_main', $data);
    }

    /*** Save tax rule ***/
    public function save_tax($id = null)
    {
        $this->tbl_tax('tax_id');
        $data = $this->settings_model->array_from_post(array('tax_title', 'tax_rate', 'tax_type','country_id'));

        // update root category
        $where = array('tax_title' => $data['tax_title']);
        // duplicate value check
        if (!empty($id)) {
            $tax_id = array('tax_id !=' => $id);
        } else {
            $tax_id = null;
        }

        // duplicate value check
        $check_category = $this->settings_model->check_update('tbl_tax', $where, $tax_id);
        if (!empty($check_category)) {
            $type = 'error';
            $message = 'Tax Rule Already Exist!';
        } else { // save and update
            $this->global_model->save($data, $id);
            // massage
            $type = 'success';
            $message = 'Tax Rule Saved Successfully!';
        }
        set_message($type, $message);
        redirect('admin/settings/tax');
    }

    /*** Delete Tax Rule ***/
    public function delete_tax($id=null){
        $this->tbl_tax('tax_id');
        $this->global_model->delete($id);
        $this->message->delete_success('admin/settings/tax');
    }

    /*** New Currency Rate ***/
    public function c_rate($id = null)
    {
        $this->tbl_currency_converter_new('id');
        $data['c_rate_info'] = $this->global_model->get();

        if (!empty($id)) { //condition check
            $where = array('id' => $id);
            $data['c_rate'] = $this->settings_model->check_by($where, 'tbl_currency_converter_new');

            if (empty($data['c_rate'])) {
                // massage
                $type = 'error';
                $message = 'No Record Found';
                set_message($type, $message);
                redirect('admin/settings/c_rate');
            }
        }

        $data['country'] = $this->global_model->get_countries();

        //view page
        $data['title'] = 'Manage Currency Rate Rules';
        //echo json_encode($data); exit;
        $data['subview'] = $this->load->view('admin/settings/c_rate', $data, true);
        $this->load->view('admin/_layout_main', $data);
    }

    /*** Save Currency Rate ***/
    public function save_c_rate($id = null)
    {
        $this->tbl_currency_converter_new('id');
        $data = $this->settings_model->array_from_post(array('country_id','rate_form_usd'));

        // update root category
        $where = array('country_id' => $data['country_id']);
        // duplicate value check
        if (!empty($id)) {
            $id = array('id !=' => $id);
        } else {
            $id = null;
        }

        // duplicate value check
        $check_category = $this->settings_model->check_update('tbl_currency_converter_new', $where, $id);
        if (!empty($check_category)) {
            $type = 'error';
            $message = 'Currency Rate Rule Already Exist!';
        } else { // save and update
            $this->global_model->save($data, $id);
            // massage
            $type = 'success';
            $message = 'Currency Rate Rule Saved Successfully!';
        }
        set_message($type, $message);
        redirect('admin/settings/c_rate');
    }

    /*** Delete Currency Rate ***/
    public function delete_c_rate($id=null){
        $this->tbl_currency_converter_new('id');
        $this->global_model->delete($id);
        $this->message->delete_success('admin/settings/c_rate');
    }

    
}