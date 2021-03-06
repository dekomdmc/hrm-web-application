{{ Form::open(array('url' => 'event')) }}
<div class="row">
    <div class="form-group col-md-6">
        {{ Form::label('name', __('Event title')) }}
        {{ Form::text('name', '', array('class' => 'form-control','required'=>'required')) }}
    </div>
    <div class="form-group col-md-6">
        {{ Form::label('where', __('Where')) }}
        {{ Form::text('where', '', array('class' => 'form-control','required'=>'required')) }}
    </div>
    <div class="form-group col-md-6">
        {{Form::label('department',__('Department'))}}
        {{ Form::select('department[]', $departments,null, array('class' => 'form-control custom-select','id'=>'department','required'=>'required','multiple')) }}
    </div>
    <div class="form-group col-md-6">
        {{Form::label('employee',__('Employee'))}}<br>

        <select class="form-control custom-select" name="employee[]" id="employee" placeholder="{{__('Select Employee')}}" multiple>
        </select>
        <small class="text-muted">{{__('Department is require for employee selection')}}</small>
    </div>
    <div class="form-group col-md-6">
        {{ Form::label('start_date', __('Start Date')) }}
        {{ Form::date('start_date', '', array('class' => 'form-control','required'=>'required')) }}
    </div>
    <div class="form-group col-md-6">
        {{ Form::label('start_time', __('Start Time')) }}
        {{ Form::time('start_time', '', array('class' => 'form-control','required'=>'required')) }}
    </div>
    <div class="form-group col-md-6">
        {{ Form::label('end_date', __('End Date')) }}
        {{ Form::date('end_date', '', array('class' => 'form-control','required'=>'required')) }}
    </div>
    <div class="form-group col-md-6">
        {{ Form::label('end_time', __('End Time')) }}
        {{ Form::time('end_time', '', array('class' => 'form-control','required'=>'required')) }}
    </div>
    <div class="form-group col-md-12">
        <label class="form-control-label d-block mb-3">{{__('Status color')}}</label>
        <div class="btn-group btn-group-toggle btn-group-colors event-tag mb-0" data-toggle="buttons">
            <label class="btn bg-info active mr-2">
                <input type="radio" name="color" value="bg-info" autocomplete="off" checked>
            </label>
            <label class="btn bg-warning mr-2">
                <input type="radio" name="color" value="bg-warning" autocomplete="off">
            </label>
            <label class="btn bg-danger mr-2">
                <input type="radio" name="color" value="bg-danger" autocomplete="off">
            </label>
            <label class="btn bg-success mr-2">
                <input type="radio" name="color" value="bg-success" autocomplete="off">
            </label>
            <label class="btn bg-default mr-2">
                <input type="radio" name="color" value="bg-default" autocomplete="off">
            </label>
            <label class="btn bg-primary mr-2">
                <input type="radio" name="color" value="bg-primary" autocomplete="off">
            </label>
        </div>
    </div>
    <div class="form-group col-md-12">
        {{ Form::label('description', __('Description')) }}
        {!! Form::textarea('description', null, ['class'=>'form-control','rows'=>'3']) !!}
    </div>
    <div class="col-md-12">
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">{{__('Cancel')}}</button>
            {{Form::submit(__('Create'),array('class'=>'btn btn-primary'))}}
        </div>
    </div>
</div>
{{ Form::close() }}

