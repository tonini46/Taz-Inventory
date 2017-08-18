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
        $this->db->select('tbl_country.name', false);
        $this->db->from('tbl_country');
        $query_result = $this->db->get();
        $result = $query_result->result();
        $data_create = ",";
        $data_update = "";
        foreach ($result as $country) {
            $data_create .= " product_quantity_".$country->name." int(11) NOT NULL,";
            $data_update .= ", product_quantity_".$country->name;
        }
        $this->db->query("CREATE TABLE sqlitebrowser_temp_table (inventory_id  INTEGER NOT NULL PRIMARY KEY AUTOINCREMENT, product_id int(5) NOT NULL, notify_quantity int(5) DEFAULT NULL $data_create product_quantity_".$name." int(11) NOT NULL DEFAULT 0 );");
        $this->db->query("INSERT INTO sqlitebrowser_temp_table (product_id, notify_quantity $data_update) SELECT product_id,notify_quantity $data_update FROM tbl_inventory;");
        $this->db->query("DROP TABLE tbl_inventory;");
        $this->db->query("ALTER TABLE sqlitebrowser_temp_table RENAME TO tbl_inventory;");
    }
    public function get_drop_column_inventory($name)
    {
        
        $this->db->select('tbl_country.name', false);
        $this->db->from('tbl_country');
        $query_result = $this->db->get();
        $result = $query_result->result();
        $data_create = "";
        $data_update = "";
        foreach ($result as $country) {
            if($country->name != $name){
            $data_create .= ", product_quantity_".$country->name." int(11) NOT NULL";
            $data_update .= ", product_quantity_".$country->name;
            }
        }
        $this->db->query("CREATE TABLE sqlitebrowser_temp_table (inventory_id  INTEGER NOT NULL PRIMARY KEY AUTOINCREMENT, product_id int(5) NOT NULL, notify_quantity int(5) DEFAULT NULL $data_create);");
        $this->db->query("INSERT INTO sqlitebrowser_temp_table (product_id, notify_quantity $data_update) SELECT product_id,notify_quantity $data_update FROM tbl_inventory;");
        $this->db->query("DROP TABLE tbl_inventory;");
        $this->db->query("ALTER TABLE sqlitebrowser_temp_table RENAME TO tbl_inventory;"); 
    }
    
    public function get_update_column_inventory($name_from, $name_to)
    {
        //ALTER TABLE table_name RENAME TO new_table_name;
        $this->db->select('tbl_country.name', false);
        $this->db->from('tbl_country');
        $query_result = $this->db->get();
        $result = $query_result->result();
        $data_create = ",";
        $data_update = ",";
        foreach ($result as $country) {
            if($country->name != $name_from){
            $data_create .= " product_quantity_".$country->name." int(11) NOT NULL,";
            $data_update .= "  product_quantity_".$country->name.",";
            }
        }
        $this->db->query("CREATE TABLE sqlitebrowser_temp_table (inventory_id  INTEGER NOT NULL PRIMARY KEY AUTOINCREMENT, product_id int(5) NOT NULL, notify_quantity int(5) DEFAULT NULL $data_create product_quantity_".$name_to." int(11) NOT NULL );");
        $this->db->query("INSERT INTO sqlitebrowser_temp_table (product_id, notify_quantity $data_update product_quantity_".$name_to." ) SELECT product_id,notify_quantity $data_update product_quantity_".$name_from." FROM tbl_inventory;");
        $this->db->query("DROP TABLE tbl_inventory;");
        $this->db->query("ALTER TABLE sqlitebrowser_temp_table RENAME TO tbl_inventory;");

    }
}
