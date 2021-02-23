{{ Form::open(array('url' => 'supplier')) }}
<div class="row">
    <div class="form-group col-md-12">
        {{ Form::label('company_name', __('Supplier Name')) }}
        {{Form::text('company_name',null, ['class'=>'form-control'])}}
    </div>
    <div class="form-group col-md-12">
        {{ Form::label('mobile', __('Phone Number')) }}
        {{Form::text('mobile',null, ['class'=>'form-control'])}}
    </div>
    <div class="form-group col-md-12">
        {{ Form::label('mobile', __('Address')) }}
        {{Form::textarea('address',null, ['class'=>'form-control'])}}
    </div>
    <div class="form-group col-md-12 text-right">
        {{Form::submit(__('create'),array('class'=>'btn btn-primary mt-4','id'=>'saveBtn'))}}
    </div>
</div>
{{ Form::close() }}