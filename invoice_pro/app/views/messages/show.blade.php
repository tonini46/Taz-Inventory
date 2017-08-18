@section('content')

	<div class="clearfix"></div>
	<div class="container top20">
	<div class="row thumbnail">
		<div class="col-md-12">
			<h1>{{ $message->title }}</h1>
			<hr>
			<h3>{{ $message->name }}</h3>
			<h4>{{ trans('invoice.created_at') }} {{ $message->created_at }}</h4>
			
			<p class="top20">
			{{ $message->content }}
			</p>
		</div>
	</div>
	</div>
	
@stop