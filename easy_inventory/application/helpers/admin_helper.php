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

function btn_edit($uri) {
    return anchor($uri, '<i class="glyphicon glyphicon-edit"></i>', array('class' => "btn bg-navy btn-xs", 'title'=>'Edit', 'data-toggle'=>'tooltip', 'data-placement'=>'top'));
}
function btn_edit_disable($uri) {
    return anchor($uri, '<span class="glyphicon glyphicon-pencil"></span>', array('class' => "btn btn-primary btn-xs disabled", 'title'=>'Edit', 'data-toggle'=>'tooltip', 'data-placement'=>'top'));
}

function btn_edit_modal($uri) {
    return anchor($uri, '<span class="glyphicon glyphicon-pencil"></span>', array('class' => "btn btn-primary btn-xs", 'title'=>'Edit', 'data-toggle'=>'tooltip', 'data-placement'=>'top', 'data-toggle'=>'modal', 'data-target'=>'#myModal'));
}

function btn_view_modal($uri) {
    return anchor($uri, '<span class="glyphicon glyphicon-search"></span>', array('class' => "btn bg-olive btn-xs",'data-toggle'=>'tooltip', 'data-placement'=>'top', 'title'=>'View', 'data-toggle'=>'modal', 'data-target'=>'#myModal'));
}

function btn_delete($uri) {
    return anchor($uri, '<i class="fa fa-trash-o"></i>', array(
        'class' => "btn btn-danger btn-xs", 'title'=>'Delete', 'data-toggle'=>'tooltip', 'data-placement'=>'top', 'onclick' => "return confirm('Are you sure want to delete this record ?');"
    ));    
}
function btn_delete_disable($uri) {
    return anchor($uri, '<i class="fa fa-trash-o"></i>', array(
        'class' => "btn btn-danger btn-xs disabled", 'title'=>'Delete', 'data-toggle'=>'tooltip', 'data-placement'=>'top', 'onclick' => "return confirm('You are about to delete a record. This cannot be undone. Are you sure?');"
    ));    
}
function btn_active($uri) {
    return anchor($uri, '<i class="fa fa-check"></i>', array(
        'class' => "btn btn-success btn-xs", 'title'=>'Active', 'data-toggle'=>'tooltip', 'data-placement'=>'top', 'onclick' => "return confirm('You are about to active new sesion . This cannot be undone. Are you sure?');"
    ));    
}

function btn_print() {
    return anchor('','<span class="glyphicon glyphicon-print"></i></span>', array('class' => "btn btn-primary btn-xs", 'title'=>'Print','data-toggle'=>'tooltip', 'data-placement'=>'top', 'onclick'=>'printDiv("printableArea")'));
}

function btn_atndc_print() {
    return anchor('','<span class="glyphicon glyphicon-print"></i></span>', array('class' => "btn btn-customs btn-xs", 'title'=>'Print','data-toggle'=>'tooltip', 'data-placement'=>'top', 'onclick'=>'printDiv("printableArea")'));
}

function btn_email($uri) {
    return anchor($uri, '<span <i class="fa fa-envelope"></i></span>', array('class' => "btn btn-success btn-xs",'data-toggle'=>'tooltip', 'data-placement'=>'top', 'title'=>'Email'));
}

function btn_pdf($uri) {
    return anchor($uri, '<span <i class="fa fa-file-pdf-o"></i></span>', array('class' => "btn btn-primary btn-xs",'data-toggle'=>'tooltip', 'data-placement'=>'top', 'title'=>'Pdf'));
}
function btn_excel($uri) {
    return anchor($uri, '<span <i class="fa fa-file-excel-o"></i></span>', array('class' => "btn btn-primary btn-xs",'data-toggle'=>'tooltip', 'data-placement'=>'top', 'title'=>'Excel'));
}

function btn_view($uri) {
    return anchor($uri, '<span class="glyphicon glyphicon-search"></span>', array('class' => "btn bg-olive btn-xs",'data-toggle'=>'tooltip', 'data-placement'=>'top', 'title'=>'View'));
}

function btn_save($uri) {
    return anchor($uri, '<span <i class="fa fa-plus-circle"></i></span>', array('class' => "btn btn-success btn-xs", 'title'=>'Save', 'data-toggle'=>'tooltip', 'data-placement'=>'top'));
}

function btn_add($uri) {
    return anchor($uri, '<span <i class="fa fa-plus-square"></i></span>', array('class' => "btn btn-success btn-xs", 'title'=>'Add Routine', 'data-toggle'=>'tooltip', 'data-placement'=>'top'));
}

function btn_publish($uri) {
return anchor($uri, '<i class="fa fa-check"></i>', array(
        'class' => "btn btn-success btn-xs", 'title'=>'Click to Unpublish', 'data-toggle'=>'tooltip', 'data-placement'=>'top', 'onclick' => "return confirm('You are about to unpublish an exam. Are you sure?');"
    ));    
}

function btn_unpublish($uri) {
    return anchor($uri, '<i class="fa fa-times"></i>', array(
        'class' => "btn btn-danger btn-xs", 'title'=>'Click to PUblish', 'data-toggle'=>'tooltip', 'data-placement'=>'top', 'onclick' => "return confirm('You are about to publish an exam. Are you sure?');"
    ));
}

function country($id){
   
    // Get a reference to the controller object
    $CI = get_instance();

    // Call a function of the model
    return $CI->global_model->get_country($id);
}

function currency($price){
     $CI =& get_instance();

     //Currency Converter
     $CI->load->library('currencyconverter');

     //Currency Code Session
     $currency_code = $CI->session->userdata('currency_code');

     //Get default Currency
     $default_currency = $CI->global_model->get_default_currency();

     //Currency Check
     return $CI->currencyconverter->convert($default_currency, $currency_code, $price, 1, 1);
}

function currency_to_db($price){
     $CI =& get_instance();

     //Currency Converter
     $CI->load->library('currencyconverter');

     //Currency Code Session
     $currency_code = $CI->session->userdata('currency_code');

     //Get default Currency
     $default_currency = $CI->global_model->get_default_currency();

     //Currency Check
     return $CI->currencyconverter->convert($currency_code, $default_currency, $price, 1, 1);
}

function invoice_number($id){
   
    // Get a reference to the controller object
    $CI = get_instance();

    // Call a function of the model
    return $CI->order_model->get_one_invoice($id)[0]->invoice_no;
}

 /*** Barcode Generate ***/
     function generate_barcode_1($code, $id)
    {
        $CI = get_instance();

        //load library
        $CI->load->library('zend');
        //load in folder Zend
        $CI->zend->load('Zend/Barcode');

        //generate barcode
        return Zend_Barcode::render('code128', 'image', array('text' => $code), array());

    }






