<!-- View massage -->
<?php echo message_box('success'); ?>
<?php echo message_box('error'); ?>

<section class="content">
    <div class="row">
        <div class="col-md-12">

            <div class="box box-primary">
                <div class="box-header box-header-background with-border">
                    <div class="col-md-offset-3">
                        <h3 class="box-title ">Add Country</h3>
                    </div>
                </div>
                <!-- /.box-header -->

                <!-- form start -->
                <form role="form" enctype="multipart/form-data" id="addCountryForm" onsubmit="return companyLogo(this)"
                      action="<?php echo base_url(); ?>admin/country/save_country/<?php if (!empty($country->country_id)) {
                          echo $country->country_id;
                      } ?>"
                      method="post">

                    <div class="row">

                        <div class="col-md-6 col-sm-12 col-xs-12 col-md-offset-3">

                            <div class="box-body">

                               
                                <!-- /.country Name -->
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Country Name <span class="required">*</span></label>
                                    <input type="text" name="name" placeholder="Country Name"
                                           value="<?php
                                           if (!empty($country->name)) {
                                               echo $country->name;
                                           }
                                           ?>"
                                           class="form-control">
                                </div>

                                <!-- /.Currency -->
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Currency <span
                                            class="required">*</span></label>
                                    <input type="text" placeholder="Currency" name="currency"
                                           value="<?php
                                           if (!empty($country->currency)) {
                                               echo $country->currency;
                                           }
                                           ?>"
                                           class="form-control">
                                </div>

                                 <!-- /.Company Logo -->
                                <div class="form-group">
                                    <label>Company Logo</label>
                                </div>
                                <div class="form-group"><!-- Company Logo -->
                                    <input type="hidden" name="old_path" value="<?php
                                    if (!empty($country->full_path)) {
                                        echo $country->full_path;
                                    }
                                    ?>">

                                    <div class="fileinput fileinput-new" data-provides="fileinput">
                                        <div class="fileinput-new thumbnail g-logo-img">
                                            <?php if (!empty($country->logo)) : ?>
                                                <img src="<?php echo base_url() . $country->logo; ?>">
                                            <?php else: ?>

                                            <?php endif; ?>
                                        </div>
                                        <div class="fileinput-preview fileinput-exists thumbnail g-logo-img"></div>

                                        <div>
                                    <span class="btn btn-default btn-file">
                                        <span class="fileinput-new"><input type="file"  name="logo" size="20"/></span>
                                        <span class="fileinput-exists">Change</span>

                                    </span>
                                            <a href="#" class="btn btn-default fileinput-exists"
                                               data-dismiss="fileinput">Remove</a>

                                        </div>
                                        <div id="valid_msg" class="required"></div>
                                    </div>
                                </div>
                                <!-- / Company Logo -->


                            </div>
                            <!-- /.box-body -->
                        </div>
                    </div>


                    <!-- country id -->
                    <input type="hidden" name="country_id" value="<?php if (!empty($country->country_id)) {
                        echo $country->country_id;
                    } ?>" id="country_id">

                    <div class="box-footer">
                        <button type="submit" id="country_btn" class="btn bg-navy col-md-offset-3" type="submit">Add Country
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