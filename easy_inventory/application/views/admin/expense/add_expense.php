<!-- View massage -->
<?php echo message_box('success'); ?>
<?php echo message_box('error'); ?>
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

<section class="content">
    <div class="row">
        <div class="col-md-12">

            <div class="box box-primary">
                <div class="box-header box-header-background with-border">
                    <div class="col-md-offset-3">
                        <h3 class="box-title ">Add Expense</h3>
                    </div>
                </div>
                <!-- /.box-header -->

                <!-- form start -->
                <form role="form" enctype="multipart/form-data" id="addExpenseForm"
                      action="<?php echo base_url(); ?>admin/expense/save_expense/<?php if (!empty($expense->expense_id)) {
                          echo $expense->expense_id;
                      } ?>"
                      method="post">

                    <div class="row">

                        <div class="col-md-6 col-sm-12 col-xs-12 col-md-offset-3">

                            <div class="box-body">

                                <!-- /.expense Code -->
                                <?php if (!empty($expense->expense_code)) {?>
                                    <div class="form-group">
                                        <label>Expense Code</label>
                                        <input type="text"
                                               value="<?php echo $expense->expense_code ?>"
                                               class="form-control" disabled>
                                    </div>
                                <?php }else { ?>

                                    <div class="form-group">
                                        <label>Expense Code<span class="required">*</span></label>
                                        <input type="text"
                                               value="<?php echo $code ?>"
                                               class="form-control" disabled>
                                    </div>

                                <?php } ?>


                                <!-- /.Country -->
                                <div class="form-group">
                                    <label>Country <span class="required">*</span></label>
                                    <?php if($this->session->userdata('user_type') == 1){ ?>
                                    <select name="country_id" class="form-control col-sm-5">
                                        <option value="">Select Country</option>
                                        <?php 
                                            foreach ($country as $key) {?>
                                                  <option value="<?php echo $key->country_id; ?>" <?php
                                        if(!empty($expense->country_id)){
                                            echo $expense->country_id==$key->country_id ?'selected':'';
                                        } ?>><?php echo $key->name; ?></option>
                                            <?php } ?>
                                        
                                    </select>
                                    <?php } else{?>
                                    <input type="text" value="<?php echo country($this->session->userdata('user_country')); ?>" class="form-control" disabled>
                                    <input type="hidden" name="country_id" value="<?php echo $this->session->userdata('user_country'); ?>" class="form-control">
                                    <?php } ?>

                                </div>

                                <!-- /.Expense Name -->
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Expense Title <span class="required">*</span></label>
                                    <input type="text" name="expense_name" placeholder="Expense Name"
                                           value="<?php
                                           if (!empty($expense->expense_name)) {
                                               echo $expense->expense_name;
                                           }
                                           ?>"
                                           class="form-control">
                                </div>

                                <!-- /.Expense Date -->
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Expense Date <span class="required">*</span></label>
                          
                                        <div class="input-group">
                                            <input type="text"  class="form-control datepicker" name="expense_date" data-format="yyyy/mm/dd" required value="<?php
                                           if (!empty($expense->expense_name)) {
                                               echo $expense->expense_name;
                                           }
                                           ?>">

                                            <div class="input-group-addon">
                                                <a href="#"><i class="entypo-calendar"></i></a>
                                            </div>
                                        </div>
                                </div>

                                <!-- /.Expense Amount -->
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Expense Amount <span
                                            class="required">*</span> (<small><?php echo $currency; ?></small>)</label>
                                            <div class="input-group">
                                                <span class="input-group-addon">
                                                    <?php echo $currency ; ?>
                                                </span>
                                    <input type="text" placeholder="Expense Amount" name="expense_amount"
                                           value="<?php
                                           if (!empty($expense->expense_amount)) {
                                               echo currency($expense->expense_amount);
                                           }
                                           ?>"
                                           class="form-control">
                                </div>
                                </div>

                                
                                <!-- /.Address -->
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Expense Note <span class="required">*</span></label>
                                    <textarea name="expense_note" class="form-control autogrow" id="ck_editor"
                                              placeholder="Expense Note"><?php
                                        if (!empty($expense->expense_note)) {
                                            echo $expense->expense_note;
                                        }
                                        ?></textarea>
                                    <?php echo display_ckeditor($editor['ckeditor']); ?>
                                </div>


                            </div>
                            <!-- /.box-body -->
                        </div>
                    </div>

                    <!-- expense code -->
                    <?php if (empty($expense->expense_code)) {?>
                        <input type="hidden" name="expense_code"
                               value="<?php echo $code ?>">
                    <?php }  ?>

                    <!-- expense id -->
                    <input type="hidden" name="expense_id" value="<?php if (!empty($expense->expense_id)) {
                        echo $expense->expense_id;
                    } ?>" id="expense_id">

                    <div class="box-footer">
                        <button type="submit" id="expense_btn" class="btn bg-navy col-md-offset-3" type="submit">Add expense
                    </div>
                </form>
            </div>
            <!-- /.box -->
        </div>
        <!--/.col end -->
    </div>
    <!-- /.row -->
</section>

<script src="<?php echo base_url() ?>asset/js/ajax.js" ></script>