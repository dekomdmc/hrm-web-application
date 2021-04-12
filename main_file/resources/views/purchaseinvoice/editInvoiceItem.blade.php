{{ Form::model() }}
<div class="row">
    <div class="form-group col-md-6">
        {{ Form::label('issue_date', __('Issue Date')) }}
        {{ Form::date('issue_date', null, array('class' => 'form-control','required'=>'required')) }}
    </div>
</div>
{{ Form::close() }} 