<?php
$info = $this->session->userdata('business_info');
if(!empty($info->currency))
{
    $currency = $this->session->userdata('currency_code');
    if($currency == 'USD'){
        $currency = '$';
    }
}else
{
    $currency = '$';
}
?>

<?php
//company logo
if(!empty($info->logo)){
    $logo = $info->logo;
}else{
    $logo = 'img/uploads/'.country($order_info->country_id).'.png';
}

//company details
if(!empty($info->company_name)){
    $company_name = $info->company_name;
}else{
    $company_name = 'Your Company Name';
}
//company phone
if(!empty($info->phone)){
    $company_phone = $info->phone;
}else{
    $company_phone = 'Company Phone';
}
//company email
if(!empty($info->email)){
    $company_email = $info->email;
}else{
    $company_email = 'Company Email';
}
//company address
if(!empty($info->address)){
    $address = $info->address;
}else{
    $address = 'Company Address';
}



?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<style type="text/css">
.table {
    border-collapse: collapse !important;
  }
  .table-bordered thead > tr {
    background-color: #dedede !important;
    font-weight: bold;
  }

  .table-bordered th,
  .table-bordered td {
    border: 1px solid #ccc !important;
  }
  .table-bordered tr .no-border {
    border: none !important;
  }
.table {
    width: 100%;
    max-width: 100%;
    margin-bottom: 20px;
}

.table > thead > tr > th, .table > thead > tr > td, .table > tbody > tr > th, .table > tbody > tr > td, .table > tfoot > tr > th, .table > tfoot > tr > td {
    padding: 8px;
    line-height: 1.42857;
    vertical-align: top;
    font-size: 10px;
  }
  .tiny{font-size: 10px;}
  .zigi span{font-weight: bold;}
  .text-right{text-align: right;}

</style>
</style>


</head>
<body>
<table border='0'; style="border-bottom:2px #ccc solid; width:100%; margin-bottom:2px;"><tr><td style="text-align:left;" class="tiny">“We are surveyors, the people who understand mapping and measuring equipment best”
<td><td style="text-align:right;"><h1 style="padding:0; margin:0;">Invoice #<?php echo $invoice_info->invoice_no; ?></h1></td></tr></table>
<div style="position:relative; height:160px; width:100%;">
<img src="http://www.measurementsystems.co.ke/image/catalog/1.png" alt="Measurement Systems Ltd." class="img-thumbnail" style="position:absolute; left:0; top:0;" width="60%"/>
<div class="zigi" style="position:absolute; right:20px; top:20px; font-size:11px; text-align:right;">
<span>INVOICE NO.:</span>#<?php echo $invoice_info->invoice_no; ?><br>
<span>PIN NO.: </span>P051386998D<br>
<span>TAX ID: </span>0427544R<br>
<span>DATE: </span><?php echo date('M d, Y'); ?><br>
</div>
</div>
    <table class="table table-bordered">
      <thead>
        <tr>
          <td colspan="2"><b>Order Details</b></td>
        </tr>
      </thead>
      <tbody>
        <tr>
          <td style="width: 50%;">
            <strong><?php echo $company_name; ?></strong><br />
            Top Brass Hse, next to Naivas, Allsops, Ruaraka, Outering Rd, and Off Thika Highway<br>
            <b>Telephone</b> <?php echo $company_phone; ?><br />
            <b>Email</b> <?php echo $company_email; ?><br />
            <b>Website</b> <a href="http://www.measurementsystems.co.ke">http://www.measurementsystems.co.ke</a></td>
          <td style="width: 50%;"><b>Date of Invoice:</b> <?php echo date('Y-m-d', strtotime($invoice_info->invoice_date )) ?><br />
            <?php if ($invoice_info->invoice_no) { ?>
            <b>Invoice No.</b> <?php echo $invoice_info->invoice_no; ?><br />
            <?php } ?>
            <b>Order ID:</b> <?php echo 'sss'; ?><br />
            <b>Payment Method</b> <?php echo 'sss'; ?><br />
            <?php if ($order_info->sales_person) { ?>
            <b>Sales Person:</b> <?php echo $order_info->sales_person ?><br />
            <?php } ?></td>
        </tr>
      </tbody>
    </table>
    <table class="table table-bordered">
      <thead>
        <tr>
          <td style="width: 50%;"><b>To</b></td>
          <?php if(!empty($order_info->shipping_address)){ ?>
          <td style="width: 50%;"><b>Ship To</b></td>
          <?php } ?>
        </tr>
      </thead>
      <tbody>
        <tr>
          <td>
            <?php echo $order_info->customer_name ?><br>
            <?php echo $order_info->customer_address ?><br>
            <?php echo $order_info->customer_phone ?><br>
            <?php echo $order_info->customer_email ?>
          </td>
            <?php if(!empty($order_info->shipping_address)){ ?>
          <td>
            <?php echo $order_info->shipping_address; ?>
          </td>
            <?php } ?>
        </tr>
      </tbody>
    </table>
    <table class="table table-bordered">
      <thead>
        <tr>
          <td><b>#</b></td>
          <td><b>Product</b></td>
          <td class="text-right"><b>Quantity</b></td>
          <td class="text-right"><b>Unit Price</b></td>
          <td class="text-right"><b>Total</b></td>
        </tr>
      </thead>
      <tbody>
        <?php $counter = 1?>
        <?php foreach($order_details as $v_order): ?>
            <tr>
                <td class="desc" ><?php echo $counter ?></td>
                <td class="desc" ><?php echo $v_order->product_name ?></td>
                <td class="text-right" ><?php echo $v_order->product_quantity ?></td>
                <td class="text-right" ><?php echo number_format(currency($v_order->selling_price, 2)); ?></td>
                <td class="text-right" ><?php echo number_format(currency($v_order->sub_total,2)) ?></td>
            </tr>
            <?php $counter ++?>
        <?php endforeach; ?>
        
        <tr>
            <td  class="text-right" colspan="4">SUBTOTAL</td>
            <td class="text-right"><?php echo number_format(currency($order_info->sub_total,2)) ?></td>
        </tr>


        <tr>
            <td  class="text-right" colspan="4">Tax</td>
            <td class="text-right"><?php echo number_format(currency($order_info->total_tax,2)) ?></td>
        </tr>

        <?php if($order_info->discount):?>
            <tr>
                <td  class="text-right" colspan="4" >Discount Amount</td>
                <td class="text-right"><?php echo number_format(currency($order_info->discount_amount,2)) ?></td>
            </tr>
        <?php endif; ?>

        <tr>
            <td  class="text-right" colspan="4">GRAND TOTAL</td>
            <td class="text-right"><?php echo $currency ?> <?php echo number_format(currency($order_info->grand_total ,2)) ?></td>
        </tr>
      </tbody>
    </table>
    
    <div style="font-size:12px; font-weight:bold; border-top:1px solid #ccc; margin-top:5px; text-align:center;">
            THANK YOU FOR YOUR BUSINESS
          </div>
      </body>
      </html>