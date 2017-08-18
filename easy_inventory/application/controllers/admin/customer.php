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

class Customer extends Admin_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('customer_model');
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



    /*** Add Customer ***/
    public function add_customer($id = null)
    {
        $this->tbl_customer('customer_id');

        if ($id) {
            $data['customer'] = $this->global_model->get_by(array('customer_id'=>$id), true);
            if(empty($data['customer'])){
                $type = 'error';
                $message = 'There is no Record Found!';
                set_message($type, $message);
                redirect('admin/customer/manage_customer');
            }
        }


        $data['code'] = $data['code'] = rand(10000000, 99999);
        $data['country'] = $this->global_model->get_countries();
        $data['title'] = 'Add Customer';  // title page
        $data['editor'] = $this->data;
        $data['subview'] = $this->load->view('admin/customer/add_customer', $data, true);
        $this->load->view('admin/_layout_main', $data);
    }

    /*** Save Customer ***/
    public function save_customer($id = null)
    {
        $data = $this->customer_model->array_from_post(array(
            'customer_name',
            'email',
            'phone',
            'address',
            'discount',
            'country_id'
             ));
        /*$data['customer_code'] = "";
        $data['barcode_path'] = ""; 
        $data['barcode'] = ""; */

        $this->tbl_customer('customer_id');
        $customer_id = $this->global_model->save($data, $id);

        if(empty($id)) {
            $customer_code['customer_code'] = $this->input->post('customer_code').$customer_id;
            $this->global_model->save($customer_code, $customer_id);
        }

            //$this->generate_barcode($customer_code, $customer_id);
        $this->global_model->log('added a customer:'.$data['customer_name']);
        $type = 'success';
        $message = 'Customer Information Saved Successfully!';
        set_message($type, $message);
        redirect('admin/customer/manage_customer');
    }

    /*** Manage Customer ***/
    public function manage_customer()
    {

        $this->tbl_customer('customer_id');
        if($this->session->userdata('user_type') == 1){
        $data['customer'] = $this->global_model->get();

        foreach ($data['customer'] as $value) {
        $this->client_generate_barcode($value->customer_code, $value->customer_id);
        }

        }
        else if($this->session->userdata('user_type') == 0){
        $data['customer'] = $this->customer_model->get_customer($this->session->userdata('user_country'));
        foreach ($data['customer'] as $value) {
        $this->client_generate_barcode($value->customer_code, $value->customer_id);
        }
        }
        
        $data['title'] = 'Manage Customer';
        $data['subview'] = $this->load->view('admin/customer/manage_customer', $data, true);
        $this->load->view('admin/_layout_main', $data);
    }

    /*** Delete Customer ***/
    public function delete_customer($id=null)
    {
        $this->customer_model->_table_name = 'tbl_customer';
        $this->customer_model->_primary_key = 'customer_id';
        $this->customer_model->delete($id);  // delete by id

        // massage for employee
        $this->global_model->log('deleted a customer');
        $type = 'error';
        $message = 'Customer Successfully Deleted from System';
        set_message($type, $message);
        redirect('admin/customer/manage_customer');
    }

        /*** pdf Customer ***/
    public function pdf_customer($id=null)
    {
        $this->tbl_customer('customer_id');
        $data['customer'] = $this->global_model->get_by(array('customer_id'=>$id), true);

        //echo json_encode($data['customer']); exit;
        //generate_barcode($data['customer']->customer_code,$id);

        $html = $this->load->view('admin/customer/id_badges', $data, true);
        $filename = ucwords(strtolower($data['customer']->customer_name)).' - MSL#'. $data['customer']->customer_code; 
        $this->load->helper(array('dompdf', 'file'));
        pdf_create($html, $filename);
        $pdf->WriteHTML($html);
        $pdf->Output($filename, 'D');

        // message for employee
        $type = 'success';
        $message = 'Customer Badge Successfully Downloaded';
        set_message($type, $message);
        redirect('admin/customer/manage_customer');
    }

        /*** email Customer ***/
    public function email_customer($id=null)
    {
        $this->tbl_customer('customer_id');
        $data['customer'] = $this->global_model->get_by(array('customer_id'=>$id), true);
       // $this->load->view('admin/customer/id_badges', $data, true);exit;
        
         $company_info = $this->session->userdata('business_info');

        if(!empty($company_info->email) && !empty($company_info->email)) {

            $company_email = $company_info->email;
            $company_name = $company_info->company_name;
            $from = array($company_email, $company_name);
            //sender email
            $to = $data['customer']->email;
            //subject
            $filename = ucwords(strtolower('Customer Id - '.$data['customer']->customer_name)).' - MSL#'. $data['customer']->customer_code; 
            $subject = $filename;

            $data['doc_name'] = $filename;
            $data['date'] = date('Y-m-d h:i:sa');

            // set view page

            $body_data = $this->load->view('admin/customer/email_template', $data, true);
            $view_page = $this->load->view('admin/customer/id_badges', $data, true);
            $send_email = $this->mail->sendPdf($body_data, $to, $subject, $view_page);


            if (!isset($send_email)) {
                $this->message->custom_success_msg('admin/customer/manage_customer/' . $id,
                    'Your email has been sent successfully!');
            } else {
                $this->message->custom_error_msg('admin/customer/manage_customer/' . $id,
                    'Sorry we are unable to send your email!');
            }
        }else{
                 $this->message->custom_error_msg('admin/customer/manage_customer/' . $id,
                'Sorry unable to send your email, without company email');
        }


        // message for employee
        $type = 'success';
        $message = 'Customer Badge Successfully Emailed';
        set_message($type, $message);
        redirect('admin/customer/manage_customer');
    }

    /*** Barcode Generate ***/
    private function client_generate_barcode($code, $id)
    {

        //load library
        $this->load->library('zend');
        //load in folder Zend
        $this->zend->load('Zend/Barcode');

        //generate barcode
        $file = Zend_Barcode::draw('code128', 'image', array('text' => $code), array());

        imagejpeg($file, "img/customer/barcode/{$code}.jpg");

        $data['barcode'] = "img/customer/barcode/{$code}.jpg";
        $data['barcode_path'] = getcwd().'/'.$data['barcode'];

        $this->tbl_product('customer_id');
        $this->global_model->save($data, $id);
    }
    
    /*** Check Duplicate Customer  ***/
    public function check_customer_phone($phone=null, $customer_id = null)
    {
        $this->tbl_customer('customer_id');
        if(empty($customer_id))
        {
            $result = $this->global_model->get_by(array('phone'=>$phone), true);
        }else{
            //$result = $this->customer_model->check_customer_phone($phone, $customer_id);
            $result = $this->global_model->get_by(array('phone'=>$phone, 'customer_id !=' => $customer_id ), true);
        }

        if($result)
        {
            echo 'This phone number already exist!';
        }

    }
}
