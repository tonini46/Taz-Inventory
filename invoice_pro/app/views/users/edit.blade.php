@section('content')

	<div class="col-md-12">
		<h1><i class="fa fa-users"></i> {{ trans('invoice.edit') }}</h1>
	</div>		
	
	<div class="col-md-6 col-lg-4">
		<h3>{{ trans('invoice.reset_password') }}</h3>
		
		{{ Form::open(array('url' => 'user/' . Request::segment(2), 'role' => 'form', 'method' => 'PUT', 'class' => 'solsoForm')) }}

		<div class="form-group">
			<label for="new-password">{{ trans('invoice.new_password') }}</label>
			<div class="input-group">
				<span class="input-group-addon"><i class="fa fa-lock"></i></span>
				<input type="password" name="new-password" class="form-control required" name="new-password" placeholder="new password" autocomplete="off" 
				data-parsley-minlength="6" data-parsley-errors-container=".group4">
			</div>

			<div class="group4"></div>
			<?php echo $errors->first('new-password', '<p class="error">:messages</p>');?>
		</div>

		<div class="form-group">
			<input type="hidden" name="action" value="reset-password">
			<button type="submit" class="btn btn-success" type="button"><i class="fa fa-save"></i> {{ trans('invoice.save') }}</button>
		</div>	
		
		{{ Form::close() }}
	</div>
	
@stop