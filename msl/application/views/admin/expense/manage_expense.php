<!--Massage-->
<?php echo message_box('success'); ?>
<?php echo message_box('error'); ?>
<!--/ Massage-->
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

            <div class="box box-primary ">
                <div class="box-header box-header-background with-border">
                        <h3 class="box-title ">Manage Expense</h3>
                </div>


                <div class="box-body table-responsive">

                        <!-- Table -->
                        <table class="table table-bordered table-striped" id="dataTables-example">
                            <thead ><!-- Table head -->
                            <tr>
                                <th class="active">Sl</th>
                                <th class="active">Expense Code</th>
                                <th class="active">Expense Title</th>
                                <th class="active">Expense Amount</th>
                                <th class="active">Expense Date</th>
                                <th class="active">Country</th>
                                <th class="active">Action</th>

                            </tr>
                            </thead><!-- / Table head -->
                            <tbody><!-- / Table body -->
                            <?php $counter =1 ; ?>
                            <?php if (!empty($expense)): foreach ($expense as $v_expense) : ?>
                                <tr class="custom-tr">
                                    <td class="vertical-td">
                                        <?php echo  $counter ?>
                                    </td>
                                    <td class="vertical-td"><?php echo $v_expense->expense_code ?></td>
                                    <td class="vertical-td"><?php echo $v_expense->expense_name ?></td>
                                    <td class="vertical-td"><?php echo $currency.' '.number_format(currency($v_expense->expense_amount)) ?></td>
                                    <td class="vertical-td"><?php echo $v_expense->expense_date ?></td>
                                    <td class="vertical-td"><?php echo country($v_expense->country_id) ?></td>

                                    <td class="vertical-td">
                                        <?php echo btn_edit('admin/expense/add_expense/' . $v_expense->expense_id); ?>
                                        <?php echo btn_delete('admin/expense/delete_expense/' . $v_expense->expense_id); ?>
                                    </td>

                                </tr>
                            <?php
                                $counter++;
                            endforeach;
                            ?><!--get all sub category if not this empty-->
                            <?php else : ?> <!--get error message if this empty-->
                                <td colspan="7">
                                    <strong>There is no record for display</strong>
                                </td><!--/ get error message if this empty-->
                            <?php endif; ?>
                            </tbody><!-- / Table body -->
                        </table> <!-- / Table -->

                </div><!-- /.box-body -->
            </div>
            <!-- /.box -->
        </div>
        <!--/.col end -->
    </div>
    <!-- /.row -->
</section>




