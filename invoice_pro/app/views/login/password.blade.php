@section('content')
	
	{{ Form::open(array('url' => 'reset', 'role' => 'form', 'class' => 'solsoForm')) }}
	
		<div class="col-md-12 top20">		
			<div class="form-group">
				<label for="email">{{ trans('invoice.email') }}</label>
				<input type="email" name="email" class="form-control required email" placeholder="email address" autocomplete="off">

				<?php echo $errors->first('email', '<p class="error">:messages</p>');?>
			</div>

			<div class="form-group">
				<button type="submit" class="btn btn-lg btn-block create-account">
					{{ trans('invoice.send_password') }}
				</button>					
			</div>
		</div>
		
	{{ Form::close() }}	
	
@stop