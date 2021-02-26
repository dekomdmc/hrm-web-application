<?php $__env->startSection('page-title'); ?>
<?php echo e(__('Role')); ?>

<?php $__env->stopSection(); ?>
<?php $__env->startPush('css-page'); ?>
<?php $__env->stopPush(); ?>
<?php $__env->startPush('script-page'); ?>
    <script>
    </script>
<?php $__env->stopPush(); ?>
<?php $__env->startSection('breadcrumb'); ?>
<h6 class="h2 d-inline-block mb-0"><?php echo e(__('Role')); ?></h6>
<nav aria-label="breadcrumb" class="d-none d-md-inline-block ml-md-4">
    <ol class="breadcrumb breadcrumb-links">
        <li class="breadcrumb-item"><a href="#"><i class="fas fa-home"></i></a></li>
        <li class="breadcrumb-item"><a
                href="<?php echo e(route('dashboard')); ?>"><?php echo e(__('Dashboard')); ?></a></li>
        <li class="breadcrumb-item active" aria-current="page"><?php echo e(__('Roles')); ?></li>
    </ol>
</nav>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
<div class="container-fluid">
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col">
                            <h2 class="h3 mb-0"><?php echo e(__('Manage Role')); ?></h2>
                        </div>
                        <?php if(\Auth::user()->type=='company'): ?>
                            <div class="col-auto">
                                <span class="create-btn">
                                    <a href="#" data-url="<?php echo e(route('role.create')); ?>"
                                        data-ajax-popup="true"
                                        data-title="<?php echo e(__('Create New Role')); ?>"
                                        class="btn btn-outline-primary btn-sm">
                                        <i class="fa fa-plus"></i> <?php echo e(__('Create')); ?>

                                    </a>
                                </span>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="table-responsive py-4">
                            <table class="table table-flush" id="datatable-basic">
                                <thead class="thead-light">
                                    <tr>
                                        <th></th>
                                        <th><?php echo e(__('Name')); ?></th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $__currentLoopData = $roles; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $role): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <tr>
                                            <td></td>
                                            <td><?php echo e($role->name); ?></td>
                                            <td class="table-actions text-right">
                                                    <a href="#!"
                                                        data-url="<?php echo e(route('role.edit',$role->id)); ?>"
                                                        class="table-action" data-toggle="tooltip"
                                                        data-original-title="<?php echo e(__('Edit')); ?>"
                                                        data-ajax-popup="true"
                                                        data-title="<?php echo e(__('Edit Role')); ?>">
                                                        <i class="far fa-edit"></i>
                                                    </a>

                                                    <a href="<?php echo e(route('role.permission',$role->id)); ?>" class="table-action">
                                                        <i class="ni ni-settings-gear-65"></i>
                                                    </a>
                                                    
                                                    <a href="#!" class="table-action table-action-delete"
                                                        data-toggle="tooltip"
                                                        data-original-title="<?php echo e(__('Delete')); ?>"
                                                        data-confirm="Are You Sure?|This action can not be undone. Do you want to continue?"
                                                        data-confirm-yes="document.getElementById('role-delete-form-<?php echo e($role->id); ?>').submit();">
                                                        <i class="fas fa-trash"></i>
                                                    </a>
                                                    <?php echo Form::open(['method' => 'DELETE', 'route' => ['role.destroy',
                                                    $role->id],'id'=>'role-delete-form-'.$role->id]); ?>

                                                    <?php echo Form::close(); ?>

                                            </td>
                                        </tr>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/mitaapps/public_html/dekomdmc/main_file/resources/views/role/index.blade.php ENDPATH**/ ?>