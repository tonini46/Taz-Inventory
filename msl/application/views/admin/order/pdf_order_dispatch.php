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
$base_url = 'http://127.0.0.1:55055/';
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


<style type="text/css">
#watermark {
    position: fixed;
    top: 25%;
    width: 100%;
    font-size: 200px;
    text-align: center;
    opacity: .1;
    transform: rotate(20deg);
    transform-origin: 50% 50%;
    z-index: -1000;
  }
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
    padding: 5px;
    vertical-align: middle;
    font-size: 10px;
  }
  .tiny{font-size: 10px; font-style: italic;}
  .zigi span{font-weight: bold;}
  .text-right{text-align: right;}
  .footer{position: fixed; bottom: 1in;}

</style>

<table border='0'; style="border-bottom:2px #ccc solid; width:100%; margin-bottom:2px;"><tr><td style="text-align:left;" class="tiny">“We are surveyors, the people who understand mapping and measuring equipment best”
<td><td style="text-align:right;"><h1 style="padding:0; margin:0;">DISPATCH NOTE #<?php echo $order_info->order_no; ?></h1></td></tr></table>
<div style="position:relative; height:100px; width:100%;">
<img src="<?php echo $base_url; ?>asset/img/pdf_logo.jpg" class="img-thumbnail" style="position:absolute; left:0; top:0;" width="60%"/>
<div class="zigi" style="position:absolute; right:20px; top:20px; font-size:11px; text-align:right;">
<span>PIN NO. : </span>P051386998D<br>
<span>TAX ID : </span>0427544R
</div>
</div>
   <table class="table table-bordered">
      <thead>
        <tr>
          <td style="width: 50%;"><b>DELIVERY TO</b></td>
          <td style="width: 50%;"  class="text-right"><b>DISPATCH DETAILS</b></td>
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
          <td class="text-right zigi">
            <span>DISPATCH NO.: </span><?php echo $order_info->order_no ?><br>
            <span>DATE : </span><?php echo date('M d, Y'); ?><br>
            <span>EXPIRATION DATE : </span><?php echo date('M d, Y', strtotime("+30 days")) ?>
          </td>
        </tr>
      </tbody>
    </table>
    <table class="table table-bordered" style="text-align:center;">
      <thead>
        <tr>
          <td><b>ORDER DATE</b></td>
          <td><b>ORDER NUMBER</b></td>
          <td><b>SALES PERSON</b></td>
        </tr>
      </thead>
      <tbody>  
        <tr>
          <td><?php echo $order_info->order_date ?></td>
          <td><?php echo $order_info->order_no ?></td>
          <td><?php echo $order_info->sales_person; ?></td>
        </tr>
      </tbody>
    </table>
    <table class="table table-bordered">
      <thead>
        <tr>
          <td><b>#</b></td>
          <td><b>QTY</b></td>
          <td class="text-right"><b>DESCRIPTION</b></td>
        </tr>
      </thead>
      <tbody>
        <?php $counter = 1?>
        <?php foreach($order_details as $v_order): ?>
            <tr>
                <td class="desc" ><?php echo $counter ?></td>
                <td><?php echo $v_order->product_quantity ?></td>
                <td class="text-right" class="desc" ><?php echo $v_order->product_name ?></td>
            </tr>
            <?php $counter ++?>
        <?php endforeach; 
        if($counter<16){
        $i = 0;
        $k = 17;
         for($i=$counter; $i<=($k-$counter); $i++){
          if($i%2==0){$bg = ' style="background:#f4f4f4;" '; }
          else{$bg = ' style="background:#fff;" '; }
        ?>
        <tr <?php echo $bg; ?> >
            <td style='font-size:9px;'><?php echo $i; ?></td>
            <td style='font-size:9px;'></td>
            <td style='font-size:9px;'></td>
        </tr>
        <?php } }?>
        

      </tbody>
    </table>
    <div style="text-align:center; margin-top:20px;">
    <span>Received By_____________________</span>&nbsp;&nbsp;&nbsp;<span>Delivered By___________________</span>
    </div>
    <img src="<?php echo $base_url; ?>asset/img/stamp.png" class="img-thumbnail" style="position:absolute; right:60%; top:70%;" width="20%"/>
 <div style="padding-top:20px;" class="footer">
    <img src="<?php echo $base_url.$logo; ?>" width="100%">    
    <div style="font-size:12px; font-weight:bold; border-top:1px solid #ccc; margin-top:5px; text-align:center;">
            THANK YOU FOR YOUR BUSINESS
    </div>
  </div>
      </body>
      </html>