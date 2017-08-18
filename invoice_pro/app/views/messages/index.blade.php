@section('content')

	<div class="col-md-12">
		<h1><i class="fa fa-list"></i> {{ trans('invoice.messages') }}</h1>
		
		<a href="message/create" class="btn btn-primary"><i class="fa fa-plus"></i> {{ trans('invoice.create_new_message') }}</a>
	</div>	

	<div class="col-md-12 top40">
		<h3>{{ trans('invoice.received_messages') }}</h3>
		
		<div class="table-responsive">
			<table class="table solsoTable">
				<thead>
					<tr>
						<th>{{ trans('invoice.crt') }}.</th>
						
						@if (Auth::user()->role_id == 2)
							<th class="col-md-2">{{ trans('invoice.client') }}</th>
						@else
							<th class="col-md-2">{{ trans('invoice.from') }}</th>
						@endif
						
						<th class="col-md-3">{{ trans('invoice.title') }}</th>
						<th>{{ trans('invoice.content') }}</th>
						<th class="col-md-1 text-center">{{ trans('invoice.date') }}</th>
						<th class="small">{{ trans('invoice.status') }}</th>
						<th class="small">{{ trans('invoice.action') }}</th>
						<th class="small">{{ trans('invoice.action') }}</th>
					</tr>
				</thead>
				
				<tbody>
				
				@foreach ($received as $crt => $v)
				
					<tr>
						<td>
							{{ $crt+1 }}
						</td>

						<td>
							{{ $v->name }}
						</td>
						
						<td>
							{{ $v->title }}
						</td>	

						<td>
							{{ strip_tags(substr($v->content, 0, 100)) }}
						</td>							
						
						<td class="text-center">
							{{ $v->created_at }}
						</td>				

						<td>
							@if ($v->status == 1)
								
								<span class="label label-paid">{{ trans('invoice.read') }}</label>
								
							@else
								
								<span class="label label-overdue">{{ trans('invoice.unread') }}</label>
						
							@endif
						</td>					

						<td>		
							<a class="btn btn-info" href="{{ URL::to('message/' . $v->id . '/edit') }}"><i class="fa fa-eye"></i> {{ trans('invoice.show') }}</a>
						</td>		

						<td>		
							<a class="btn btn-danger solsoConfirm" data-toggle="modal" data-target="#solsoDeleteModal" data-url="{{ URL::to('message/' . $v->id) }}"><i class="fa fa-trash"></i> {{ trans('invoice.delete') }}</a>		
						</td>
					</tr>
					
				@endforeach
				
				</tbody>
			</table>	
		</div>	
	</div>
	
	<div class="col-md-12 top40">
		<h3>{{ trans('invoice.sent_messages') }}</h3>
		
		<div class="table-responsive">
			<table class="table solsoTable">
				<thead>
					<tr>
						<th>{{ trans('invoice.crt') }}.</th>
						<th class="col-md-2">{{ trans('invoice.name') }}</th>
						<th class="col-md-3">{{ trans('invoice.title') }}</th>
						<th>{{ trans('invoice.content') }}</th>
						<th class="col-md-1 text-center">{{ trans('invoice.date') }}</th>
						<th class="small">{{ trans('invoice.action') }}</th>
						<th class="small">{{ trans('invoice.action') }}</th>
					</tr>
				</thead>
				
				<tbody>
				
				@foreach ($sent as $crt => $v)
				
					<tr>
						<td>
							{{ $crt+1 }}
						</td>

						<td>
							{{ $v->name }}
						</td>
						
						<td>
							{{ $v->title }}
						</td>	

						<td>
							{{ strip_tags(substr($v->content, 0, 100)) }}
						</td>							
						
						<td class="text-center">
							{{ $v->created_at }}
						</td>				

						<td>		
							<a class="btn btn-info" href="{{ URL::to('message/' . $v->id) }}"><i class="fa fa-eye"></i> {{ trans('invoice.show') }}</a>
						</td>		
						
						<td>		
							<a class="btn btn-danger solsoConfirm" data-toggle="modal" data-target="#solsoDeleteModal" data-url="{{ URL::to('message/' . $v->id) }}" data-method="PUT">
								<i class="fa fa-trash"></i> {{ trans('invoice.delete') }}
							</a>
						</td>				
					</tr>
					
				@endforeach
				
				</tbody>
			</table>	
		</div>	
	</div>	
	
	@include('_modals/delete')
	
@stop