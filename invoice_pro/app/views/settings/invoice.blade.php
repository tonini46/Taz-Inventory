<div class="col-md-12 col-lg-8">
	<h3>{{ trans('invoice.invoice_start_number') }}</h3>

	<div class="row">
	<div class="col-md-4">		
	{{ Form::open(array('url' => 'invoice/number', 'role' => 'form', 'class' => 'solsoForm')) }}

		<label for="value"> {{ trans('invoice.new_value') }}</label>
		<div class="input-group">
			<input type="text" name="value" class="form-control required" autocomplete="off" value="{{ isset($invoiceSettings->number) ? $invoiceSettings->number : '' }}" data-parsley-errors-container=".createNumber">

			<span class="input-group-btn">
				<button type="submit" class="btn btn-success"><i class="fa fa-save"></i> {{ trans('invoice.save') }}</button>	
			</span>	
		</div>
		
		<div class="createNumber"></div>
		<?php echo $errors->first('value', '<p class="error">:messages</p>');?>
		
	{{ Form::close() }}
	</div>
	</div>

	<h3 class="top20">{{ trans('invoice.invoice_code') }}</h3>
	<div class="row">
	<div class="col-md-4">		
	{{ Form::open(array('url' => 'invoice/code', 'role' => 'form', 'class' => 'solsoForm')) }}

		<label for="value">{{ trans('invoice.new_value') }}</label>
		<div class="input-group">
			<input type="text" name="value" class="form-control required" autocomplete="off" value="{{ isset($invoiceSettings->code) ? $invoiceSettings->code : '' }}" data-parsley-errors-container=".createCode">

			<span class="input-group-btn">
				<button type="submit" class="btn btn-success"><i class="fa fa-save"></i> {{ trans('invoice.save') }}</button>	
			</span>	
		</div>
		
		<div class="createCode"></div>
		<?php echo $errors->first('value', '<p class="error">:messages</p>');?>
		
	{{ Form::close() }}
	</div>
	</div>	
	
	<h3 class="top20">{{ trans('invoice.invoice_personal_title') }}</h3>
	<div class="row">
	<div class="col-md-8">		
	{{ Form::open(array('url' => 'invoice/text', 'role' => 'form', 'class' => 'solsoForm')) }}

		<div class="form-group">
			<label for="description" class="lowercase">{{ trans('invoice.invoice_personal_description') }}</label>
			<textarea name="description" class="form-control required solsoSimplyEditor"  rows="7" autocomplete="off">{{ isset($invoiceSettings->text) ? $invoiceSettings->text : '' }}</textarea>
		</div>	

		<?php echo $errors->first('description', '<p class="error">:messages</p>');?>
		
		<button type="submit" class="btn btn-success"><i class="fa fa-save"></i> {{ trans('invoice.save') }}</button>	
	{{ Form::close() }}
	</div>
	</div>	
</div>