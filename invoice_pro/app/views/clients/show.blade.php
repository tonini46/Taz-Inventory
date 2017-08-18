@section('content')

	<div class="container top20">
	<div class="row thumbnail">
		<div class="col-md-12">
			<h1>{{ $client->name }}</h1>
			<hr>
			
			<div class="table-responsive">
				<table class="table table-striped">
				<tbody>
					<tr>
						<td class="col-md-2">{{ trans('invoice.country') }} {{ trans('invoice.province_state') }}</td>
						<td class="col-md-4">{{ $client->country }} {{ $client->state }}</td>
						<td class="col-md-2">{{ trans('invoice.contact') }}</td>
						<td class="col-md-4">{{ $client->contact }}</td>
					</tr>
					
					<tr>
						<td>{{ trans('invoice.city') }}</td>
						<td>{{ $client->city }}</td>
						<td>{{ trans('invoice.phone') }}</td>
						<td>{{ $client->phone }}</td>
					</tr>

					<tr>
						<td>{{ trans('invoice.zip_code') }}</td>
						<td>{{ $client->zip }}</td>
						<td>{{ trans('invoice.email') }}</td>
						<td>{{ $client->email }}</td>
					</tr>

					<tr>
						<td>{{ trans('invoice.address') }}</td>
						<td>{{ $client->address }}</td>
						<td>{{ trans('invoice.website') }}</td>
						<td>{{ $client->website }}</td>
					</tr>
					
					@if ($client->description )
					
						<tr>
							<td colspan="4">{{ trans('invoice.description') }}</td>
						</tr>				
						<tr>
							<td colspan="4">{{ $client->description }}</td>
						</tr>
					
					@endif
					
				</tbody>
				</table>
			</div>
			
			<h2>{{ trans('invoice.client_bills') }}</h2>
			<hr>
	
			<div class="table-responsive">
				<table class="table table-striped solsoTable">
					<thead>
						<tr>
							<th>{{ trans('invoice.crt') }}.</th>
							<th class="col-md-2">{{ trans('invoice.number') }}</th>
							<th class="col-md-2">{{ trans('invoice.amount') }}</th>
							<th class="col-md-2">{{ trans('invoice.paid') }}</th>
							<th class="col-md-2">{{ trans('invoice.balance') }}</th>
							<th class="col-md-2">{{ trans('invoice.due_date') }}</th>
							<th class="col-md-2">{{ trans('invoice.status') }}</th>
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
									{{ $v->number }}
								</td>
								
								<td>
									{{ $v->amount }}
								</td>					

								<td>
									{{ $v->paid }}
								</td>	
								
								<td>
									@if ( $v->status == 'paid' )
										0
									@else
										- {{ $v->amount - $v->paid }}
									@endif
								</td>
								
								<td>
									{{ $v->due_date }}
								</td>	
								
								<td>
									<span class="label label-{{ str_replace(' ', '-', $v->status) }} ">{{ $v->status }}</label>
								</td>						

								<td>		
									<a class="btn btn-info" href="{{ URL::to('invoice/' . $v->id) }}"><i class="fa fa-eye"></i> {{ trans('invoice.show') }}</a>
								</td>						
							</tr>
							
						@endforeach
					
					</tbody>
				</table>	
			</div>
		</div>
	</div>
	</div>
@stop