@section('content')

	{{ Form::open(array('url' => 'login', 'role' => 'form', 'class' => 'solsoForm')) }}

		<div class="col-md-12 top20">
			<div class="form-group">
				<label for="create-email">{{ trans('invoice.email') }}</label>
				<input type="email" name="create-email" class="form-control required" id="create_email" autocomplete="off" value="{{ Input::old('create-email') }}">
				
				<?php echo $errors->first('create-email', '<p class="error">:messages</p>');?>
			</div>	

			<div class="form-group">
				<label for="repeat-email">{{ trans('invoice.repeat_email') }}</label>
				<input type="email" name="repeat-email" class="form-control required" autocomplete="off" value="{{ Input::old('repeat-email') }}" data-parsley-equalto="#create_email">
				
				<?php echo $errors->first('repeat-email', '<p class="error">:messages</p>');?>
			</div>				
			
			<div class="form-group">
				<label for="create-password">{{ trans('invoice.password') }}</label>
				<input type="password" name="create-password" class="form-control required" autocomplete="off" value="{{ Input::old('create-password') }}" data-parsley-minlength="6">
				
				<?php echo $errors->first('create-password', '<p class="error">:messages</p>');?>
			</div>	
		
			<div class="form-group">
				<button type="submit" class="btn btn-lg btn-block create-account"><i class="fa fa-user"></i> {{ trans('invoice.create_new_account') }}</button>	
			</div>			
		</div>			
		
	{{ Form::close() }}
	
@stop