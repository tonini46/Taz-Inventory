<ul>
	<li>
		<a href="<?php echo URL::to('dashboard');?>" <?php if ( Request::segment(1) == 'dashboard' ) { ?> class="active" <?php } ?>>
			<i class="fa fa-home"></i> <span>{{ trans('invoice.dashboard') }}</span>
		</a>
	</li>
		
	@if (Auth::user()->role_id == 2)
		<li>
			<a href="<?php echo URL::to('client');?>" <?php if ( Request::segment(1) == 'client' ) { ?> class="active" <?php } ?>>
				<i class="fa fa-users"></i> <span>{{ trans('invoice.clients') }}</span>
			</a>
		</li>

		<li>
			<a href="<?php echo URL::to('product');?>" <?php if ( Request::segment(1) == 'product' ) { ?> class="active" <?php } ?>>
				<i class="fa fa-puzzle-piece"></i> <span>{{ trans('invoice.products') }}</span>
			</a>
		</li>
	
		<li>
			<a href="<?php echo URL::to('estimate');?>" <?php if ( Request::segment(1) == 'estimate' ) { ?> class="active" <?php } ?>>
				<i class="fa fa-file"></i> <span>{{ trans('invoice.estimates') }}</span>
			</a>
		</li>
	
		<li>
			
			<a href="<?php echo URL::to('invoice');?>" <?php if ( Request::segment(1) == 'invoice' ) { ?> class="active" <?php } ?>>
				<span class="badge">{{ $newInvoicesReceived }} {{ trans('invoice.new') }}</span>	
				<i class="fa fa-file-pdf-o"></i> <span>{{ trans('invoice.invoices') }}</span>
			</a>
		</li>	
		
		<li>
			<a href="<?php echo URL::to('message');?>" <?php if ( Request::segment(1) == 'message' ) { ?> class="active" <?php } ?>>
				<span class="badge">{{ $newMessagesReceived }} {{ trans('invoice.new') }}</span>	
				<i class="fa fa-weixin"></i> <span>{{ trans('invoice.messages') }}</span>
			</a>
		</li>
	
		<li>
			<a href="<?php echo URL::to('report');?>" <?php if ( Request::segment(1) == 'report' ) { ?> class="active" <?php } ?>>
				<i class="fa fa-line-chart"></i> <span>{{ trans('invoice.reports') }}</span>
			</a>
		</li>		
	@endif	
	
	@if (Auth::user()->role_id == 3)
		<li>
			<a href="<?php echo URL::to('estimate');?>" <?php if ( Request::segment(1) == 'estimate' ) { ?> class="active" <?php } ?>>
				<i class="fa fa-file"></i> <span>{{ trans('invoice.estimates') }}</span>
			</a>
		</li>
	
		<li>
			<a href="<?php echo URL::to('message');?>" <?php if ( Request::segment(1) == 'message' ) { ?> class="active" <?php } ?>>
				<span class="badge">{{ $newMessagesReceived }} {{ trans('invoice.new') }}</span>	
				<i class="fa fa-weixin"></i> <span>{{ trans('invoice.messages') }}</span>
			</a>
		</li>	
	@endif	
	
	<li>
		<a href="<?php echo URL::to('setting');?>" <?php if ( Request::segment(1) == 'setting' ) { ?> class="active" <?php } ?>>
			<i class="fa fa-cogs"></i> <span>{{ trans('invoice.settings') }}</span>
		</a>
	</li>	
	
	<li>
		<a href="<?php echo URL::to('logout');?>">
			<i class="fa fa-sign-out"></i> <span>{{ trans('invoice.logout') }}</span>
		</a>
	</li>	
</ul>