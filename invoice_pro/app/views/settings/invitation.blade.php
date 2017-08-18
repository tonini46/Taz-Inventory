<div class="col-md-12 col-lg-8">
	<h3>{{ trans('invoice.invitation') }}</h3>

	@if ($newsletter)

		{{ Form::open(array('url' => 'newsletter/' . $newsletter->id, 'role' => 'form', 'method' => 'PUT', 'class' => 'solsoForm')) }}
	
	@else	
	
		{{ Form::open(array('url' => 'newsletter', 'role' => 'form', 'class' => 'solsoForm')) }}
		
	@endif

		<div class="form-group">
			<label for="title">{{ trans('invoice.title') }}</label>
			<input type="text" name="title" class="form-control required" autocomplete="off" value="{{ Input::old('title') ? Input::old('title') : isset($newsletter->title) ? $newsletter->title : '' }}">
			
			<?php echo $errors->first('title', '<p class="error">:messages</p>');?>
		</div>
		
		<div class="form-group">
			<label for="content">{{ trans('invoice.content') }}</label>
			<textarea name="content" class="form-control solsoEditor"  rows="7" autocomplete="off">{{ Input::old('content') ? Input::old('content') :isset($newsletter->content) ? $newsletter->content : '' }}</textarea>
			
			<?php echo $errors->first('content', '<p class="error">:messages</p>');?>
		</div>	
		
		<div class="form-group">
			<button type="submit" class="btn btn-success" type="button"><i class="fa fa-save"></i> {{ trans('invoice.save') }}</button>
		</div>			
		
	{{ Form::close() }}
	
</div>