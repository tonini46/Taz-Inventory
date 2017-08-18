@section('content')

	<div class="col-md-12 col-lg-12">
		<h1><i class="fa fa-edit"></i> {{ trans('invoice.edit') }}</h1>
	</div>	

	{{ Form::open(array('url' => 'invoice/' . Request::segment(2), 'role' => 'form', 'method' => 'PUT', 'class' => 'solsoForm')) }}

		<div class="col-md-6 col-lg-3">
			<div class="form-group">
				<label for="client">{{ trans('invoice.client') }}</label>
				<select name="client" class="form-control required solsoSelect2">
					<option selected value="{{ Input::old('client') ? Input::old('client') : $client->id }}"> {{ Input::old('client') ? Input::old('client') : $client->name }} </option>	
					<option value="">{{ trans('invoice.choose') }}</option>
					
					@foreach ($clients as $v)
						<option value="{{ $v->id }}"> {{ $v->name }} </option>
					@endforeach			
					
				</select>
				
				<?php echo $errors->first('client', '<p class="error">:messages</p>');?>
			</div>
		</div>
		
		<div class="col-md-3 col-lg-3">		
			<div class="form-group">
				<label for="number">{{ trans('invoice.invoice_number') }}</label>
				<div class="input-group">
					<span class="input-group-addon solso-pre">{{ isset($invoiceCode->code) ? $invoiceCode->code : '' }}</span>				
					<input type="text" name="number" class="form-control required" autocomplete="off" value="{{ Input::old('number') ? Input::old('number') : $invoice->number }}">
				</div>	
				
				<?php echo $errors->first('number', '<p class="error">:messages</p>');?>
			</div>
		</div>		
		<div class="clearfix"></div>
		
		<div class="col-md-3 col-lg-3">
			<div class="form-group">
				<label for="currency">{{ trans('invoice.currency') }}</label>
				<select name="currency" class="form-control required solsoCurrencyEvent">
					<option selected value="{{ Input::old('currency') ? Input::old('currency') : $invoice->currencyID }}"> {{ Input::old('currency') ? Input::old('currency') : $invoice->currency }} </option>
					<option value="">{{ trans('invoice.choose') }}</option>
					
					@foreach ($currencies as $c)
						<option value="{{ $c->id }}"> {{ $c->name }} </option>
					@endforeach					
					
				</select>
				
				<?php echo $errors->first('currency', '<p class="error">:messages</p>');?>
			</div>		
		</div>		
		
		<div class="col-md-3 col-lg-3">		
			<div class="form-group">
				<label for="startDate">{{ trans('invoice.date') }}</label>
				<input type="text" name="startDate" class="form-control datepicker required" autocomplete="off" value="{{ Input::old('startDate') ? Input::old('startDate') : $invoice->start_date }}">
				
				<?php echo $errors->first('startDate', '<p class="error">:messages</p>');?>
			</div>
		</div>	
		
		<div class="col-md-3 col-lg-3">		
			<div class="form-group">
				<label for="endDate">{{ trans('invoice.due_date') }}</label>
				<input type="text" name="endDate" class="form-control datepicker required" autocomplete="off" value="{{ Input::old('endDate') ? Input::old('endDate') : $invoice->due_date }}">
				
				<?php echo $errors->first('endDate', '<p class="error">:messages</p>');?>
			</div>
		</div>			
		<div class="clearfix"></div>
		
		<div class="table-responsive">
		<div class="col-md-12 col-lg-12">	
			<table class="table">
			<thead>
				<tr>
					<th>{{ trans('invoice.crt') }}.</th>
					<th class="col-md-5">{{ trans('invoice.product') }}</th>
					<th class="xs-small">{{ trans('invoice.action') }}</th>	
					<th class="col-md-1">{{ trans('invoice.quantity') }}</th>
					<th class="col-md-1">{{ trans('invoice.price') }}</th>
					<th class="col-md-1">{{ trans('invoice.tax_rate') }}</th>
					<th class="col-md-1">{{ trans('invoice.discount') }}</th>
					<th class="col-md-1">{{ trans('invoice.type') }}</th>
					<th class="col-md-1">{{ trans('invoice.subtotal') }}</th>
					<th class="xs-small">{{ trans('invoice.action') }}</th>
				</tr>	
			</thead>
				
			<tbody class="solsoParent">	
				@foreach ($invoiceProducts as $crt => $p)
				
				<tr {{ $crt == 0 ? 'class="solsoChild"' : '' }}>
					<td class="crt">
						{{ $crt + 1 }}
					</td>
						
					<td>
						<select name="products[]" class="form-control required solsoSelect2 solsoCloneSelect2">
							<option selected value="{{ Input::old('products[]') ? Input::old('products[]') : $p->product_id }}">
								{{ Input::old('products[]') ? Input::old('products[]') :  substr($p->name, 0, 100) }} {{ strlen($p->name) > 100 ? '...' : '' }}
							</option>
							<option value="">{{ trans('invoice.choose') }}</option>
							
							@foreach ($products as $v)
								<option value="{{ $v->id }}"> {{ substr($v->name, 0, 100) }} {{ strlen($v->name) > 100 ? '...' : '' }} </option>
							@endforeach			
							
						</select>				
					</td>
						
					<td>
						<button type="button" class="btn btn-primary solsoShowModal" data-toggle="modal" data-target="#solsoCreateProduct" data-href="{{ URL::to('product/create') }}">
							<i class="fa fa-plus"></i> {{ trans('invoice.new_product') }}
						</button>
					</td>						
						
					<td>
						<input type="text" name="qty[]" class="form-control required solsoEvent" autocomplete="off" value="{{ $p->quantity }}">
					</td>
					
					<td>
						<input type="text" name="price[]" class="form-control required solsoEvent" autocomplete="off" value="{{ $p->price }}">
					</td>
					
					<td>
						<select name="taxes[]" class="form-control required solsoEvent">
							<option selected value="{{ Input::old('taxes[]') ? Input::old('taxes[]') : $p->tax }}"> {{ Input::old('taxes[]') ? Input::old('taxes[]') : $p->tax }} </option>
							<option value="">{{ trans('invoice.choose') }}</option>
							
							@foreach ($taxes as $v)
								<option value="{{ $v->value }}"> {{ $v->value }} %</option>
							@endforeach			
							
						</select>					
					</td>
					
					<td class="no-right-padding">
						<input type="text" name="discount[]" class="form-control" autocomplete="off" value="{{ $p->discount }}">
					</td>	
				
					<td class="no-left-padding">
						<select name="discountType[]" class="form-control solsoEvent">
						
							@if ($p->discount_type == 0)
								<option value="">{{ trans('invoice.choose') }}</option>
							@else
							<option selected value="{{ Input::old('discountType[]') ? Input::old('discountType[]') : $p->discount_type }}">
								{{ Input::old('discountType[]') ? Input::old('discountType[]') : $p->discount_type == 1 ? trans('invoice.amount') : '%' }} 
							</option>
							@endif	
							
							<option value="1">{{ trans('invoice.amount') }}</option>
							<option value="2">%</option>
						</select>
					</td>

					<td>
						<h4 class="pull-right">
							<span class="solsoSubTotal">{{ $p->amount }}</span>
							<span class="solsoCurrency">{{ $invoice->currency }}</span>
						</h4>	
					</td>						
					
					<td>		
						<button class="btn btn-danger removeClone {{ $crt == 0 ? 'disabled' : '' }}" data-id="{{ $p->id }}"><i class="fa fa-minus"></i></button>		
					</td>						
				</tr>
					
				@endforeach			
			
			</tbody>
			
			<tfoot>
				<tr>
					<td colspan="5">
						<div class="col-md-12 col-lg-6 form-inline">
							<label for="end" class="show">{{ trans('invoice.invoice_discount') }}</label>
							<input type="text" name="invoiceDiscount" class="form-control" autocomplete="off" value="{{ $invoice->discount }}">
							
							<select name="invoiceDiscountType" class="form-control solsoEvent">
							
								@if ($invoice->type == 0)
									<option value="">choose</option>
								@else							
								<option selected value="{{ Input::old('invoiceDiscountType[]') ? Input::old('invoiceDiscountType[]') : $invoice->type }}">
									{{ Input::old('invoiceDiscountType[]') ? Input::old('invoiceDiscountType[]') : $invoice->type == 1 ? trans('invoice.amount') : '%' }} 
								</option>
								@endif
								
								<option value="1">{{ trans('invoice.amount') }}</option>
								<option value="2">%</option>
							</select>							
						</div>						
					</td>
					
					<td colspan="2">
						<h3 class="pull-right top10">{{ trans('invoice.total') }}</h3>
					</td>
					
					<td colspan="2">
						<h3 class="top10">
							<span class="solsoTotal">{{ $invoice->amount }}</span>
							<span class="solsoCurrency">{{ $invoice->currency }}</span>
						</h3>
					</td>
				</tr>
			</tfoot>
			</table>
		</div>
		</div>

		<div class="form-group col-md-12 top20 text-center">
			<button type="button" class="btn btn-primary btn-lg" id="createClone"><i class="fa fa-plus"></i> {{ trans('invoice.add_new_product') }}</button>
		</div>

		<div class="col-md-12">
			<div class="form-group">
				<label for="description">{{ trans('invoice.invoice_extra_information') }}</label>
				<textarea name="description" class="form-control"  rows="7" autocomplete="off">{{ Input::old('description') ? Input::old('description') : $invoice->invoiceDescription }}</textarea>
			</div>	
		</div>				
	
		<div class="form-group col-md-12">
			<button type="submit" class="btn btn-success btn-lg"><i class="fa fa-save"></i> {{ trans('invoice.save') }}</button>	
		</div>
		
	{{ Form::close() }}
	
	@include('products.create-modal')
	
@stop