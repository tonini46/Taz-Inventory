@include('_begin')

<div class="col-md-12">
	@if(Session::has('error'))
		<div role="alert" class="alert alert-danger fade in top20 solsoHideAlert">
			<button data-dismiss="alert" class="close" type="button"><span aria-hidden="true">×</span><span class="sr-only">{{ trans('invoice.close') }}</span></button>
			<strong>{{ trans('invoice.message') }}: </strong> {{ Session::get('error') }} !
		</div>		
	@endif		

	@if(Session::has('warning'))
		<div role="alert" class="alert alert-warning fade in top20 solsoHideAlert">
			<button data-dismiss="alert" class="close" type="button"><span aria-hidden="true">×</span><span class="sr-only">{{ trans('invoice.close') }}</span></button>
			<strong>{{ trans('invoice.message') }}: </strong> {{ Session::get('warning') }} !
		</div>		
	@endif	

	@if(Session::has('message'))
		<div role="alert" class="alert alert-info fade in top20 solsoHideAlert">
			<button data-dismiss="alert" class="close" type="button"><span aria-hidden="true">×</span><span class="sr-only">{{ trans('invoice.close') }}</span></button>
			<strong>{{ trans('invoice.message') }}: </strong> {{ Session::get('message') }} !
		</div>		
	@endif		
</div>	
		
<div id="website">
	<div class="jumbotron">
		<div class="container">
		<div class="row">
			<div class="col-md-6">
				<h1 class="text-center"><a href="<?php echo URL::to('');?>">{{ trans('invoice.app_name') }}</a></h1>
				<h2 class="lowercase">{{ trans('invoice.app_text01') }} <br> {{ trans('invoice.app_text02') }}</h2>
				
				@if ( $type == 2 )
					<h3 class="top40 bottom40 text-center lowercase">{{ trans('invoice.over') }} {{ $users }} {{ trans('invoice.app_text03') }}</h3>
					
					<div class="row">
						<div class="col-md-6">
							<a href="<?php echo URL::to('login');?>" class="btn solso-btn-lg sign-in"> {{ trans('invoice.sign_in') }}</a>			
						</div>
						
						<div class="col-md-6">
							<a href="<?php echo URL::to('create-account');?>" class="btn solso-btn-lg create-account"> {{ trans('invoice.create_new_account') }}</a>			
						</div>
					</div>
				@endif
			</div>
			
			<div class="col-md-6">
				@yield('content')
			</div>
		</div>
		</div>
	</div>

	@if ( $type == 2 )
		<div class="container top20">
		<div class="row">
			<div class="col-md-3 thumbnail text-center">					
				<i class="fa fa-users"></i>
				<h3>{{ trans('invoice.unlimited_clients') }}</h3>

				<p>{{ trans('invoice.app_text04') }}</p>
			</div>
			
			<div class="col-md-3 thumbnail text-center">		
				<i class="fa fa-puzzle-piece"></i>
				<h3>{{ trans('invoice.unlimited_products') }}</h3>
				
				<p>{{ trans('invoice.app_text05') }}</p>
			</div>

			<div class="col-md-3 thumbnail text-center">		
				<i class="fa fa-file-pdf-o"></i>
				<h3>{{ trans('invoice.unlimited_invoices') }}</h3>
				
				<p>{{ trans('invoice.app_text06') }}</p>
			</div>
			
			<div class="col-md-3 thumbnail text-center">				
				<i class="fa fa-line-chart"></i>
				<h3>{{ trans('invoice.detailed_reports') }}</h3>
				
				<p>{{ trans('invoice.app_text07') }}</p>
			</div>	
		</div>
		</div>
	@endif
	
	<div class="container">
	<div class="row">
		<h4 class="text-center top20"> {{ trans('invoice.power_by') }}</h4>
	</div>
	</div>
</div>

<script type="text/javascript" src="<?php echo URL::to('public/js/jquery.js');?>"></script>
<script type="text/javascript" src="<?php echo URL::to('public/js/bootstrap.min.js');?>"></script>

<!-- PARSLEY VALIDATION -->
<script type="text/javascript" src="<?php echo URL::to('public/vendor/parsley/parsley.js');?>"></script>
<script>	
	$(".solsoForm").parsley({
		successClass: "has-success",
		errorClass: "has-error",
		classHandler: function (el) {
			return el.$element.closest(".form-group, td");
		}, 
		errorsContainer: function (el) {
			return el.$element.closest(".form-group, td");
		}
	});
	
	/* === CLOSE ALERTS === */
	function solsoAlerts()
	{
		window.setTimeout(function() {
			$(".solsoHideAlert").fadeTo(500, 0).slideUp(500, function(){
				$(this).remove(); 
			});
		}, 5000);		
	}
	
	solsoAlerts();
	/* === END CLOSE ALERTS === */	
</script>	
<!-- END PARSLEY VALIDATION -->
	
</body>
</html>