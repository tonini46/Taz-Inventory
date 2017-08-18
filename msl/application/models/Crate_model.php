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

class Crate_Model extends MY_Model
{
    public $_table_name;
    public $_order_by;
    public $_primary_key;

    public function get_new_c_rate_info()
    {
        $post = new stdClass();
        $post->rate_name = '';
        $post->rate = '';

        return $post;
    }
    public function get_new_c_rate_rule_info()
    {
        $post = new stdClass();
        $post->tax_group_id = '';
        $post->tax_rate_id = '';
        $post->rule_name = '';

        return $post;
    }

    public function get_c_rate_rule_info($id = null)
    {
        // this function is to get all tax info if id exist then row wise else result

        $this->db->select('tbl_country.name,tbl_country.currency', false);
        $this->db->select('tbl_currency_converter_new.*', false);
        $this->db->from('tbl_currency_converter_new');
        $this->db->join('tbl_country', 'tbl_country.country_id  =  tbl_currency_converter_new.country_id ', 'left');
        if (!empty($id)) { //specific c_rate rule information needed
            $this->db->where('tbl_country.currency', $id);
            $query_result = $this->db->get();
            $result = $query_result->row();
        }

        return $result;
    }


}
