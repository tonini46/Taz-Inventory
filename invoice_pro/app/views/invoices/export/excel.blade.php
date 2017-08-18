<table>
	<tr>
		<td colspan="2">
			<h2>
				{{ trans('invoice.invoice') }} #
			</h2>
		</td>	
	</tr>
	
	<tr>
		<td>{{ isset($invoiceSettings->code) ? $invoiceSettings->code : '' }} {{ $invoice->number }}</td>
		<td>{{ trans('invoice.date') }} {{ $invoice->start_date }}</td>
	</tr>	
</table>
	
<table>
	<tr>
		<td>
			<h3>BILL FROM:</h3>
		</td>

		<td>
			<h3>BILL TO:</h3>
		</td>
	</tr>
	
	<tr>
		<td>
			<h4>{{ $owner->name }}</h4>
		</td>

		<td>
			<h4>{{ $invoice->client }}</h4>
		</td>
	</tr>	
	
	<tr>
		<td>
			{{ $owner->country }} - {{ $owner->state }} - {{ $owner->city }}
		</td>

		<td>
			{{ $invoice->country }} - {{ $invoice->state }} - {{ $invoice->city }}
		</td>
	</tr>
	
	<tr>
		<td>
			{{ $owner->address }} - {{ $owner->zip }}
		</td>

		<td>
			{{ $invoice->address }} - {{ $invoice->zip }}
		</td>
	</tr>	
	
	<tr>
		<td>
			BANK: {{ $owner->bank }}
		</td>

		<td>
			BANK: {{ $invoice->bank }}
		</td>
	</tr>	
	
	<tr>
		<td>
			BANK ACCOUNT: {{ $owner->bank_account }}
		</td>

		<td>
			BANK ACCOUNT: {{ $invoice->bank_account }}
		</td>
	</tr>	
</table>

<table>
	<tr>
		<th class="product" colspan="2">{{ trans('invoice.item') }}</th>
		<th class="qty">{{ trans('invoice.qty') }}</th>
		<th class="small">{{ trans('invoice.unit_price') }}</th>
		<th class="qty">{{ trans('invoice.tax_rate') }}</th>
		<th class="qty">{{ trans('invoice.discount') }}</th>
		<th class="small">{{ trans('invoice.amount') }}</th>
	</tr>	
	
	<?php $subTotalItems 	= 0;?>
	<?php $taxItems 		= 0;?>
	<?php $discountItems	= 0;?>
	<?php $invoiceDiscount	= 0;?>		
	
	@foreach ($invoiceProducts as $crt => $v)

		<tr>
			<td colspan="2">
				{{ $v->name }}
			</td>
			
			<td class="text-center">
				{{ $v->quantity }}
			</td>
			
			<td class="text-right">
				{{ $invoice->position == 1 ? $invoice->currency : '' }} {{ $v->price }} {{ $invoice->position == 2 ? $invoice->currency : '' }}
			</td>
			
			<td class="text-center">
				{{ $v->tax }} %
			</td>
			
			<td class="text-right">
				- {{ $invoice->position == 1 ? $invoice->currency : '' }} {{ number_format($v->discount_value, 2, '.', '') }} {{ $invoice->position == 2 ? $invoice->currency : '' }} 
			</td>
			
			<td class="text-right">
				{{ $invoice->position == 1 ? $invoice->currency : '' }} {{ $v->amount }} {{ $invoice->position == 2 ? $invoice->currency : '' }}
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

	<?php if ($invoice->type == 2) { ?>
		<?php $invoiceDiscount		= $invoice->discount;?>
	<?php } ?>
	
	<?php if ($invoice->type == 2) { ?>
		<?php $invoiceDiscount		= ($subTotalItems + $taxItems - $discountItems) * ( $invoice->discount / 100); ?>
	<?php } ?>		
	
	<tr>
		<td colspan="2">
			{{ trans('invoice.invoice_text_01') }}
		</td>
		
		<td colspan="5">
			{{ trans('invoice.subtotal') }}: 
			{{ $invoice->position == 1 ? $invoice->currency : '' }} {{ number_format($subTotalItems, 2, '.', '') }} {{ $invoice->position == 2 ? $invoice->currency : '' }} 
		</td>		
	</tr>

	<tr>	
		<td colspan="2">
		</td>
		
		<td colspan="5">
			{{ trans('invoice.tax') }}:  
			{{ $invoice->position == 1 ? $invoice->currency : '' }} {{ number_format($taxItems, 2, '.', '') }} {{ $invoice->position == 2 ? $invoice->currency : '' }} 
		</td>		
	</tr>		
		
	@if ( $discountItems != 0 )
	<tr>		
		<td colspan="2">
		</td>
		
		<td colspan="5">
			{{ trans('invoice.discount') }}:  
			- {{ $invoice->position == 1 ? $invoice->currency : '' }} {{ number_format($discountItems, 2, '.', '') }} {{ $invoice->position == 2 ? $invoice->currency : '' }}
		</td>
	</tr>	
	@endif
	
	@if ( $invoiceDiscount != 0 )
	<tr>	
		<td colspan="2">
		</td>
		
		<td colspan="5">
			{{ trans('invoice.invoice_discount') }}: 
			- {{ $invoice->position == 1 ? $invoice->currency : '' }} {{ number_format($invoiceDiscount, 2, '.', '') }} {{ $invoice->position == 2 ? $invoice->currency : '' }}
		</td>	
	</tr>	
	@endif	
	
	<tr>
		<td colspan="2">
		</td>	
	
		<td>
			<h4>
				{{ trans('invoice.total') }}: 
				{{ $invoice->position == 1 ? $invoice->currency : '' }} {{ number_format($invoice->amount, 2, '.', '') }} {{ $invoice->position == 2 ? $invoice->currency : '' }}
			</h4>		
		</td>
	</tr>
</table>

@if (isset($invoiceSettings->text))
<table>
	<tr>
		<td colspan="7">
			{{ $invoiceSettings->text }}
		</td>	
	</tr>	
</table>	
@endif





















