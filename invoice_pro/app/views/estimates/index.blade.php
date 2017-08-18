@section('content')

	@if (Auth::user()->role_id == 2)
		<div class="col-md-12">
			@if ($clients == 0)
			<div role="alert" class="alert alert-warning top20">
				<strong>{{ trans('invoice.message') }}: </strong> {{ trans('invoice.create_at_least_one_client') }}
				<a href="{{ URL::to('client') }}" >{{ trans('invoice.clients') }}</a>
			</div>	
			@endif
		
			@if ($products == 0)
			<div role="alert" class="alert alert-warning top20">
				<strong>{{ trans('invoice.message') }}: </strong> {{ trans('invoice.create_at_least_one_product') }}
				<a href="{{ URL::to('product') }}" >{{ trans('invoice.products') }}</a>
			</div>	
			@endif	
			
			@if ($check['email'] == 0)
				<div role="alert" class="alert alert-warning top20">
					<strong> {{ trans('invoice.message') }}: </strong> {{ trans('invoice.message_01') }} 
					<a href="{{ URL::to('setting') }}" >{{ trans('invoice.settings') }} -> {{ trans('invoice.company') }}</a>
				</div>	
			@endif
			
			@if ($check['tax'] == 0)
				<div role="alert" class="alert alert-warning top20">
					<strong>{{ trans('invoice.message') }}: </strong> {{ trans('invoice.message_03') }} 
					<a href="{{ URL::to('setting') }}" >{{ trans('invoice.settings') }} -> {{ trans('invoice.tax') }}</a>
				</div>	
			@endif

			@if ($check['currency'] == 0)
				<div role="alert" class="alert alert-warning top20">
					<strong>{{ trans('invoice.message') }}: </strong> {{ trans('invoice.message_04') }} 
					<a href="{{ URL::to('setting') }}" >{{ trans('invoice.settings') }} -> {{ trans('invoice.currency') }}</a>
				</div>	
			@endif

			@if ($check['payment'] == 0)
				<div role="alert" class="alert alert-warning top20">
					<strong>{{ trans('invoice.message') }}: </strong> {{ trans('invoice.message_05') }} 
					<a href="{{ URL::to('setting') }}" >{{ trans('invoice.settings') }} -> {{ trans('invoice.payment') }}</a>
				</div>	
			@endif
		</div>
	@endif

	<div class="col-md-12">
		<h1><i class="fa fa-list"></i> {{ trans('invoice.estimates') }}</h1>
		
		@if (Auth::user()->role_id == 2)
			<a href="estimate/create" class="btn btn-primary {{ $clients == 0 || $products == 0 || $check['email'] == 0 || $check['tax'] == 0 || $check['currency'] == 0 || $check['payment'] == 0 ? 'disabled' : ''}}">
				<i class="fa fa-plus"></i> {{ trans('invoice.create_new_estimate') }}
			</a>
		@endif
	</div>	


	<div class="col-md-12 top40">

		@if (Auth::user()->role_id == 2)
			<ul id="solsoTabs" class="nav nav-tabs" role="tablist" id="myTab">
				<li class="active"><a href="#tab1" role="tab" data-toggle="tab">{{ trans('invoice.estimates_created') }}</a></li>
				<li><a href="#tab2" role="tab" data-toggle="tab">{{ trans('invoice.estimates_received') }}</a></li>
			</ul>				
			<div class="tab-content top20">
				<div class="tab-pane active" id="tab1">
					@include('estimates.estimates-created')
				</div>
				
				<div class="tab-pane" id="tab2">
					@include('estimates.estimates-received')	
				</div>
			</div>
		@else
			<h3>{{ trans('invoice.estimates_received') }}</h3>
		
			@include('estimates.estimates-received')
		@endif
		
	</div>
	
	@include('_modals/delete')
	@include('_modals/email')
	
@stop