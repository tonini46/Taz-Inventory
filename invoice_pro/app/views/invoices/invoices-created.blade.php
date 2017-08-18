<div class="table-responsive">
	<table class="table table-striped solsoTable">
		<thead>
			<tr>
				<th>{{ trans('invoice.crt') }}.</th>
				<th class="col-md-1">{{ trans('invoice.number') }}</th>
				<th>{{ trans('invoice.client') }}</th>
				<th class="col-md-1 text-right">{{ trans('invoice.amount') }}</th>
				<th class="col-md-1 text-right">{{ trans('invoice.paid') }}</th>
				<th class="col-md-1 text-right">{{ trans('invoice.balance') }}</th>
				<th class="col-md-1 text-center">{{ trans('invoice.due_date') }}</th>
				<th class="small">{{ trans('invoice.status') }}</th>
				<th class="xs-small">{{ trans('invoice.action') }}</th>
				<th class="xs-small">{{ trans('invoice.action') }}</th>
				<th class="xs-small">{{ trans('invoice.action') }}</th>
				<th class="xs-small">{{ trans('invoice.action') }}</th>
				<th class="xs-small">{{ trans('invoice.action') }}</th>
				<th class="small">{{ trans('invoice.action') }}</th>
				<th class="small">{{ trans('invoice.action') }}</th>
				<th class="small">{{ trans('invoice.action') }}</th>
			</tr>
		</thead>
		
		<tbody>
		
		@foreach ($invoices as $crt => $v)
		
			<tr>
				<td>
					{{ $crt+1 }}
				</td>

				<td>
					{{ isset($invoiceSettings->code) ? $invoiceSettings->code : '' }} {{ $v->number }}
				</td>
				
				<td>
					{{ $v->client }}
				</td>						
				
				<td class="text-right">
					{{ $v->position == 1 ? $v->currency : '' }} {{ $v->amount }} {{ $v->position == 2 ? $v->currency : '' }} 
				</td>					
				
				<td class="text-right">
					{{ $v->position == 1 ? $v->currency : '' }} {{ $v->paid }} {{ $v->position == 2 ? $v->currency : '' }}
				</td>						
				
				<td class="text-right">
					{{ $v->position == 1 ? $v->currency : '' }} 
					
					@if ( $v->status == 'paid' )
						0
					@else
						- {{ round($v->amount, 2) - round($v->paid, 2) }}
					@endif
					
					{{ $v->position == 2 ? $v->currency : '' }}
				</td>						
				
				<td class="text-center">
					{{ $v->due_date }}
				</td>	
				
				<td>
					<span class="label label-{{ str_replace(' ', '-', $v->status) }} ">
						{{ trans('invoice.' . str_replace(' ', '_', $v->status)) }}
					</span>
				</td>						

				<td>
					<button class="btn btn-default solsoConfirm" data-toggle="modal" 
					title="{{ trans('invoice.quick_action') }}" data-popover="popover" data-placement="top" data-content="{{ trans('invoice.change_status') }}"
					data-target="#solsoChangeStatus" data-url="{{ URL::to('invoice/edit-status/' . $v->id) }}">
						<i class="fa fa-edit"></i>
					</button>	
				</td>						
				
				<td>
					<button class="btn btn-default solsoConfirm" data-toggle="modal" 
					title="{{ trans('invoice.quick_action') }}" data-popover="popover" data-placement="top" data-content="{{ trans('invoice.change_due_date') }}"
					data-target="#solsoChangeDueDate" data-url="{{ URL::to('invoice/edit-due-date/' . $v->id) }}">
						<i class="fa fa-calendar"></i>
					</button>	
				</td>
				
				<td>
					@if ( $v->status != 'paid' && $v->status != 'cancelled'  )
						<button class="btn btn-default solsoConfirm" data-toggle="modal" 
						title="{{ trans('invoice.quick_action') }}" data-popover="popover" data-placement="top" data-content="{{ trans('invoice.add_payment') }}"
						data-target="#solsoAddPayment" data-url="{{ URL::to('invoice/add-payment/' . $v->id) }}">
							<i class="fa fa-plus"></i>
						</button>
					@else
						<button class="btn btn-default disabled">
							<i class="fa fa-ban"></i>
						</button>
					@endif								
				</td>						

				<td>		
					<div class="dropdown">
						<button class="btn solso-pdf dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-expanded="true">
							{{ trans('invoice.export') }}
							<span class="caret"></span>
						</button>
					
						<ul class="dropdown-menu dropdown-menu-right" role="menu" aria-labelledby="dropdownMenu1">
							<li role="presentation">
								<a role="menuitem" tabindex="-1" href="{{ URL::to('pdf/' . $v->id) }}">
									{{ trans('invoice.export_pdf') }}
								</a>
							</li>
							
							<li role="presentation">
								<a role="menuitem" tabindex="-1" href="{{ URL::to('excel/' . $v->id) }}">
									{{ trans('invoice.export_excel') }}
								</a>
							</li>
						</ul>
					</div>				
				</td>				
				
				<td>		
					<button class="btn btn-default solsoConfirm" data-toggle="modal" data-target="#solsoSendEmail" data-url="{{ URL::to('email/' . $v->id) }}" 
					title="{{ trans('invoice.quick_action') }}" data-popover="popover" data-placement="top" data-content="{{ trans('invoice.email_to_client') }}">
						<i class="fa fa-envelope"></i>
					</button>		
				</td>						

				<td>		
					<a class="btn btn-info" href="{{ URL::to('invoice/' . $v->id) }}">
						<i class="fa fa-eye"></i> {{ trans('invoice.show') }}
					</a>
				</td>						

				<td>							
					<a class="btn btn-primary" href="{{ URL::to('invoice/' . $v->id . '/edit') }}">
						<i class="fa fa-edit"></i> {{ trans('invoice.edit') }}
					</a>
				</td>						

				<td>							
					<button class="btn btn-danger solsoConfirm" data-toggle="modal" data-target="#solsoDeleteModal" data-url="{{ URL::to('invoice/' . $v->id) }}">
						<i class="fa fa-trash"></i> {{ trans('invoice.delete') }}
					</button>		
				</td>
			</tr>
			
		@endforeach
		
		</tbody>
	</table>	
</div>