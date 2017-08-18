@section('content')

	{{ Form::open(array('url' => 'auth', 'role' => 'form', 'class' => 'solsoForm')) }}
		
		<div class="col-md-12 top20">
			<div class="form-group">
				<label for="email">{{ trans('invoice.email') }}</label>
				<input type="email" name="email" class="form-control required email" placeholder="email address" autocomplete="off">

				<?php echo $errors->first('email', '<p class="error">:messages</p>');?>
			</div>

			<div class="form-group">
				<label for="password">{{ trans('invoice.password') }}</label>
				<input type="password" name="password" class="form-control required" placeholder="password"	data-parsley-minlength="6" autocomplete="off">

				<?php echo $errors->first('password', '<p class="error">:messages</p>');?>
			</div>

			<div class="form-group">
				<button type="submit" class="btn btn-lg btn-block sign-in"><i class="fa fa-sign-in"></i> {{ trans('invoice.sign_in') }}</button>	
			</div>
		</div>
		
	{{ Form::close() }}	
	
	<div class="col-md-12 top20">
		<a href="{{ URL::to('forgot-password') }}" class="btn btn-link btn-lg btn-block forgot"> 
			{{ trans('invoice.forgot_password') }}
		</a>
	</div>	
	
@stop		