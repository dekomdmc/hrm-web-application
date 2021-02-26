<?php $__env->startSection('page-title'); ?>
<?php echo e(__('Contract')); ?>

<?php $__env->stopSection(); ?>
<?php $__env->startPush('css-page'); ?>
<?php $__env->stopPush(); ?>
<?php $__env->startPush('script-page'); ?>
<?php $__env->stopPush(); ?>
<?php $__env->startSection('breadcrumb'); ?>
<h6 class="h2 d-inline-block mb-0"><?php echo e(__('Suppliers')); ?></h6>
<nav aria-label="breadcrumb" class="d-none d-md-inline-block ml-md-4">
    <ol class="breadcrumb breadcrumb-links">
        <li class="breadcrumb-item"><a href="#"><i class="fas fa-home"></i></a></li>
        <li class="breadcrumb-item"><a href="<?php echo e(route('dashboard')); ?>"><?php echo e(__('Dashboard')); ?></a></li>
        <li class="breadcrumb-item active" aria-current="page"><?php echo e(__('Suppliers')); ?></li>
    </ol>
</nav>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
<div class="container-fluid">
    <div class="row">
        <div class="col">
            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <div class="col">
                            <h2 class="h3 mb-0"><?php echo e(__('Manage Suppliers')); ?></h2>
                        </div>
                        <?php if(\Auth::user()->type=='company' || \Auth::user()->hasPermissionTo('view supplier')): ?>
                        <div class="col-auto">
                            <span class="create-btn">
                                <a href="#" data-url="<?php echo e(route('supplier.create')); ?>" data-ajax-popup="true" data-title="<?php echo e(__('Create Supplier')); ?>" class="btn btn-outline-primary btn-sm">
                                    <i class="fa fa-plus"></i> <?php echo e(__('Create')); ?>

                                </a>
                            </span>
                        </div>
                        <?php endif; ?>
                    </div>
                </div>
                <div class="table-responsive py-4">
                    <table class="table table-flush" id="datatable-basic">
                        <thead class="thead-light">
                            <tr>
                                <th>
                                    <div class="btn btn-primary btn-sm"><i class="fa fa-check"></i></div>
                                </th>
                                <th><?php echo e(__('Name')); ?></th>
                                <th><?php echo e(__('Mobile')); ?></th>
                                <th><?php echo e(__('Address')); ?></th>
                                <?php if(\Auth::user()->type=='company'): ?>
                                <th class="text-right"><?php echo e(__('Action')); ?></th>
                                <?php endif; ?>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            foreach ($suppliers as $supplier) {
                            ?>
                                <tr>
                                    <td></td>
                                    <td><?= $supplier['company_name'] ?></td>
                                    <td><?= $supplier['mobile'] ?></td>
                                    <td><?= $supplier['address'] ?></td>
                                    <?php if(\Auth::user()->type=='company'): ?>
                                    <td class="action text-right">
                                        <a class="table-action" data-ajax-popup="true" data-title="Edit <?= $supplier['company_name'] ?>" data-original-title="Edit" data-url="http://dekomdmc.mitaapps.com/supplier/<?= $supplier['id'] ?>/edit">
                                            <i class="far fa-edit"></i>
                                        </a>
                                        <a class="table-action table-action-delete" data-original-title="Delete" data-confirm="Are You Sure?|This action can not be undone. Do you want to continue?" data-confirm-yes="window.location.href = '/supplier/delete/<?= $supplier['id'] ?>'">
                                            <i class="fas fa-trash"></i>
                                        </a>
                                    </td>
                                    <?php endif; ?>
                                </tr>
                            <?php
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/mitaapps/public_html/dekomdmc/main_file/resources/views/supplier/index.blade.php ENDPATH**/ ?>