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
    $logo = 'img/uploads/Kenya.png';
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

<!--Massage-->
<?php echo message_box('success'); ?>
<?php echo message_box('error'); ?>
<!--/ Massage-->


<section class="content">
    <div class="row">
        <div class="col-md-12">

            <div class="box box-primary">
                <div class="box-header box-header-background with-border">
                    <div class="col-md-offset-3">
                        <h3 class="box-title ">Expense Report</h3>
                    </div>
                </div>
                <!-- /.box-header -->
                <div class="box-background">
                    <!-- form start -->
                    <form role="form" enctype="multipart/form-data" action="<?php echo base_url() ?>admin/report/expense_report" method="post">

                        <div class="row">

                            <div class="col-md-4 col-sm-12 col-xs-12 col-md-offset-3">

                                <div class="box-body">


                                    <div class="form-group">
                                        <label class="control-label">Start Date<span class="required"> *</span></label>

                                        <div class="input-group">
                                            <input type="text" value="" class="form-control datepicker" name="start_date" data-format="yyyy/mm/dd" required>

                                            <div class="input-group-addon">
                                                <a href="#"><i class="entypo-calendar"></i></a>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="control-label">End Date<span class="required"> *</span></label>
                                        <div class="input-group">
                                            <input type="text" value="" class="form-control datepicker" name="end_date" data-format="yyyy/mm/dd" required>

                                            <div class="input-group-addon">
                                                <a href="#"><i class="entypo-calendar"></i></a>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- /.Country -->
                                    <div class="form-group">
                                        <label>Country <span class="required">*</span></label>
                                        <?php if($this->session->userdata('user_type') == 1){ ?>
                                        <select name="country_id" class="form-control col-sm-5">
                                            <option value="">Select Country</option>
                                            <?php 
                                                foreach ($country as $key) {?>
                                                      <option value="<?php echo $key->country_id; ?>">
                                                        <?php echo $key->name; ?>
                                                      </option>
                                                <?php } ?>
                                            
                                        </select>
                                        <?php } else{?>
                                        <input type="text" value="<?php echo country($this->session->userdata('user_country')); ?>" class="form-control" disabled>
                                        <input type="hidden" name="country_id" value="<?php echo $this->session->userdata('user_country'); ?>" class="form-control">
                                        <?php } ?>

                                    </div>

                                    <button type="submit" class="btn bg-navy" type="submit">Generate Report
                                    </button><br/><br/>
                                </div>
                                <!-- /.box-body -->

                            </div>
                        </div>

                    </form>
                </div>

                <?php if (!empty($expense_details)) :?>
                <div class="box-body">

                    <div class="row ">
                        <div class="col-md-8 col-md-offset-2">
                            <form method="post" action="<?php echo base_url(); ?>admin/report/pdf_expense_report">
                            <div class="btn-group pull-right">
                                <a onclick="print_invoice('printableArea')" class="btn btn-primary"><i class="fa fa-print"></i> Print</a>

                                <button type="submit" class="btn bg-navy">
                                    PDF
                                </button>
                                    <input type="hidden" name="start_date" value="<?php echo $start_date ?>">
                                    <input type="hidden" name="end_date" value="<?php echo $end_date ?>">
                                    <input type="hidden" name="country_id" value="<?php echo $inchi_id; ?>">

                            </div>
                            </form>

                        </div>
                    </div>

                    <br/>
                    <br/>

                    <div id="printableArea">
                        <link href="<?php echo base_url(); ?>asset/css/sales_report.css" rel="stylesheet" type="text/css" />



                        <div class="row ">
                            <div class="col-md-8 col-md-offset-2">

                                <header class="clearfix">
                                    <div id="logo">
                                        <img style="width:60%" src="<?php  echo base_url(). $logo?>">
                                    </div>
                                    <div id="company" class="hidden">
                                        <h2 class="name"><?php echo $company_name?></h2>
                                        <div><?php echo $company_phone?></div>
                                        <div><?php echo $company_email?></div>
                                    </div>

                                </header>
                                <hr/>

                                <main class="invoice_report">

                                    <h4>Expense Report from: <strong><?php echo $start_date ?></strong> to <strong><?php echo $end_date ?></strong></h4>
                                    <span><b>Country: </b><?php echo $inchi; ?></span>
                                    <br/>
                                    <br/>

                                <?php
                                $total_cost=0;
                                $total_sell=0;
                                $total_profit=0;
                                ?>
                                    <table border="0" cellspacing="0" cellpadding="0">
                                        <thead>
                                        <tr style="background-color: #ECECEC">
                                            <th class="no text-right">#</th>
                                            <th class="desc">Expense Code</th>
                                            <th class="desc">Expense Title</th>
                                            <th class="desc text-right">Expense Note</th>
                                            <th class="total text-right">Expense Date</th>
                                            <th class="total text-right ">TOTAL</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <?php $k =1?>
                                    <?php if (!empty($expense_details)): foreach ($expense_details as $v_expense) : ?>
                                            <tr>
                                                <td class="no"><?php echo $k ?></td>
                                                <td class="desc"><?php
                                                    if(!empty($v_expense->expense_code))  {
                                                        echo $v_expense->expense_code;
                                                    }
                                                    ?></td>
                                                <td class="desc"><?php echo $v_expense->expense_name ?></td>
                                                <td class="desc"><?php echo $v_expense->expense_note ?></td>
                                                <td class="total"><?php echo $v_expense->expense_date  ?></td>
                                                <td class="total"><?php echo number_format(currency($v_expense->expense_amount,2)) ?></td>
                                            </tr>
                                        <?php $k++?>


                                        <?php
                                            endforeach;
                                            endif;
                                        ?>


                                        </tbody>
                                        <tfoot>
                                        <tr>
                                            <td colspan="3"></td>
                                            <td colspan="2">Grand Total</td>
                                            <td><?php echo $currency.' '.number_format(currency( $grand_total[0]->total,2)) ?></td>
                                        </tr>
                                        </tfoot>


                                    </table>


                                </main>
                                <hr/>
                                <footer class="text-center">
                                    <strong><?php echo $company_name?></strong>&nbsp;&nbsp;&nbsp;<?php echo $address ?>
                                </footer>


                            </div>
                        </div>

                </div>


            </div>
            <!-- /.box -->
            <?php endif ?>
        </div>
        <!--/.col end -->
    </div>
    <!-- /.row -->
</section>


