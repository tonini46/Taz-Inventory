<div class="col-md-12 col-lg-6">
	<h3>{{ trans('invoice.logo') }}</h3>

	@if ( isset($logo->name) )

		<img src="{{ URL::to('public/upload/' . $logo->name) }}" class="img-responsive thumbnail">

		{{ Form::open(array('url' => 'upload/' . $logo->id, 'role' => 'form', 'method' => 'PUT', 'class' => 'solsoForm', 'files' => 'true')) }}
	
	@else	
	
		<div role="alert" class="alert alert-warning fade in top20">
			<strong>{{ trans('invoice.message') }}: </strong> {{ trans('invoice.message_logo') }}
		</div>		
	
		{{ Form::open(array('url' => 'upload', 'role' => 'form', 'class' => 'solsoForm', 'files' => 'true')) }}
		
	@endif

		<div class="form-group">
			<label for="image">{{ trans('invoice.upload_logo') }} => <span class="lowercase">{{ trans('invoice.allowed_file_extensions') }}: 'jpg', 'jpeg', 'gif', 'png', 'bmp'</span></label>
			<input type="file" name="image" class="solsoFileInput required" autocomplete="off" value="{{ Input::old('image') }}">
		</div>

		<?php echo $errors->first('image', '<p class="error">:messages</p>');?>
		
	{{ Form::close() }}
	
</div>