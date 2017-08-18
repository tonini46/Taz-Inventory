<section class="content">
    <div class="row">
        <div class="col-md-12">

            <div class="box box-primary ">
                <div class="box-header box-header-background with-border">
                        <h3 class="box-title ">View Activity Logs</h3>
                    <div class="box-tools">
                        <a onclick="print_invoice('printableArea')" class="btn btn-default"><i class="fa fa-print"></i> Print</a>

                    </div>
                </div>



                <div class="box-body">

                    <div id="printableArea" class="table-responsive">

                        <!-- Table -->
                        <table class="table table-bordered table-striped" id="dataTables-example">
                            <thead ><!-- Table head -->
                            <tr>
                                <th class="active">Sl</th>
                                <th class="active">Activity</th>
                                <th class="active">Activity Date</th>
                                <th class="active">IP Address</th>
                                <th class="active">Country</th>
                            </tr>
                            </thead><!-- / Table head -->
                            <tbody><!-- / Table body -->
                            <?php $counter =1 ; ?>
                             <?php if($activity_info): foreach($activity_info as $v_activity): ?>
                                <tr class="custom-tr">
                                    <td class="vertical-td">
                                        <?php echo  $counter ?>
                                    </td>
                                    <td class="vertical-td"><?php echo $v_activity->activityTitle ?></a></td>
                                    <td class="vertical-td"><?php echo $v_activity->activityDate ?></td>
                                    <td class="vertical-td"><?php echo $v_activity->ipAddress ?></td>
                                    <td class="vertical-td"><?php echo country($v_activity->country_id) ?></td>
                                </tr>
                            <?php
                                $counter++;
                            endforeach;
                            ?><!--get all sub category if not this empty-->
                            <?php else : ?> <!--get error message if this empty-->
                                <td colspan="5">
                                    <strong>There is no record for display</strong>
                                </td><!--/ get error message if this empty-->
                            <?php endif; ?>
                            </tbody><!-- / Table body -->
                        </table> <!-- / Table -->
                        </div>

                </div><!-- /.box-body -->
            </div>
            <!-- /.box -->
        </div>
        <!--/.col end -->
    </div>
    <!-- /.row -->
</section>
