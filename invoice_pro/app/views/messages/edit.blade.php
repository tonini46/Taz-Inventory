@section('content')
	<div class="container top20">
	<div class="row thumbnail">
		<div class="col-md-12">
			<h1>{{ $message->title }}</h1>
			<hr>
			<h3>{{ trans('invoice.from') }} {{ $message->name }}</h3>
			<h4>{{ trans('invoice.created_at') }} {{ $message->created_at }}</h4>
			
			<p class="top20">
			{{ $message->content }}
			</p>
		</div>
	</div>
	</div>
	
	<div class="container">
	<div class="row">	
		<a class="btn btn-danger solsoConfirm" data-toggle="modal" data-target="#solsoDeleteModal" data-url="{{ URL::to('message/' . $message->id) }}"><i class="fa fa-trash"></i> {{ trans('invoice.delete') }}</a>
		
		<h3>{{ trans('invoice.reply_message') }} </h3>	
		
		{{ Form::open(array('url' => 'message', 'role' => 'form', 'class' => 'solsoForm')) }}
		
			<div class="form-group">
				<label for="title"> {{ trans('invoice.title') }} </label>
				<input type="text" name="title" class="form-control required" autocomplete="off" value="{{ trans('invoice.reply_to') }}: {{ $message->title }}">

				<?php echo $errors->first('title', '<p class="error">:messages</p>');?>
			</div>		
			
			<div class="form-group">
				<label for="content"> {{ trans('invoice.message') }} </label>
				<textarea name="content" class="form-control solsoSimplyEditor" rows="7" autocomplete="off"></textarea>
				
				<?php echo $errors->first('content', '<p class="error">:messages</p>');?>
			</div>	
			
			<div class="form-group">
				<input type="hidden" name="type" value="reply">
				<input type="hidden" name="client" value="{{ $message->from_id }}">
				<button type="submit" class="btn btn-success btn-lg"><i class="fa fa-share"></i> {{ trans('invoice.reply') }} </button>	
			</div>
			
		{{ Form::close() }}

	</div>
	</div>
	
	@include('_modals/delete')
	
@stop