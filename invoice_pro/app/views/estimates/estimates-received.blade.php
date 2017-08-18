<div class="table-responsive">
	<table class="table solsoTable">
		<thead>
			<tr>
				<th>{{ trans('invoice.crt') }}.</th>
				<th>{{ trans('invoice.from') }}</th>
				<th>{{ trans('invoice.estimate') }}</th>
				<th>{{ trans('invoice.reference') }}</th>
				<th>{{ trans('invoice.amount') }}</th>
				<th>{{ trans('invoice.estimate_date') }}</th>
				<th>{{ trans('invoice.expiry_date') }}</th>
				<th>{{ trans('invoice.created_at') }}</th>
				<th class="small">{{ trans('invoice.status') }}</th>
				<th class="small">{{ trans('invoice.action') }}</th>
			</tr>
		</thead>
		
		<tbody>
			@foreach ($estimatesReceived as $crt => $v)
			
				<tr>
					<td>
						{{ $crt+1 }}
					</td>

					<td>
						{{ $v->name }}
					</td>
					
					<td>
						{{ $v->estimate }}
					</td>	
					
					<td>
						{{ $v->reference }}
					</td>						

					<td>
						{{ $v->position == 1 ? $v->currency : '' }} {{ $v->amount }} {{ $v->position == 2 ? $v->currency : '' }} 
					</td>	
					
					<td>
						{{ $v->estimate_date }}
					</td>					
					
					<td>
						{{ $v->expiry_date }}
					</td>	

					<td>
						{{ $v->created_at }}
					</td>		

					<td>
						@if ($v->status == 1)
							<span class="label label-paid">{{ trans('invoice.approved') }}</label>
						@else
							<span class="label label-overdue">{{ trans('invoice.unapproved') }}</label>
						@endif
					</td>						
					
					<td>
						<a class="btn btn-info" href="{{ URL::to('estimate/received/' . $v->id) }}"><i class="fa fa-eye"></i> {{ trans('invoice.show') }}</a>
					</td>
				</tr>
				
			@endforeach
		
		</tbody>
	</table>	
</div>