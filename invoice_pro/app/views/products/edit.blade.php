@section('content')
			
	<div class="col-md-12 col-lg-12">
		<h1><i class="fa fa-edit"></i> {{ trans('invoice.edit') }}</h1>
	</div>		

	{{ Form::open(array('url' => 'product/' . Request::segment(2), 'role' => 'form', 'method' => 'PUT', 'class' => 'solsoForm')) }}

		<div class="col-md-12 col-lg-6">
			<div class="form-group">
				<label for="name">{{ trans('invoice.name') }}</label>
				<input type="text" name="name" class="form-control required" autocomplete="off" value="{{ Input::old('name') ? Input::old('name') : $product->name }}">
				
				<?php echo $errors->first('name', '<p class="error">:messages</p>');?>
			</div>			
		</div>		
		<div class="clearfix"></div>
		
		<div class="col-md-6 col-lg-3">
			<div class="form-group">
				<label for="code">{{ trans('invoice.code') }}</label>
				<input type="text" name="code" class="form-control required" autocomplete="off" value="{{ Input::old('code') ? Input::old('code') : $product->code }}">
				
				<?php echo $errors->first('code', '<p class="error">:messages</p>');?>
			</div>			
		</div>
		
		<div class="col-md-6 col-lg-3">
			<div class="form-group">
				<label for="price">{{ trans('invoice.price') }}</label>
				<input type="text" name="price" class="form-control required" autocomplete="off" value="{{ Input::old('price') ? Input::old('price') : $product->price }}">
				
				<?php echo $errors->first('price', '<p class="error">:messages</p>');?>
			</div>			
		</div>			
		<div class="clearfix"></div>
		
		<div class="col-md-12 col-lg-6">
			<div class="form-group">
				<label for="description">{{ trans('invoice.description') }}</label>
				<textarea name="description" class="form-control" rows="7" autocomplete="off">{{ Input::old('description') ? Input::old('description') : $product->description }}</textarea>
				
				<?php echo $errors->first('description', '<p class="error">:messages</p>');?>
			</div>		
		</div>		
		
		<div class="form-group col-md-12">
			<button type="submit" class="btn btn-success btn-lg"><i class="fa fa-save"></i> {{ trans('invoice.save') }}</button>	
		</div>
		
	{{ Form::close() }}	

@stop