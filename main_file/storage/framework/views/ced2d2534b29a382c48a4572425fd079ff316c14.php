<?php $__env->startSection('page-title'); ?>
<?php echo e(__('Permission')); ?>

<?php $__env->stopSection(); ?>
<?php $__env->startPush('css-page'); ?>
<?php $__env->stopPush(); ?>
<?php $__env->startPush('script-page'); ?>
    <script>
    </script>
<?php $__env->stopPush(); ?>
<?php $__env->startSection('breadcrumb'); ?>
<h6 class="h2 d-inline-block mb-0"><?php echo e(__('Permission')); ?></h6>
<nav aria-label="breadcrumb" class="d-none d-md-inline-block ml-md-4">
    <ol class="breadcrumb breadcrumb-links">
        <li class="breadcrumb-item"><a href="#"><i class="fas fa-home"></i></a></li>
        <li class="breadcrumb-item"><a
                href="<?php echo e(route('dashboard')); ?>"><?php echo e(__('Dashboard')); ?></a></li>
        <li class="breadcrumb-item active" aria-current="page"><?php echo e(__('Permissions')); ?></li>
    </ol>
</nav>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
<div class="container-fluid">
    <div class="row">
        <div class="col-lg-12">
            <?php echo e(Form::open(array('url'=> route('permission.add', $user->id),'method'=>'post'))); ?>

            <div class="card">
                <div class="card-header">
                    <?php echo e($user->name); ?> Permissions
                    <div class="float-right">
                        <a href="#" data-url="<?php echo e(route('permission.create')); ?>" data-ajax-popup="true" data-title="<?php echo e(__('Create New Permission')); ?>" class="btn btn-primary btn-sm">Add Permission</a>
                        <input class="btn btn-sm btn-primary" type="submit" value="Save">
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive py-4">
                        <table class="table table-flush" id="datatable-basic">
                            <thead>
                                <tr>
                                    <th></th>
                                    <th>Permission</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $__currentLoopData = $permissions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $permission): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <tr>
                                        <td></td>
                                        <td>
                                            <div class="form-check">
                                                <input <?= $user->hasPermissionTo($permission->name) ? 'checked' : '' ?> id="<?php echo e($permission->id); ?>" name="permissions[]"
                                                    value="<?php echo e($permission->id); ?>" class="form-check-input"
                                                    type="checkbox">
                                                <label class="form-check-label"
                                                    for="<?php echo e($permission->id); ?>"><?php echo e($permission->name); ?></label>
                                            </div>
                                        </td>
                                        <td></td>
                                    </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <?php echo e(Form::close()); ?>

        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/mitaapps/public_html/dekomdmc/main_file/resources/views/permission/index.blade.php ENDPATH**/ ?>