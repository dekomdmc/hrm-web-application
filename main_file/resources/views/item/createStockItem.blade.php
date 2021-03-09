{{ Form::open(array('url' => 'item')) }}
<div class="row">
    <div class="form-group col-md-6">
        {{ Form::label('name', __('Service Name')) }}
        {{ Form::text('name', '', array('class' => 'form-control','required'=>'required')) }}
    </div>
    <div class="form-group col-md-6">
        {{ Form::label('sku', __('SKU')) }}
        {{ Form::text('sku', '', array('class' => 'form-control','required'=>'required')) }}
    </div>
    <div class="form-group col-md-6">
        {{ Form::label('sale_price', __('Sale Price')) }}
        {{ Form::text('sale_price', '', array('class' => 'form-control','required'=>'required')) }}
    </div>
    <div class="form-group col-md-6">
        {{ Form::label('purchase_price', __('Purchase Price')) }}
        {{ Form::text('purchase_price', '', array('class' => 'form-control','required'=>'required')) }}
    </div>
    <div class="form-group col-md-6">
        {{ Form::label('quantity', __('Quantity')) }}
        {{ Form::number('quantity', '', array('class' => 'form-control','required'=>'required')) }}
    </div>
    <div class="form-group col-md-6">
        {{ Form::label('unit', __('Unit')) }}
        {{ Form::select('unit', $unit,null, array('class' => 'form-control custom-select','required'=>'required')) }}
    </div>
    <div class="form-group col-md-6">
        {{ Form::label('tax', __('Tax')) }}
        {{ Form::select('tax[]', $tax,null, array('class' => 'form-control custom-select','multiple')) }}
    </div>
    <div class="form-group col-md-6">
        {{ Form::label('category', __('Category')) }}
        {{ Form::select('category', $category,null, array('class' => 'form-control custom-select','required'=>'required')) }}
    </div>

    <div class="form-group col-md-6">
        <input type="hidden" class="custom-control-input" id="customRadio5" name="type" value="service" checked="checked">
        <!-- <div class="form-group">
            <label class="d-block">{{__('Type')}}</label>
            <div class="row">
                <div class="col-md-6">
                    <div class="custom-control custom-radio">
                        <input type="radio" class="custom-control-input" id="customRadio5" name="type" value="product" checked="checked">
                        <label class="custom-control-label" for="customRadio5">{{__('Product')}}</label>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="custom-control custom-radio">
                        <input type="radio" class="custom-control-input" id="customRadio6" name="type" value="service">
                        <label class="custom-control-label" for="customRadio6">{{__('Service')}}</label>
                    </div>
                </div>
            </div>
        </div> -->
    </div>
</div>
<div class="row">
    <div class="form-group col-md-12">
        {{ Form::label('description', __('Description')) }}
        {!! Form::textarea('description', null, ['class'=>'form-control','rows'=>'4']) !!}
    </div>
</div>
<div class="modal-footer">
    <button type="button" class="btn btn-secondary" data-dismiss="modal">{{__('Cancel')}}</button>
    {{Form::submit(__('Create'),array('class'=>'btn btn-primary'))}}
</div>

{{ Form::close() }}