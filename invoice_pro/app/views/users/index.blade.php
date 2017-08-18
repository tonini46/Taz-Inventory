@section('content')

	<div class="col-md-12 col-lg-12">
		<h1><i class="fa fa-users"></i> {{ trans('invoice.users') }}</h1>
	</div>		
	
	<div class="col-md-12 col-lg-12 top40">
		<h3>{{ trans('invoice.users') }}</h3>

		<div class="table-responsive">
			<table class="table solsoTable">
				<thead>
					<tr>
						<th>{{ trans('invoice.crt') }}</th>
						<th>{{ trans('invoice.email') }}</th>
						<th>{{ trans('invoice.type') }}</th>						
						<th class="col-md-2">{{ trans('invoice.created_at') }}</th>
						<th class="small">{{ trans('invoice.action') }}</th>
						<th class="small">{{ trans('invoice.action') }}</th>
					</tr>
				</thead>
				
				<tbody>
				
				@foreach ($users as $crt => $v)
				
					<tr>
						<td>
							{{ $crt+1 }}
						</td>
						
						<td>
							{{ $v->email }}
						</td>						
						
						<td>
							@if ($v->role_id == '2')
								{{ trans('invoice.user') }}
							@endif
						
							@if ($v->role_id == '3')
								{{ trans('invoice.client') }}
							@endif						
						</td>

						<td>
							{{ $v->created_at }}
						</td>							
						
						<td>							
							<a class="btn solso-email" href="{{ URL::to('user/' . $v->id . '/edit') }}">
								<i class="fa fa-key"></i> {{ trans('invoice.reset_password') }}
							</a>
						</td>						
						
						<td>		
							@if ($v->status == 0)
								{{ Form::open(array('url' => 'admin/' . $v->id, 'role' => 'form', 'method' => 'PUT', 'class' => 'solsoForm')) }}
									<button type="submit" class="btn solso-pdf"><i class="fa fa-check"></i> {{ trans('invoice.approve') }}</button>
								{{ Form::close() }}
							@elseif ($v->status == 1)
								<a  class="btn btn-warning solsoConfirm" data-toggle="modal" data-target="#solsoBanAccount" data-url="{{ URL::to('admin/' . $v->id) }}"><i class="fa fa-ban"></i> {{ trans('invoice.ban') }}</a>	
							@else
								{{ Form::open(array('url' => 'admin/' . $v->id, 'role' => 'form', 'method' => 'PUT', 'class' => 'solsoForm')) }}
									<button type="submit" class="btn btn-success"><i class="fa fa-check"></i> {{ trans('invoice.remove_ban') }}</button>
								{{ Form::close() }}	
							@endif	
						</td>
					</tr>
					
				@endforeach
				
				</tbody>
			</table>
		</div>
	</div>
	
	@include('_modals/ban')
	
@stop