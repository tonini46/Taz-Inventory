@section('content')

	<div class="container top20">
	<div class="row thumbnail">
		<div class="col-md-12">
			<h2>
				{{ $estimate->name }} 
			</h2>
			<hr>
			
			<div class="table-responsive">
				<table class="table table-striped">
					<tbody>
						
						<tr>
							<td class="col-md-2">{{ trans('invoice.status') }}</td>
							<td class="col-md-10">
								@if ($estimate->status == 0)
									<span class="label label-overdue">{{ trans('invoice.unapproved') }}</label>
								@else
									<span class="label label-paid">{{ trans('invoice.approved') }}</label>	
								@endif							
							</td>
						</tr>	

						<tr>
							<td class="col-md-2">{{ trans('invoice.estimate') }}</td>
							<td class="col-md-10">{{ $estimate->estimate }}</td>
						</tr>
						
						<tr>
							<td class="col-md-2">{{ trans('invoice.reference') }}</td>
							<td class="col-md-10">{{ $estimate->reference }}</td>
						</tr>
						
						<tr>
							<td class="col-md-2">{{ trans('invoice.estimate_date') }}</td>
							<td class="col-md-10">{{ $estimate->estimate_date }}</td>
						</tr>

						<tr>
							<td class="col-md-2">{{ trans('invoice.expiry_date') }}</td>
							<td class="col-md-10">{{ $estimate->expiry_date }}</td>
						</tr>						
					<tbody>
				</table>
			</div>
			
			<h3>{{ trans('invoice.description') }}</h3>
			<p>
				{{ $estimate->description }}
			</p>			
			
			<h3>{{ trans('invoice.terms_conditions') }}</h3>
			<p>
				{{ $estimate->terms }}
			</p>
		</div>
		
		
		<div class="col-md-12 top20">
			
			@if ($estimateProducts)
		
				<div class="table-responsive">
				<table class="table table-striped">
				<thead>
					<tr>
						<th>{{ trans('invoice.crt') }}.</th>
						<th>{{ trans('invoice.item') }}</th>
						<th class="small">{{ trans('invoice.qty') }}</th>
						<th class="small">{{ trans('invoice.unit_price') }}</th>
						<th class="small">{{ trans('invoice.tax_rate') }}</th>
						<th class="small">{{ trans('invoice.discount') }}</th>
						<th class="small">{{ trans('invoice.amount') }}</th>
					</tr>
				</thead>
				
				<tbody>
					<?php $subTotalItems 	= 0;?>
					<?php $taxItems 		= 0;?>
					<?php $discountItems	= 0;?>
					<?php $estimateDiscount	= 0;?>
					
					@foreach ($estimateProducts as $crt => $v)
					
						<tr>
							<td>
								{{ $crt + 1 }}
							</td>
							
							<td>
								{{ $v->name }}
							</td>
							
							<td class="small">
								{{ $v->quantity }}
							</td>
							
							<td class="small">
								{{ $estimate->position == 1 ? $estimate->currency : '' }} {{ $v->price }} {{ $estimate->position == 2 ? $estimate->currency : '' }}
							</td>
							
							<td class="small">
								{{ $v->tax }} %
							</td>
							
							<td class="small">
								- {{ $estimate->position == 1 ? $estimate->currency : '' }} {{ number_format($v->discount_value, 2, '.', '') }} {{ $estimate->position == 2 ? $estimate->currency : '' }} 
							</td>
							
							<td class="small">
								{{ $estimate->position == 1 ? $estimate->currency : '' }} {{ $v->amount }} {{ $estimate->position == 2 ? $estimate->currency : '' }}
							</td>							
						</tr>
						
						@if ($v->description)
						<tr>
							<td colspan="7">
								{{ $v->description }}
							</td>
						</tr>
						@endif
						
						<?php $subTotalItems 	+= $v->quantity * $v->price;?>
						<?php $taxItems 		+= ($v->quantity * $v->price) * ($v->tax / 100);?>							
						<?php $discountItems 	+= $v->discount_value;?>		
						
					@endforeach
					
					<?php if ($estimate->type == 1) { ?>
						<?php $estimateDiscount	= $estimate->discount;?>
					<?php } ?>
					
					<?php if ($estimate->type == 2) { ?>
						<?php $estimateDiscount	= ($subTotalItems + $taxItems - $discountItems) * ($estimate->discount / 100); ?>
					<?php } ?>	
				</tbody>	
				
				<tfoot>
					<tr class="bg-white">
						<td colspan="4" class="vcenter text-center">
							{{ trans('invoice.invoice_text_01') }}
						</td>
						
						<td colspan="3" class="total">
							<div class="form-group top10">{{ trans('invoice.subtotal') }}: 
								{{ $estimate->position == 1 ? $estimate->currency : '' }} {{ number_format($subTotalItems, 2, '.', '') }} {{ $estimate->position == 2 ? $estimate->currency : '' }} 
							</div>
							
							<div class="form-group">{{ trans('invoice.tax') }}: 
								{{ $estimate->position == 1 ? $estimate->currency : '' }} {{ number_format($taxItems, 2, '.', '') }} {{ $estimate->position == 2 ? $estimate->currency : '' }}
							</div>

							@if ( $discountItems != 0 )
								<div class="form-group">{{ trans('invoice.discount') }}: 
									- {{ $estimate->position == 1 ? $estimate->currency : '' }} {{ number_format($discountItems, 2, '.', '') }} {{ $estimate->position == 2 ? $estimate->currency : '' }}
								</div>
							@endif
							
							@if ( $estimateDiscount != 0 )
								<div class="form-group">{{ trans('invoice.invoice_discount') }}: 
									- {{ $estimate->position == 1 ? $estimate->currency : '' }} {{ number_format($estimateDiscount, 2, '.', '') }} {{ $estimate->position == 2 ? $estimate->currency : '' }}
								</div>
							@endif								
							
							<h4 class="form-group">{{ trans('invoice.total') }}: 
								{{ $estimate->position == 1 ? $estimate->currency : '' }} {{ number_format($estimate->amount, 2, '.', '') }} {{ $estimate->position == 2 ? $estimate->currency : '' }}
							</h4>
						</td>
					</tr>	
				</tfoot>	
				</table>
				</div>
				
			@else
			
				<div role="alert" class="alert alert-danger top20">
					<strong>{{ trans('invoice.message') }}: </strong> {{ trans('invoice.message_06') }}
				</div>	
				
			@endif	
		</div>			
	</div>
	</div>		
	
	@if (Request::segment(3))

		<div class="container">
		<div class="row">
		
			@if ($estimate->status == 0)
				<a href="{{ URL::to('estimate/' . $estimate->estimateID . '/approve/') }}" class="btn btn-success">
					<i class="fa fa-check"></i> {{ trans('invoice.approve') }}
				</a>	
			@endif
			
		</div>	
		</div>	
	
	@endif
	
	<div class="container">
	<div class="row">	
		<div class="col-md-12">
		
			@if (Request::segment(3))
				@if ($estimate->status == 0)
					<a href="{{ URL::to('estimate/' . $estimate->estimateID . '/approve/') }}" class="btn btn-success">
						<i class="fa fa-check"></i> {{ trans('invoice.approve') }}
					</a>	
				@endif			
			
				<a class="btn solso-pdf" href="{{ URL::to('pdf/received/' . $estimate->estimateID) }}"><i class="fa fa-file-pdf-o"></i> {{ trans('invoice.export_pdf') }}</a>
				<a class="btn solso-excel" href="{{ URL::to('excel/received/' . $estimate->estimateID) }}"><i class="fa fa-file-excel-o"></i> {{ trans('invoice.export_excel') }}</a>				
			@else
				<a class="btn solso-pdf" href="{{ URL::to('pdf/' . $estimate->estimateID) }}"><i class="fa fa-file-pdf-o"></i> {{ trans('invoice.export_pdf') }}</a>
				<a class="btn solso-excel" href="{{ URL::to('excel/' . $estimate->estimateID) }}"><i class="fa fa-file-excel-o"></i> {{ trans('invoice.export_excel') }}</a>				
			
				<button class="btn solso-email solsoConfirm" data-toggle="modal" data-target="#solsoSendEmail" data-url="{{ URL::to('email/' . $estimate->estimateID) }}">
					<i class="fa fa-envelope"></i> {{ trans('invoice.email_to_client') }}
				</button>					
			@endif	

		</div>
	</div>	
	</div>	
	
	@include('_modals/email')
@stop