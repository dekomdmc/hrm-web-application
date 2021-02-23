{{ Form::open(array('url' => 'chartofaccount')) }}
<div class="row">
    <div class="form-group col-md-12">
        {{ Form::label('group', __('Group')) }}
        <select name="group_id" class="form-control custom-select">
            <?php
            foreach ($groups as $group) {
            ?>
                <option value="<?= $group['id'] ?>"><?= $group['name'] ?></option>
            <?php
            }
            ?>
        </select>
    </div>
    <div class="form-group col-md-12">
        {{ Form::label('name', __('Name')) }}
        {{ Form::text('name', '', array('class' => 'form-control','required'=> 'required')) }}
    </div>
</div>
<div class="modal-footer">
    <button type="button" class="btn btn-secondary" data-dismiss="modal">{{__('Cancel')}}</button>
    {{Form::submit(__('Create'),array('class'=>'btn btn-primary'))}}
</div>

{{ Form::close() }}