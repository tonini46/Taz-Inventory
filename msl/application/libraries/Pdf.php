<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once APPPATH."/third_party/dompdf/autoload.inc.php";
use Dompdf\Dompdf;
class Pdf extends Dompdf{ 
    public function __construct() { 
        parent::__construct(); 
    } 

    public function pdf_create($html, $filename='', $stream='') 
   {
    $dompdf = new Dompdf();
    $dompdf->load_html($html);
    $dompdf->render();
    if ($stream == 'view') {
        return $dompdf->stream($filename, array("Attachment" => false));
    }else if ($stream == 'download') {
        return $dompdf->stream($filename);
    }else if($stream == 'send_email') {
        return $dompdf->output();
    }
  }
}
