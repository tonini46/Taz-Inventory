@section('content')

	<div class="col-md-12 col-lg-12">
		<h1><i class="fa fa-plus"></i> {{ trans('invoice.edit') }}</h1>
	</div>	
	
	{{ Form::open(array('url' => 'language/' . Request::segment(2), 'role' => 'form', 'method' => 'PUT', 'class' => 'solsoForm')) }}
		
		<div class="col-md-6 col-lg-3">
			<div class="form-group">
				<label for="name">{{ trans('invoice.name') }}</label>
				<input type="text" name="name" class="form-control required" autocomplete="off" value="{{ Input::old('name') ? Input::old('name') : $language->name }}">

				<?php echo $errors->first('name', '<p class="error">:messages</p>');?>
			</div>		
		</div>
		
		<div class="form-group col-md-12">
			<button type="submit" class="btn btn-success btn-lg"><i class="fa fa-save"></i> {{ trans('invoice.save') }}</button>	
		</div>
		
	{{ Form::close() }}
	
@stop
			