{{ Form::model($chartofaccount, array('route' => array('chartofaccount.update', $chartofaccount->id), 'method' => 'PUT')) }}

<div class="form-group">
    {{ Form::label('name', __('Group')) }}
    <select class="form-control custom-select" name="group_id">
        <?php
        foreach ($groups as $group) {
        ?>
            <option value="<?php echo $group['id'] ?>"><?php echo $group['name'] ?></option>
        <?php
        }
        ?>
    </select>
</div>
<div class="form-group">
    {{ Form::label('name', __('Name')) }}
    {{ Form::text('name', null, array('class' => 'form-control','required'=>'required')) }}
</div>

<div class="form-group text-right">
    <button type="button" class="btn btn-secondary" data-dismiss="modal">{{__('Cancel')}}</button>
    {{Form::submit(__('Update'),array('class'=>'btn btn-primary'))}}
</div>
<script>
    document.querySelector("select[name=group_id]").value = <?php echo $chartofaccount->group_id ?>;
</script>

{{ Form::close() }}