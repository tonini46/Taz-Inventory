@section('content')

	<div class="col-md-12">
		<h1><i class="fa fa-plus"></i> {{ trans('invoice.new_message') }} </h1>
	</div>	

	{{ Form::open(array('url' => 'message', 'role' => 'form', 'class' => 'solsoForm')) }}
		
		<div class="col-md-12 col-lg-6">
			<div class="form-group">
				<label for="client">{{ trans('invoice.client') }}</label>
				<select name="client" class="form-control required solsoSelect2">
					<option value="" selected>choose</option>
					
					@foreach ($clients as $v)
						<option value="{{ $v->userID }}"> {{ $v->name }} </option>
					@endforeach			
					
				</select>
				
				<?php echo $errors->first('client', '<p class="error">:messages</p>');?>
			</div>
			
			<div class="form-group">
				<label for="title"> {{ trans('invoice.title') }} </label>
				<input type="text" name="title" class="form-control required" autocomplete="off" value="{{ Input::old('title') }}">

				<?php echo $errors->first('title', '<p class="error">:messages</p>');?>
			</div>		
			
			<div class="form-group">
				<label for="content"> {{ trans('invoice.message') }} </label>
				<textarea name="content" class="form-control solsoSimplyEditor" rows="7" autocomplete="off"></textarea>
				
				<?php echo $errors->first('content', '<p class="error">:messages</p>');?>
			</div>	
		</div>	
		
		<div class="form-group col-md-12">
			<button type="submit" class="btn btn-success btn-lg"><i class="fa fa-share"></i> {{ trans('invoice.send') }} </button>	
		</div>
		
	{{ Form::close() }}
	
@stop