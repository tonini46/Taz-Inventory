<div class="modal fade" id="solsoCreateProduct" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
<div class="modal-dialog modal-lg">
	<div class="modal-content">
		<div class="modal-header">
			<h4>{{ trans('invoice.create_new_product') }}</h4>
		</div>
		
		<div class="modal-body solsoShowForm">
		
			{{ Form::open(array('url' => 'product', 'role' => 'form', 'class' => 'solsoFormProduct')) }}
			
				<div class="col-md-6">
					<div class="form-group">
						<label for="name">{{ trans('invoice.name') }}</label>
						<input type="text" name="name" class="form-control required" autocomplete="off">
						
						<?php echo $errors->first('name', '<p class="error">:messages</p>');?>
					</div>			
				</div>
			
				<div class="col-md-3">
					<div class="form-group">
						<label for="code">{{ trans('invoice.code') }}</label>
						<input type="text" name="code" class="form-control required" autocomplete="off">
						
						<?php echo $errors->first('code', '<p class="error">:messages</p>');?>
					</div>			
				</div>
				
				<div class="col-md-3">
					<div class="form-group">
						<label for="price">{{ trans('invoice.price') }}</label>
						<input type="text" name="price" class="form-control required" autocomplete="off" data-parsley-type="number">
						
						<?php echo $errors->first('price', '<p class="error">:messages</p>');?>
					</div>			
				</div>				
				<div class="clearfix"></div>
				
				<div class="col-md-12">
					<div class="form-group">
						<label for="description">{{ trans('invoice.description') }}</label>
						<textarea name="description" class="form-control" rows="7" autocomplete="off">{{ Input::old('description') }}</textarea>
						
						<?php echo $errors->first('description', '<p class="error">:messages</p>');?>
					</div>		
				</div>		
				
				<div class="col-md-12">
					<button type="submit" class="btn btn-success solsoSave">
						<i class="fa fa-save"></i> {{ trans('invoice.save') }}
					</button>
				</div>
				
			{{ Form::close() }}	
		</div>
		<div class="clearfix"></div>
		
		<div class="modal-footer top20">
			<button type="reset" class="btn btn-default" data-dismiss="modal">Cancel</button>
		</div>
	</div>
</div>
</div>