<?php
$base_url = 'http://127.0.0.1:55055/'; 
?>
<footer class="main-footer">
      
        <strong>Copyright &copy; <?php echo date("Y") ?> <a href="#">Measurement Systems Limited
      
 </div><!-- ./wrapper -->

<script type="text/javascript">
    $('.hapa li a').on('click', function(){
        var selected = $(this).attr('data-name');
        // alert(selected);
            
        $.post('<?php echo site_url( $this->uri->segment(1) . '/setcurrency'); ?>', {currency: selected}, function() {
            location.reload();
        });
    });
</script>
<!-- AdminLTE App -->
<script src="<?php echo $base_url; ?>asset/js/bootstrap.min.js" type="text/javascript"></script>
<!--<script src="--><?php //echo $base_url; ?><!--asset/js/menu.js" type="text/javascript"></script>-->
<!--<script src="--><?php //echo $base_url; ?><!--asset/js/custom-validation.js" type="text/javascript"></script>
<script src="<?php echo $base_url; ?>asset/js/jquery.validate.js" type="text/javascript"></script>-->
<script src="<?php echo $base_url; ?>asset/js/app.js" type="text/javascript"></script>
<script src="<?php echo $base_url; ?>asset/js/form-validation.js" type="text/javascript"></script>
<!-- Jasny Bootstrap for NIce Image Change -->
<script src="<?php echo $base_url ?>asset/js/jasny-bootstrap.min.js"></script>
<script src="<?php echo $base_url ?>asset/js/bootstrap-datepicker.js" ></script>
<script src="<?php echo $base_url ?>asset/js/timepicker.js" ></script>
<!-- Data Table -->
<!--<script src="--><?php //echo $base_url; ?><!--asset/js/plugins/metisMenu/metisMenu.min.js" type="text/javascript"></script>-->
<script src="<?php echo $base_url; ?>asset/js/plugins/dataTables/jquery.dataTables.js" type="text/javascript"></script>
<script src="<?php echo $base_url; ?>asset/js/plugins/dataTables/dataTables.bootstrap.js" type="text/javascript"></script>
<script src="<?php echo $base_url; ?>asset/js/chartjs/Chart.min.js" type="text/javascript"></script>
<script src="<?php echo $base_url; ?>asset/js/chartjs/dashboard.js" type="text/javascript"></script>


    <script>
    $(document).ready(function() {
        $('#dataTables-example').dataTable();
    });
    </script>




</body>
</html>
