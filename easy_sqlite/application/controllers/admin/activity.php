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

class Activity extends Admin_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('activity_model');
        $this->load->model('global_model');
    }

    /*** All Activity log ***/
    public function activity_logs()
    {       
        $data['title'] = 'Activity Logs';

         $data['activity_info'] =  $this->activity_model->get_log();

        $data['subview'] = $this->load->view('admin/activity/activity_logs', $data, true);
        $this->load->view('admin/_layout_main', $data);
    }

}
