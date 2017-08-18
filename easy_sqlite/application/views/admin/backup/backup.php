<div class="message_box">
<?php
if (isset($success) && strlen($success)) {
echo '<div class="alert alert-info">';
echo '<p>' . $success . '</p>';
echo '</div>';
}
 
if (isset($errors) && strlen($errors)) {
echo '<div class="alert alert-danger">';
echo '<p>' . $errors . '</p>';
echo '</div>';
}
 
if (validation_errors()) {
echo validation_errors('<div class="alert alert-danger">', '</div>');
}
?>
</div>
<?php
$back_url = $this->uri->uri_string();
$key = 'referrer_url_key';
$this->session->set_flashdata($key, $back_url);
?>
<section class="content">
    <div class="row">
        <div class="col-md-12">

            <div class="box box-primary">
            	 <div class="box-header box-header-background with-border">
                    <div class="col-md-offset-3">
                        <h3 class="box-title ">System Backup</h3>
                    </div>
                </div>
<?php
echo form_open($this->uri->uri_string());
?>
<div class="row">

                        <div class="col-md-6 col-sm-12 col-xs-12 col-md-offset-3">

                            <div class="box-body">

<div class="form-group">
<label>Backup Type</label>
<select name="backup_type" class="form-control">
<option value="" selected disabled>Backup Type</option>
<option value="1" <?php echo (isset($success) && strlen($success) ? '' : (set_value('backup_type') == '1' ? 'selected' : '')) ?>>DB Backup</option>
<option value="2" <?php echo (isset($success) && strlen($success) ? '' : (set_value('backup_type') == '2' ? 'selected' : '')) ?>>Site Backup</option>
</select>
</div>
 
<div class="form-group">
<label>File Type</label>
<select name="file_type" class="form-control">
<option value="" selected disabled>File Type</option>
<option value="1" <?php echo (isset($success) && strlen($success) ? '' : (set_value('file_type') == 1 ? 'selected' : '')) ?>>ZIP</option>
<option value="2" <?php echo (isset($success) && strlen($success) ? '' : (set_value('file_type') == 2 ? 'selected' : '')) ?>>GZIP</option>
</select>
</div>

<div class="box-footer">
<button type="submit" id="country_btn" name="backup" value="backup" class="btn bg-navy col-md-offset-3" type="submit">Get Backup
</div>
</div>
</div>
</div>
<?php
echo form_close();
?>
</div>
</div>
</div>
</section>