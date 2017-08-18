@section('content')

	<div class="col-md-12">
		<h1><i class="fa fa-plus"></i> {{ trans('invoice.new_estimate') }} </h1>
	</div>	

	{{ Form::open(array('url' => 'estimate', 'role' => 'form', 'class' => 'solsoForm')) }}
		
		<div class="col-md-6 col-lg-3">
			<div class="form-group">
				<label for="client_id">{{ trans('invoice.client') }}</label>
				<select name="client_id" class="form-control required solsoSelect2">
					<option value="" selected>{{ trans('invoice.choose') }}</option>
					
					@foreach ($clients as $v)
						<option value="{{ $v->userID }}"> {{ $v->name }} </option>
					@endforeach			
					
				</select>
				
				<?php echo $errors->first('client_id', '<p class="error">:messages</p>');?>
			</div>
			
			<div class="form-group">
				<label for="estimate"> {{ trans('invoice.estimate') }} </label>
				<input type="text" name="estimate" class="form-control" autocomplete="off" value="{{ Input::old('estimate') }}">

				<?php echo $errors->first('estimate', '<p class="error">:messages</p>');?>
			</div>		

			<div class="form-group">
				<label for="reference"> {{ trans('invoice.reference') }} </label>
				<input type="text" name="reference" class="form-control" autocomplete="off" value="{{ Input::old('reference') }}">

				<?php echo $errors->first('reference', '<p class="error">:messages</p>');?>
			</div>			
		</div>			
		
		<div class="col-md-6 col-lg-3">	
			<div class="form-group">
				<label for="estimate_date">{{ trans('invoice.estimate_date') }}</label>
				<input type="text" name="estimate_date" class="form-control datepicker required" autocomplete="off" value="{{ Input::old('estimate_date') }}">
				
				<?php echo $errors->first('estimate_date', '<p class="error">:messages</p>');?>
			</div>		

			<div class="form-group">
				<label for="expiry_date">{{ trans('invoice.expiry_date') }}</label>
				<input type="text" name="expiry_date" class="form-control datepicker required" autocomplete="off" value="{{ Input::old('expiry_date') }}">
				
				<?php echo $errors->first('expiry_date', '<p class="error">:messages</p>');?>
			</div>				
		
			<div class="form-group">
				<label for="currency">{{ trans('invoice.currency') }}</label>
				<select name="currency_id" class="form-control required solsoCurrencyEvent">
					<option value="" selected>{{ trans('invoice.choose') }}</option>
					
					@foreach ($currencies as $v)
						<option value="{{ $v->id }}"> {{ $v->name }} </option>
					@endforeach					
					
				</select>
				
				<?php echo $errors->first('currency_id', '<p class="error">:messages</p>');?>
			</div>		
		</div>			
		<div class="clearfix"></div>
		
		<div class="table-responsive">
		<div class="col-md-12">	
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
				<tr class="solsoChild">
					<td class="crt">1</td>
					
					<td>
						<select name="products[]" class="form-control required solsoSelect2 solsoCloneSelect2">
							<option value="" selected>{{ trans('invoice.choose') }}</option>
							
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
						<input type="text" name="qty[]" class="form-control required solsoEvent" autocomplete="off">
					</td>
					
					<td>
						<input type="text" name="price[]" class="form-control required solsoEvent" autocomplete="off">
					</td>
					
					<td>
						<select name="taxes[]" class="form-control required solsoEvent">
							<option value="" selected>{{ trans('invoice.choose') }}</option>
							
							@foreach ($taxes as $v)
								<option value="{{ $v->value }}"> {{ $v->value }} %</option>
							@endforeach			
							
						</select>					
					</td>
					
					<td>
						<input type="text" name="discount[]" class="form-control" autocomplete="off">
					</td>	
				
					<td>
						<select name="discountType[]" class="form-control solsoEvent">
							<option value="" selected>{{ trans('invoice.choose') }}</option>
							<option value="1">{{ trans('invoice.amount') }}</option>
							<option value="2">%</option>
						</select>
					</td>

					<td>
						<h4 class="pull-right">
							<span class="solsoSubTotal">0.00</span>
						</h4>	
					</td>
					
					<td>
						<button type="button" class="btn btn-danger disabled removeClone"><i class="fa fa-minus"></i></button>
					</td>					
				</tr>
			</tbody>
			
			<tfoot>
				<tr>
					<td colspan="5">
						<div class="col-md-12 col-lg-6 form-inline">
							<label for="end" class="show">{{ trans('invoice.invoice_discount') }}</label>
							<input type="text" name="invoiceDiscount" class="form-control" autocomplete="off">
							
							<select name="invoiceDiscountType" class="form-control solsoEvent">
								<option value="" selected>{{ trans('invoice.choose') }}</option>
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
							<span class="solsoTotal">0.00</span>
							<span class="solsoCurrency"></span>
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

		<div class="col-md-6 col-lg-6">
			<div class="form-group">
				<label for="description"> {{ trans('invoice.description') }} </label>
				<textarea name="description" class="form-control" rows="7" autocomplete="off"></textarea>
			</div>	
		</div>			

		<div class="col-md-6 col-lg-6">
			<div class="form-group">
				<label for="terms"> {{ trans('invoice.terms_conditions') }} </label>
				<textarea name="terms" class="form-control" rows="7" autocomplete="off"></textarea>
			</div>	
		</div>	
		<div class="clearfix"></div>
	
		<div class="form-group col-md-12">
			<button type="submit" class="btn btn-success btn-lg"><i class="fa fa-save"></i> {{ trans('invoice.save') }} </button>	
		</div>
		
	{{ Form::close() }}
	
	@include('products.create-modal')
	
@stop