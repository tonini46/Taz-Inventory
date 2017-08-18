<div class="table-responsive">
	<table class="table table-striped solsoTable">
		<thead>
			<tr>
				<th>{{ trans('invoice.crt') }}.</th>
				<th>{{ trans('invoice.number') }}</th>
				<th>{{ trans('invoice.from') }}</th>
				<th class="text-right">{{ trans('invoice.amount') }}</th>
				<th class="text-right">{{ trans('invoice.paid') }}</th>
				<th class="text-right">{{ trans('invoice.balance') }}</th>
				<th class="text-center">{{ trans('invoice.due_date') }}</th>
				<th class="small">{{ trans('invoice.status') }}</th>
				<th class="small">{{ trans('invoice.action') }}</th>
				<th class="small">{{ trans('invoice.action') }}</th>
			</tr>
		</thead>
		
		<tbody>

			@if ($invoicesReceived)
				@foreach ($invoicesReceived as $crt => $v)
			
				<tr>
					<td>
						{{ $crt+1 }}
					</td>

					<td>
						{{ $v->number }}
					</td>
					
					<td>
						{{ $v->company }}
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
					
					<td class="small">
						<span class="label label-{{ str_replace(' ', '-', $v->status) }} ">
							{{ trans('invoice.' . str_replace(' ', '_', $v->status)) }}
						</span>
					</td>

					<td>		
						<div class="dropdown">
							<button class="btn solso-pdf dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-expanded="true">
								{{ trans('invoice.export') }}
								<span class="caret"></span>
							</button>
						
							<ul class="dropdown-menu dropdown-menu-right" role="menu" aria-labelledby="dropdownMenu1">
								<li role="presentation">
									<a role="menuitem" tabindex="-1" href="{{ URL::to('pdf/received/' . $v->id) }}">
										{{ trans('invoice.export_pdf') }}
									</a>
								</li>
								
								<li role="presentation">
									<a role="menuitem" tabindex="-1" href="{{ URL::to('excel/received/' . $v->id) }}">
										{{ trans('invoice.export_excel') }}
									</a>
								</li>
							</ul>
						</div>
					</td>

					<td class="small">		
						<a class="btn btn-info" href="{{ URL::to('invoice/received/' . $v->id) }}">
							<i class="fa fa-eye"></i> {{ trans('invoice.show') }}
						</a>
					</td>	
				</tr>
		
				@endforeach
			@endif			
		
		</tbody>
	</table>	
</div>