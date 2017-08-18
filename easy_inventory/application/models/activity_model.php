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

class Activity_Model extends MY_Model
{
    public $_table_name;
    public $_order_by;
    public $_primary_key;

    public function get_log()
    {
        $this->db->select('tbl_activity.*', false);
        $this->db->from('tbl_activity');
        $query_result = $this->db->get();
        $result = $query_result->result();

        return $result;
    }
}
