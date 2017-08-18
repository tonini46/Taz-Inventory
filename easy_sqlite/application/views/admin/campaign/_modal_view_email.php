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

$content_start = '
<table border="0" cellspacing="0" cellpadding="0" style="background-color:#F6F4FD;font-family:Helvetica,Arial,sans-serif" width="100%" bgcolor="#F6F4FD">
  <tbody>
    <tr>
      <td><table border="0" cellspacing="0" cellpadding="0" style="background-color:#F6F4FD;font-family:Helvetica,Arial,sans-serif" width="1" bgcolor="#F6F4FD">
          <tbody>
            <tr>
              <td><div style="min-height:5px;font-size:5px;line-height:5px"> &nbsp; </div></td>
            </tr>
          </tbody>
        </table></td>
    </tr>
    <tr>
      <td><table cellspacing="0" cellpadding="0" border="0" align="center" width="100%" style="table-layout:fixed;font-family:Helvetica,Arial,sans-serif">
          <tbody>
            <tr>
              <td align="center"><table border="0" cellspacing="0" cellpadding="0" style="font-family:Helvetica,Arial,sans-serif;min-width:290px" width="400">
                  <tbody>
                    <tr>
                      <td align="left"><table border="0" cellspacing="0" cellpadding="0" style="font-family:Helvetica,Arial,sans-serif" width="100%" bgcolor="#F6F4FD">
                          <tbody>
                            <tr>
                              <td><table width="1" border="0" cellspacing="0" cellpadding="0" style="font-family:Helvetica,Arial,sans-serif">
                                  <tbody>
                                    <tr>
                                      <td><div style="min-height:8px;font-size:8px;line-height:8px"> &nbsp; </div></td>
                                    </tr>
                                  </tbody>
                                </table></td>
                            </tr>
                            <tr>
                              <td><table border="0" cellspacing="0" cellpadding="0" style="font-family:Helvetica,Arial,sans-serif" width="100%">
                                  <tbody>
                                    <tr>
                                      <td align="left" valign="middle" width="95" height="21"><a style="http://www.measurementsystems.co.ke"><img src="http://www.measurementsystems.co.ke/image/catalog/logo_theme.png" height="61" alt="Measurement Systems Ltd" style="border:none;text-decoration:none" class="CToWUd"></a></td>
                                    </tr>
                                  </tbody>
                                </table></td>
                            </tr>
                          </tbody>
                        </table>
                        <table width="1" border="0" cellspacing="0" cellpadding="0" style="font-family:Helvetica,Arial,sans-serif">
                          <tbody>
                            <tr>
                              <td><div style="min-height:8px;font-size:8px;line-height:8px"> &nbsp; </div></td>
                            </tr>
                          </tbody>
                        </table>
                        <table border="0" cellspacing="0" cellpadding="0" style="font-family:Helvetica,Arial,sans-serif;background: #002060;border: solid 1px #eee;border-bottom: 0;" width="100%">
                          <tbody>
                            <tr>
                              <td width="20">
                                <table width="20" border="0" cellspacing="0" cellpadding="0" style="font-family:Helvetica,Arial,sans-serif">
                                  <tbody>
                                    <tr>
                                      <td><div style="min-height:0px;font-size:0px;line-height:0px"> &nbsp; </div></td>
                                    </tr>
                                  </tbody>
                                </table>
                              </td>
                              <td width="100%"><table width="560" cellspacing="0" cellpadding="1" border="0" style="table-layout:fixed;font-family:Helvetica,Arial,sans-serif">
                                  <tbody>
                                    <tr>
                                      <td width="560"><div style="min-height:12px;font-size:12px;line-height:12px;width:560px"> &nbsp; </div></td>
                                    </tr>
                                  </tbody>
                                </table></td>
                              <td width="20"><table width="20" border="0" cellspacing="0" cellpadding="0" style="font-family:Helvetica,Arial,sans-serif">
                                  <tbody>
                                    <tr>
                                      <td><div style="min-height:0px;font-size:0px;line-height:0px"> &nbsp; </div></td>
                                    </tr>
                                  </tbody>
                                </table></td>
                            </tr>
                          </tbody>
                        </table>
                        <table border="0" cellspacing="0" cellpadding="0" style="font-family:Helvetica,Arial,sans-serif; border: 1px solid #eee;border-top: 0;" width="100%" bgcolor="#FFFFFF">
                          <tbody>
                            <tr>
                              <td><table border="0" cellspacing="0" cellpadding="0" style="font-family:Helvetica,Arial,sans-serif" width="100%" bgcolor="#fff">
                                  <tbody>
                                    <tr>
                                      <td height="20"><table width="1" border="0" cellspacing="0" cellpadding="1" style="font-family:Helvetica,Arial,sans-serif">
                                          <tbody>
                                            <tr>
                                              <td><div style="min-height:18px;font-size:18px;line-height:18px"> &nbsp; </div></td>
                                            </tr>
                                          </tbody>
                                        </table></td>
                                    </tr>
                                    <tr>
                                      <td style="padding:0 10px">';
          $content_end='</td>
                                    </tr>
                                    
                                    <tr>
                                      <td height="25"><table width="1" border="0" cellspacing="0" cellpadding="1" style="font-family:Helvetica,Arial,sans-serif">
                                          <tbody>
                                            <tr>
                                              <td><div style="min-height:23px;font-size:23px;line-height:23px"> &nbsp; </div></td>
                                            </tr>
                                          </tbody>
                                        </table></td>
                                    </tr>
                                  </tbody>
                                </table></td>
                            </tr>
                            
                                                        
                            
                          
                          </tbody>
                        </table>
                        </td>
                    </tr>
                    <tr>
                      <td></td>
                    </tr>
                    <tr>
                      <td align="left"><table border="0" cellspacing="0" cellpadding="0" style="font-family:Helvetica,Arial,sans-serif" width="100%">
                          <tbody>
                            <tr>
                              <td><table width="1" border="0" cellspacing="0" cellpadding="0" style="font-family:Helvetica,Arial,sans-serif">
                                  <tbody>
                                    <tr>
                                      <td><div style="min-height:10px;font-size:10px;line-height:10px"> &nbsp; </div></td>
                                    </tr>
                                  </tbody>
                                </table></td>
                            </tr>
                            <tr>
                              <td align="center"><table border="0" cellspacing="0" cellpadding="0" style="color:#999999;font-size:11px;font-family:Helvetica,Arial,sans-serif" width="100%">
                                  <tbody>
                                    <tr>
                                      <td align="center" dir="ltr">Copyright '.date('Y').' <a href="http://www.measurementsystems.co.ke/">'.$company_name.'</a>. All rights reserved.</td>
                                    </tr>
                                    <tr>
                                      <td><table width="1" border="0" cellspacing="0" cellpadding="0" style="font-family:Helvetica,Arial,sans-serif">
                                          <tbody>
                                            <tr>
                                              <td><div style="min-height:10px;font-size:10px;line-height:10px"> &nbsp; </div></td>
                                            </tr>
                                          </tbody>
                                        </table></td>
                                    </tr>
                                    
                                  </tbody>
                                </table></td>
                            </tr>
                            <tr>
                              <td><table width="1" border="0" cellspacing="0" cellpadding="0" style="font-family:Helvetica,Arial,sans-serif">
                                  <tbody>
                                    <tr>
                                      <td><div style="min-height:20px;font-size:20px;line-height:20px"> &nbsp; </div></td>
                                    </tr>
                                  </tbody>
                                </table></td>
                            </tr>
                          </tbody>
                        </table></td>
                    </tr>
                  </tbody>
                </table></td>
            </tr>
          </tbody>
        </table></td>
    </tr>
    <tr>
      <td><table width="1" border="0" cellspacing="0" cellpadding="0" style="font-family:Helvetica,Arial,sans-serif">
          <tbody>
            <tr>
              <td><div style="min-height:20px;font-size:20px;line-height:20px"> &nbsp; </div></td>
            </tr>
          </tbody>
        </table></td>
    </tr>
  </tbody>
</table>';

?>
<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
    <h4 class="modal-title" id="myModalLabel"><?php echo $campaign->campaign_name ?></h4>
</div>
<div class="modal-body wrap-modal wrap" style="max-height: 900px;">





    <div class="row">

        <div class="col-sm-12">
            <?php $info = $this->session->userdata('business_info');?>
            
                        <?php if(!empty($campaign->email_body)) $data = $campaign->email_body;
                        echo $content_start.$data.$content_end;  ?>
                
        </div>
    </div>




    <div class="modal-footer" >

            <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
            <a href="<?php echo base_url(); ?>admin/campaign/new_campaign/<?php echo $campaign_id ?>" type="button" class="btn btn-primary">Edit Email</a>

        </div>

</div>


