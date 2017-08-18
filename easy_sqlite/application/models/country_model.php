<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

/*
 *  @author : CodesLab
 *  @support: support@codeslab.net
 *  date    : 05 June, 2015
 *  Easy Inventory
 *  http://www.codeslab.net
 *  version: 1.0
 */

class Country_Model extends MY_Model
{
    public $_table_name;
    public $_order_by;
    public $_primary_key;

    public function get_country_info($id = null) // this function is to get all country info from tbl country and tbl_country_group
    {
        $this->db->select('tbl_country.*', false);
        $this->db->from('tbl_country');
        if (!empty($id)) {
            //specific customer information needed
            $this->db->where('tbl_country.country_id', $id);
            $query_result = $this->db->get();
            $result = $query_result->row();
        } else {
            //all country information needed
            $query_result = $this->db->get();
            $result = $query_result->result();
        }

        return $result;
    }

    public function get_country($id)
    {
        $this->db->select('tbl_country.*', false);
        $this->db->from('tbl_country');
        $this->db->where('country_id', $id);
            $query_result = $this->db->get();
            $result = $query_result->result();
        
        return $result;
    }

    public function get_new_country_detail()
    {
        // this function is to get all country info blank
        $post = new stdClass();
        $post->country_id = '';
        $post->name = '';
        $post->currency = '';
        return $post;
    }

    public function get_add_column_inventory($name)
    {
        $this->db->query("ALTER TABLE tbl_inventory ADD product_quantity_".$name." INT NOT NULL");
    }
    public function get_drop_column_inventory($name)
    {
        $this->db->query("ALTER TABLE tbl_inventory DROP product_quantity_".$name); 
    }
    
    public function get_update_column_inventory($name_from, $name_to)
    {
        $this->db->query("ALTER TABLE tbl_inventory CHANGE product_quantity_".$name_from." product_quantity_".$name_to." INT(11) NOT NULL;");
    }
}
