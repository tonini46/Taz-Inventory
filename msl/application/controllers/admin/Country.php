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

class Country extends Admin_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('country_model');
        $this->load->model('global_model');
        $this->load->model('settings_model');

    }


    /*** Add country ***/
    public function add_country($id = null)
    {
        $this->tbl_country('country_id');

        if ($id) {
            $data['country'] = $this->global_model->get_by(array('country_id'=>$id), true);
            if(empty($data['country'])){
                $type = 'error';
                $message = 'There is no Record Found!';
                set_message($type, $message);
                redirect('admin/country/manage_country');
            }

        }


        $data['title'] = 'Add Country';  // title page
        $data['subview'] = $this->load->view('admin/country/add_country', $data, true);
        $this->load->view('admin/_layout_main', $data);
    }

    /*** Save Country ***/
    public function save_country($id = null)
    {
        /*$data = $this->country_model->array_from_post(array(
            'name',
            'currency'
             ));*/
        $data['name'] = str_replace(" ", "-", Ucfirst(strtolower($this->input->post('name', true))));
        $data['currency'] = strtoupper($this->input->post('currency', true));
        $data['logo'] = '';
        $data['full_path'] = '';

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

        $this->tbl_country('country_id');

        if(empty($id)) {
             $this->country_model->get_add_column_inventory($data['name']);
             $this->global_model->save($data, $id);
             //CREATE COLUMN -> INVENTORY
        $this->global_model->log('added a country:'.$data['name']);
        }
        else{
             $dataz = $this->global_model->get_by(array('country_id'=>$id), true);
             //UPDATE COLUMN -> INVENTORY
             $this->country_model->get_update_column_inventory($dataz->name,$data['name']);
             $this->global_model->save($data, $dataz->country_id);
             $this->global_model->log('updated a country:'.$dataz->name.' to '.$data['name']);
        }
        $type = 'success';
        $message = 'Country Information Saved Successfully!';
        set_message($type, $message);
        redirect('admin/country/manage_country');
    }

    /*** Manage Country ***/
    public function manage_country()
    {

        $this->tbl_country('country_id');
        $data['country'] = $this->global_model->get();
        $data['title'] = 'Manage Country';
        $data['subview'] = $this->load->view('admin/country/manage_country', $data, true);
        $this->load->view('admin/_layout_main', $data);
    }

    /*** Delete Country ***/
    public function delete_country($id=null)
    {
        $this->tbl_country('country_id');
        $data = $this->global_model->get_by(array('country_id'=>$id), true); 

        //var_dump($data->name);exit;

        //DROP COLUMN -> INVENTORY
        $this->country_model->get_drop_column_inventory($data->name);
        $this->country_model->_table_name = 'tbl_country';
        $this->country_model->_primary_key = 'country_id';
        $this->country_model->delete($id);  // delete by id

        $this->global_model->log('deleted a country:'.$data->name);
        // message for employee
        $type = 'error';
        $message = 'Country Successfully Deleted from System';
        set_message($type, $message);
        redirect('admin/country/manage_country');
    }

    /*** Check Duplicate country  ***/
    public function check_country_name($name=null, $country_id = null)
    {
        $this->tbl_country('country_id');
        if(empty($country_id))
        {
            $result = $this->global_model->get_by(array('name'=>$name), true);
        }else{
            //$result = $this->country_model->check_country_phone($name, $country_id);
            $result = $this->global_model->get_by(array('name'=>$name, 'country_id !=' => $country_id ), true);
        }

        if($result)
        {
            echo 'This Country already exist!';
        }

    }
}
