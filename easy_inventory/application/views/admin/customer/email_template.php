<?php $info = $this->session->userdata('business_info');?>

<?php
//company logo
if(!empty($info->logo)){
    $logo = $info->logo;
}else{
    $logo = 'img/logo.png';
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


if(!empty($customer)) 
  $data = "<p>Hey ".$customer->customer_name.",</p><p>Attached is a copy of your generated ".$doc_name.".<br>Dated ".$date."</p><p>Regards,<br>".$company_name."</p>";
echo $data;
?>
