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

class Login_Model extends MY_Model
{
    protected $_table_name;
    protected $_order_by;
    public $rules = array(

        'user_name' => array(
            'field' => 'user_name',
            'label' => 'User Name',
            'rules' => 'trim|required',
        ),
        'password' => array(
            'field' => 'password',
            'label' => 'Password',
            'rules' => 'trim|required',
        ),
    );

    public function login()
    {
        $this->_table_name = 'tbl_user';
        $this->_order_by = 'user_id';

        $user = $this->get_by(array(
                'user_name' => $this->input->post('user_name'),
                'password' => $this->hash($this->input->post('password')),
                    ), true);

        if (count($user)) {
            $data = array(
                    'user_name' => $user->user_name,
                    'name' => $user->name,
                    'employee_id' => $user->user_id,
                    'employee_login_id' => $user->user_id,
                    'loggedin' => true,
                    'user_type' => $user->flag,
                    'user_pic' => $user->filename,
                    'url' => 'admin/dashboard',
                    'user_country' => $user->country_id,
                );
            if($user->flag == 0){
                 $data['country_tax'] = $this->select_country_tax($user->country_id);
                 $data['currency_code'] = $this->global_model->get_country_currency_code($user->country_id);
            }
            else if($user->flag == 1){
                 $this->_table_name = 'tbl_business_profile';
                 $this->_order_by = 'business_profile_id';
                 $data['currency_code'] = $this->get_by(array("business_profile_id"=> 1), true)->currency;
            }

        $this->session->set_userdata($data);
        $this->global_model->log('logged in');

        }
    }

    public function logout()
    {
        $this->global_model->log('logged Out');
        $this->session->sess_destroy();
    }

    public function loggedin()
    {
        return (bool) $this->session->userdata('loggedin');
    }

    public function hash($string)
    {
        return hash('sha512', $string.config_item('encryption_key'));
    }
    public function select_menu_by_uri($uriSegment)
    {
        $this->db->select('tbl_menu.*', false);
        $this->db->from('tbl_menu');
        $this->db->where('link', $uriSegment);
        $query_result = $this->db->get();
        $result = $query_result->row();
        if (count($result)) {
            $menuId[] = $result->menu_id;
            $menuId = $this->select_menu_by_id($result->parent, $menuId);
        } else {
            return false;
        }
        if (!empty($menuId)) {
            $lastId = end($menuId);
            $parrent = $this->select_menu_first_parent($lastId);
            array_push($menuId, $parrent->parent);

            return $menuId;
        }
    }

    public function select_menu_by_id($id, $menuId)
    {
        $this->db->select('tbl_menu.*', false);
        $this->db->from('tbl_menu');
        $this->db->where('menu_id', $id);
        $query_result = $this->db->get();
        $result = $query_result->row();
        if (count($result)) {
            array_push($menuId, $result->menu_id);
            if ($result->parent != 0) {
                $result = self::select_menu_by_id($result->parent, $menuId);
            }
        }

        return $menuId;
    }

    public function select_menu_first_parent($lastId)
    {
        $this->db->select('tbl_menu.*', false);
        $this->db->from('tbl_menu');
        $this->db->where('menu_id', $lastId);
        $query_result = $this->db->get();
        $result = $query_result->row();

        return $result;
    }

    public function select_country_tax($country_id)
    {
        $this->db->select('tbl_tax.*', false);
        $this->db->from('tbl_tax');
        $this->db->where('country_id', $country_id);
        $query_result = $this->db->get();
        $result = $query_result->row();
        return $result->tax_id;
    }
}
