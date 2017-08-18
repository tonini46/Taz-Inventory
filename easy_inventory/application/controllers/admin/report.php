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

class Report extends Admin_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('report_model');
        $this->load->model('global_model');
        $this->load->model('product_model');
    }


    /*** Sales Report ***/
    public function sales_report()
    {
        $data['title'] = 'View Sales Report';

        $start_date = $this->input->post('start_date', true);
        $end_date = $this->input->post('end_date', true);
        $inchi = $this->input->post('country_id',true);

        // report date
        $data['start_date'] = date('Y-m-d', strtotime($start_date));
        $data['end_date'] = date('Y-m-d', strtotime($end_date));
        $data['country'] = $this->global_model->get_countries();
        $data['inchi'] = country($inchi);
        $data['inchi_id'] = $inchi;
        

        // invoice information
        $invoice = $this->report_model->get_invoice_by_date($data['start_date'], $data['end_date'],$inchi);

        if (!empty($invoice)) {
            $this->tbl_order_details('order_details_id');
            foreach ($invoice as $v_invoice) {
                $data['invoice_details'][$v_invoice->invoice_no] = $this->global_model->get_by(array('order_id' => $v_invoice->order_id),
                    false);
                $data['order'][] = $v_invoice;
            }
        }

        $data['subview'] = $this->load->view('admin/report/sales_report', $data, true);
        $this->load->view('admin/_layout_main', $data);
    }

    /*** Generate PDF Sales Report ***/
    public function pdf_sales_report()
    {
        $start_date = $this->input->post('start_date', true);
        $end_date = $this->input->post('end_date', true);
        $inchi = $this->input->post('country_id',true);


        $data['start_date'] = date('Y-m-d', strtotime($start_date));
        $data['end_date'] = date('Y-m-d', strtotime($end_date));
        $data['country'] = $this->global_model->get_countries();
        $data['invoice_details']=null;
        $data['inchi'] = $inchi;        

        // invoice information
        $invoice = $this->report_model->get_invoice_by_date($data['start_date'], $data['end_date'], $inchi);

        if (!empty($invoice)) {
            $this->tbl_order_details('order_details_id');
            foreach ($invoice as $v_invoice) {
                $data['invoice_details'][$v_invoice->invoice_no] = $this->global_model->get_by(array('order_id' => $v_invoice->order_id),
                    false);
                $data['order'][] = $v_invoice;
            }
        }
        //echo json_encode($data['invoice_details']); exit;

        foreach ($data['invoice_details'] as $invoice => $v_order) {
            $buying_price = 0;
            foreach ($v_order as $v_order_details) {

                $buying_price += $v_order_details->buying_price;
            }
            $data['total_buying'][] = $buying_price;
        }
       //echo json_encode($data); exit;

        $html = $this->load->view('admin/report/sales_report_pdf', $data, true);


        $filename = 'INV-' . $start_date . ' to ' . $end_date;
        $this->load->helper(array('dompdf', 'file'));
        pdf_create($html, $filename);

        $pdf->WriteHTML($html);
        $pdf->Output($filename, 'D');

    }

    /*** purchase Report ***/
    public function purchase_report()
    {
        $data['title'] = 'View Purchase Report';

        $start_date = $this->input->post('start_date', true);
        $end_date = $this->input->post('end_date', true);
        $inchi = $this->input->post('country_id',true);

        // report date
        $data['start_date'] = date('Y-m-d', strtotime($start_date));
        $data['end_date'] = date('Y-m-d', strtotime($end_date));
        $data['country'] = $this->global_model->get_countries();
        $data['inchi'] = country($inchi);
        $data['inchi_id'] = $inchi;


        // invoice information
        $invoice = $this->report_model->get_purchase_by_date($data['start_date'], $data['end_date'], $inchi);


        if (!empty($invoice)) {
            $this->tbl_purchase_product('purchase_product_id');
            foreach ($invoice as $v_invoice) {
                $data['purchase_details'][$v_invoice->purchase_order_number] = $this->global_model->get_by(array('purchase_id' => $v_invoice->purchase_id),
                    false);
                $data['purchase'][] = $v_invoice;
            }
        }


        $data['subview'] = $this->load->view('admin/report/purchase_report', $data, true);
        $this->load->view('admin/_layout_main', $data);
    }

    /*** PDF Purchase Report ***/
    public function pdf_purchase_report()
    {
        $start_date = $this->input->post('start_date', true);
        $end_date = $this->input->post('end_date', true);
        $inchi = $this->input->post('country_id',true);

        // report date
        $data['start_date'] = date('Y-m-d', strtotime($start_date));
        $data['end_date'] = date('Y-m-d', strtotime($end_date));
        $data['country'] = $this->global_model->get_countries();
        $data['inchi'] = $inchi; 

        $invoice = $this->report_model->get_purchase_by_date($data['start_date'], $data['end_date'],$inchi);


        if (!empty($invoice)) {
            $this->tbl_purchase_product('purchase_product_id');
            foreach ($invoice as $v_invoice) {
                $data['purchase_details'][$v_invoice->purchase_order_number] = $this->global_model->get_by(array('purchase_id' => $v_invoice->purchase_id),
                    false);
                $data['purchase'][] = $v_invoice;
            }
        }


     // echo json_encode($data); exit;
        $html = $this->load->view('admin/report/purchase_report_pdf', $data, true);


        $filename = 'PUR-'.$start_date.' to '.$end_date;
        $this->load->helper(array('dompdf', 'file'));
        pdf_create($html, $filename);

        $pdf->WriteHTML($html);
        $pdf->Output($filename, 'D');

    }

    /*** expense Report ***/
    public function expense_report()
    {
        $data['title'] = 'View Expense Report';

        $start_date = $this->input->post('start_date', true);
        $end_date = $this->input->post('end_date', true);
        $inchi = $this->input->post('country_id',true);

        // report date
        $data['start_date'] = date('Y-m-d', strtotime($start_date));
        $data['end_date'] = date('Y-m-d', strtotime($end_date));
        $data['country'] = $this->global_model->get_countries();
        $data['inchi'] = country($inchi);
        $data['inchi_id'] = $inchi;


        // expense information
        $data['expense_details'] = $this->report_model->get_expense_by_date($data['start_date'], $data['end_date'], $inchi,0);
        $data['grand_total'] = $this->report_model->get_expense_by_date($data['start_date'], $data['end_date'], $inchi,1);
//echo json_encode($data); exit;

        $data['subview'] = $this->load->view('admin/report/expense_report', $data, true);
        $this->load->view('admin/_layout_main', $data);
    }

     /*** PDF Purchase Report ***/
    public function pdf_expense_report()
    {
        $start_date = $this->input->post('start_date', true);
        $end_date = $this->input->post('end_date', true);
        $inchi = $this->input->post('country_id',true);

        // report date
        $data['start_date'] = date('Y-m-d', strtotime($start_date));
        $data['end_date'] = date('Y-m-d', strtotime($end_date));
        $data['country'] = $this->global_model->get_countries();
        $data['inchi'] = $inchi; 

        // expense information
        $data['expense_details'] = $this->report_model->get_expense_by_date($data['start_date'], $data['end_date'], $inchi,0);
        $data['grand_total'] = $this->report_model->get_expense_by_date($data['start_date'], $data['end_date'], $inchi,1);


     // echo json_encode($data); exit;
        $html = $this->load->view('admin/report/expense_report_pdf', $data, true);


        $filename = 'Exp-'.$start_date.' to '.$end_date;
        $this->load->helper(array('dompdf', 'file'));
        pdf_create($html, $filename);

        $pdf->WriteHTML($html);
        $pdf->Output($filename, 'D');

    }

    /*** product sales Report ***/
    public function product_sales_report()
    {
        $data['title'] = 'View Product Sales Report';
        $start_date = $this->input->post('start_date', true);
        $end_date = $this->input->post('end_date', true);
        $inchi = $this->input->post('country_id',true);
        $data['product_det'] = $this->input->post('product',true);
        $product = explode('-|-', $this->input->post('product',true));
        $product_code = $product[0];

        // report date
        $data['start_date'] = date('Y-m-d', strtotime($start_date));
        $data['end_date'] = date('Y-m-d', strtotime($end_date));
        $data['country'] = $this->global_model->get_countries();
        $data['inchi'] = country($inchi);
        $data['inchi_id'] = $inchi;
        $data['product'] = $this->product_model->get_all_product_info();


        // expense information
        $data['product_sales_details'] = $this->report_model->get_product_sales_by_date($data['start_date'], $data['end_date'], $inchi,2,$product_code);
        $data['sub_total'] = $this->report_model->get_product_sales_by_date($data['start_date'], $data['end_date'], $inchi,0,$product_code);
        $data['total_tax'] = $this->report_model->get_product_sales_by_date($data['start_date'], $data['end_date'], $inchi,1,$product_code);
        //echo json_encode($data); exit;

        $data['subview'] = $this->load->view('admin/report/product_sales_report', $data, true);
        $this->load->view('admin/_layout_main', $data);
    }

     /*** PDF Purchase Report ***/
    public function pdf_product_sales_report()
    {
        $start_date = $this->input->post('start_date', true);
        $end_date = $this->input->post('end_date', true);
        $inchi = $this->input->post('country_id',true);
        $product = explode('-|-', $this->input->post('product',true));
        $product_code = $product[0];
        $product_name = $product[1];

        // report date
        $data['start_date'] = date('Y-m-d', strtotime($start_date));
        $data['end_date'] = date('Y-m-d', strtotime($end_date));
        $data['country'] = $this->global_model->get_countries();
        $data['inchi'] = country($inchi);
        $data['inchi_id'] = $inchi;
        $data['product_det'] = $this->input->post('product',true);
        $data['product'] = $this->product_model->get_all_product_info();


        // expense information
        $data['product_sales_details'] = $this->report_model->get_product_sales_by_date($data['start_date'], $data['end_date'], $inchi,2,$product_code);
        $data['sub_total'] = $this->report_model->get_product_sales_by_date($data['start_date'], $data['end_date'], $inchi,0,$product_code);
        $data['total_tax'] = $this->report_model->get_product_sales_by_date($data['start_date'], $data['end_date'], $inchi,1,$product_code);
       // echo json_encode($data); exit;

       $html = $this->load->view('admin/report/product_sales_report_pdf', $data, true);


        $filename = $product_name.' - #'.$product_code.' Sales-'.$start_date.' to '.$end_date;
        $this->load->helper(array('dompdf', 'file'));
        pdf_create($html, $filename);

        $pdf->WriteHTML($html);
        $pdf->Output($filename, 'D');

    }


}
