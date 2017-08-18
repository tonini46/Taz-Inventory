<div class="table-responsive">
	<table class="table solsoTable">
		<thead>
			<tr>
				<th>{{ trans('invoice.crt') }}.</th>
				<th>{{ trans('invoice.client') }}</th>
				<th>{{ trans('invoice.estimate') }}</th>
				<th>{{ trans('invoice.reference') }}</th>
				<th>{{ trans('invoice.amount') }}</th>
				<th>{{ trans('invoice.estimate_date') }}</th>
				<th>{{ trans('invoice.expiry_date') }}</th>
				<th>{{ trans('invoice.created_at') }}</th>
				<th class="small">{{ trans('invoice.status') }}</th>
				<th class="xs-small">{{ trans('invoice.action') }}</th>
				<th class="small">{{ trans('invoice.action') }}</th>
				<th class="small">{{ trans('invoice.action') }}</th>
				<th class="small">{{ trans('invoice.action') }}</th>
			</tr>
		</thead>
		
		<tbody>
			@foreach ($estimates as $crt => $v)
			
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
						<button class="btn btn-default solsoConfirm" data-toggle="modal" data-target="#solsoSendEmail" data-url="{{ URL::to('email/' . $v->id) }}" 
						title="{{ trans('invoice.quick_action') }}" data-popover="popover" data-placement="top" data-content="{{ trans('invoice.email_to_client') }}">
							<i class="fa fa-envelope"></i>
						</button>		
					</td>
					
					<td>
						<a class="btn btn-info" href="{{ URL::to('estimate/' . $v->id) }}"><i class="fa fa-eye"></i> {{ trans('invoice.show') }}</a>
					</td>							

					<td>		
						@if ($v->status != 1)
							<a class="btn btn-primary" href="{{ URL::to('estimate/' . $v->id . '/edit') }}"><i class="fa fa-edit"></i> {{ trans('invoice.edit') }}</a>
						@else
							<a class="btn btn-primary disabled" href=""><i class="fa fa-ban"></i> {{ trans('invoice.edit') }}</a>	
						@endif
					</td>
					
					<td>		
						<a class="btn btn-danger solsoConfirm" data-toggle="modal" data-target="#solsoDeleteModal" data-url="{{ URL::to('estimate/' . $v->id) }}"><i class="fa fa-trash"></i> {{ trans('invoice.delete') }}</a>		
					</td>
				</tr>
				
			@endforeach

		</tbody>
	</table>	
</div>