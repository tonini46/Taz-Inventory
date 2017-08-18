<!--Massage-->
<?php echo message_box('success'); ?>
<?php echo message_box('error'); ?>
<!--/ Massage-->

<?php $info = $this->session->userdata('business_info'); ?>

<section class="content">
    <div class="row">
        <div class="col-md-12">

            <div class="box box-primary">
                <div class="box-header box-header-background with-border">
                    <div class="col-md-offset-3">
                        <h3 class="box-title "><?php echo $title; ?></h3>
                    </div>
                </div>
                <!-- /.box-header -->
                <div class="box-background">
                <!-- form start -->
                <form role="form" enctype="multipart/form-data"

                      action="<?php echo base_url(); ?>admin/settings/save_c_rate/<?php
                      if (!empty($c_rate->id)) {
                          echo $c_rate->id;
                      }
                      ?>" method="post">

                    <div class="row">

                        <div class="col-md-6 col-sm-12 col-xs-12 col-md-offset-3">

                            <div class="box-body">

                                <!-- /.Country -->
                                <div class="form-group">
                                    <label>Country <span class="required">*</span></label>
                                    <select name="country_id" class="form-control col-sm-5">
                                        <option value="">Select Country</option>
                                        <?php 
                                            foreach ($country as $key) {?>
                                                  <option value="<?php echo $key->country_id; ?>" <?php
                                        if(!empty($c_rate->country_id)){
                                            echo $c_rate->country_id==$key->country_id ?'selected':'';
                                        } ?>><?php echo $key->name; ?></option>
                                            <?php } ?>
                                        
                                    </select>
                                </div>

                                <!-- /.tax title -->
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Exchange Rate ($1 USD)<span class="required">*</span></label>
                                    <input type="text" required name="rate_form_usd" placeholder="Rate"
                                           value="<?php
                                           if (!empty($c_rate->rate_form_usd)) {
                                               echo $c_rate->rate_form_usd;
                                           }
                                           ?>"
                                           class="form-control">
                                </div><br/><br/>

                                <button type="submit" class="btn bg-navy" type="submit">Save Tax Rule
                                </button>
                            </div>
                            <!-- /.box-body -->

                        </div>
                    </div>

                </form>
                    </div>
                <div class="box-footer">

                </div>

                <div class="row">
                    <div class="col-md-10 col-md-offset-1">
                <table class="table table-bordered table-striped" id="dataTables-example">
                    <thead>
                    <tr>
                        <th class="active">SL</th>
                        <th class="active">Country</th>
                        <th class="active">Currency</th>
                        <th class="active">Exchange Rate ($1 USD)</th>
                        <th class="col-sm-2 active">Action</th>

                    </tr>
                    </thead>
                    <tbody>
                    <?php $key = 1 ?>
                    <?php if (!empty($c_rate_info)): foreach ($c_rate_info as $v_c_rate_info) : ?>
                        <tr>
                            <td><?php echo $key; ?></td>
                            <td><?php echo country($v_c_rate_info->country_id); ?></td>
                            <td><?php echo c_rate($v_c_rate_info->country_id); ?></td>
                            <td><?php echo $v_c_rate_info->rate_form_usd; ?></td>
                            <td>
                                <?php echo btn_edit('admin/settings/c_rate/' . $v_c_rate_info->id); ?>
                                <?php echo btn_delete('admin/settings/delete_c_rate/' . $v_c_rate_info->id); ?>
                            </td>

                        </tr>
                    <?php
                    $key++;
                    endforeach;
                    ?><!--get all category if not this empty-->
                    <?php else : ?> <!--get error message if this empty-->
                        <td colspan="5">
                            <strong>There is no record for display</strong>
                        </td><!--/ get error message if this empty-->
                    <?php
                    endif; ?>
                    </tbody>
                </table>

                    </div>
                </div>
            </div>
            <!-- /.box -->
        </div>
        <!--/.col end -->
    </div>
    <!-- /.row -->
</section>



