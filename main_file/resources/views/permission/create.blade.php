{{ Form::open(array('url' => route('permission.store'))) }}
<div class="form-group">
    {{ Form::label('name', __('Name')) }}
    {{ Form::text('name', '', array('class' => 'form-control','required'=>'required')) }}
</div>
<div class="form-group">
    <select name="type" class="form-control" required>
        <option value="">Select type</option>
        <option value="view">View Permission</option>
        <option value="create">Create Permission</option>
        <option value="edit">Edit Permission</option>
    </select>
</div>
<div class="form-group text-right">
    <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ __('Cancel') }}</button>
    {{ Form::submit(__('Create'),array('class'=>'btn btn-primary')) }}
</div>
{{ Form::close() }}
