<?php echo e(Form::open(array('url' => route('permission.store')))); ?>

<div class="form-group">
    <?php echo e(Form::label('name', __('Name'))); ?>

    <?php echo e(Form::text('name', '', array('class' => 'form-control','required'=>'required'))); ?>

</div>
<div class="form-group text-right">
    <button type="button" class="btn btn-secondary" data-dismiss="modal"><?php echo e(__('Cancel')); ?></button>
    <?php echo e(Form::submit(__('Create'),array('class'=>'btn btn-primary'))); ?>

</div>
<?php echo e(Form::close()); ?>

<?php /**PATH /home/mitaapps/public_html/dekomdmc/main_file/resources/views/permission/create.blade.php ENDPATH**/ ?>