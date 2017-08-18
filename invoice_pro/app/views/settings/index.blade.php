@section('content')

	<div class="col-md-12">
		<h1><i class="fa fa-cogs"></i> {{ trans('invoice.settings') }}</h1>
	</div>		
	
	<div class="col-md-12">
		<ul id="solsoTabs" class="nav nav-tabs" role="tablist" id="myTab">
			<li class="active">
				<a href="#tab1" role="tab" data-toggle="tab">
					@if (Auth::user()->role_id == 2)
						{{ trans('invoice.my_company') }}
					@endif
					
					@if (Auth::user()->role_id == 3)
						{{ trans('invoice.name') }}
					@endif
				</a></li>
		
			@if (Auth::user()->role_id == 2)

				<li><a href="#tab2" role="tab" data-toggle="tab">{{ trans('invoice.logo') }}</a></li>
				<li><a href="#tab3" role="tab" data-toggle="tab">{{ trans('invoice.invoice') }}</a></li>
				<li><a href="#tab4" role="tab" data-toggle="tab">{{ trans('invoice.invoice_tax') }}</a></li>
				<li><a href="#tab5" role="tab" data-toggle="tab">{{ trans('invoice.currencies') }}</a></li>
				<li><a href="#tab6" role="tab" data-toggle="tab">{{ trans('invoice.payments') }}</a></li>
				<li><a href="#tab7" role="tab" data-toggle="tab">{{ trans('invoice.invitation') }}</a></li>
			
			@endif
			
			<li><a href="#tab8" role="tab" data-toggle="tab">{{ trans('invoice.languages') }}</a></li>
			<li><a href="#tab9" role="tab" data-toggle="tab">{{ trans('invoice.account') }}</a></li>
			<li><a href="#tab10" role="tab" data-toggle="tab">{{ trans('invoice.password') }}</a></li>
			<li><a href="#tab11" role="tab" data-toggle="tab">{{ trans('invoice.application') }}</a></li>
		</ul>
		
		<div class="row tab-content">
		
			<div class="tab-pane active" id="tab1">
				@include('settings.company')
			</div>		
		
			@if (Auth::user()->role_id == 2)
			
				<div class="tab-pane" id="tab2">
					@include('settings.logo')
				</div>	

				<div class="tab-pane" id="tab3">
					@include('settings.invoice')
				</div>

				<div class="tab-pane" id="tab4">
					@include('settings.tax')
				</div>			
				
				<div class="tab-pane" id="tab5">
					@include('settings.currency')
				</div>	

				<div class="tab-pane" id="tab6">
					@include('settings.payment')
				</div>					
				
				<div class="tab-pane" id="tab7">
					@include('settings.invitation')
				</div>				
			
			@endif
			
			<div class="tab-pane" id="tab8">
				@include('settings.language')
			</div>	

			<div class="tab-pane" id="tab9">
				@include('settings.account')
			</div>	

			<div class="tab-pane" id="tab10">
				@include('settings.password')
			</div>	

			<div class="tab-pane" id="tab11">
				@include('settings.user-mode')
			</div>				
		</div>		
	</div>				

	@include('_modals/delete')
		
@stop