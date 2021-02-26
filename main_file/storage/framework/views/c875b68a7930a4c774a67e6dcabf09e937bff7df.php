<?php $__env->startSection('page-title'); ?>
<?php echo e(__('Stock Items')); ?>

<?php $__env->stopSection(); ?>
<?php $__env->startPush('css-page'); ?>
<?php $__env->stopPush(); ?>
<?php $__env->startPush('script-page'); ?>
<?php $__env->stopPush(); ?>
<?php $__env->startSection('breadcrumb'); ?>
<h6 class="h2 d-inline-block mb-0"><?php echo e(__('Stock Items')); ?></h6>
<nav aria-label="breadcrumb" class="d-none d-md-inline-block ml-md-4">
    <ol class="breadcrumb breadcrumb-links">
        <li class="breadcrumb-item"><a href="#"><i class="fas fa-home"></i></a></li>
        <li class="breadcrumb-item"><a href="<?php echo e(route('dashboard')); ?>"><?php echo e(__('Dashboard')); ?></a></li>
        <li class="breadcrumb-item active" aria-current="page"><?php echo e(__('Item')); ?></li>
    </ol>
</nav>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
<div class="container-fluid">
    <div class="row">
        <div class="col">
            <div class="card">
                <!-- Card header -->
                <div class="card-header">
                    <div class="row">
                        <div class="col">
                            <h2 class="h3 mb-0"><?php echo e(__('Manage Items')); ?></h2>
                        </div>
                        <?php if(\Auth::user()->type=='company'): ?>
                        <div class="col-auto">
                            <span class="create-btn">
                                <a href="#" data-url="<?php echo e(route('item.create')); ?>" data-ajax-popup="true" data-title="<?php echo e(__('Create New Item')); ?>" class="btn btn-outline-primary btn-sm">
                                    <i class="fa fa-plus"></i> <?php echo e(__('Create')); ?>

                                </a>
                            </span>
                            <span class="create-btn">
                                <a data-uploaditems href="#" class="btn btn-outline-primary btn-sm">
                                    <i class="fa fa-file-excel"></i> <?php echo e(__('Import')); ?>

                                </a>
                            </span>
                            <span>
                                <a href="/item/export" class="btn btn-danger btn-sm">
                                    <i class="fa fa-file-excel"></i> <?php echo e(__('Export')); ?>

                                </a>
                            </span>
                            <span>
                                <a data-deleteselecteditems class="btn btn-danger btn-sm">
                                    <i class="fa fa-trash"></i> <?php echo e(__('Delete')); ?>

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
                                    <div class="btn btn-primary btn-sm">✔</div>
                                </th>
                                <th> <?php echo e(__('Sku')); ?></th>
                                <th><?php echo e(__('Name')); ?></th>
                                <th><?php echo e(__('Tax')); ?></th>
                                <th><?php echo e(__('Purchase Price')); ?></th>
                                <th><?php echo e(__('Sale Price')); ?></th>
                                <th><?php echo e(__('Category')); ?></th>
                                <th><?php echo e(__('Unit')); ?></th>
                                <th><?php echo e(__('Type')); ?></th>
                                <th><?php echo e(__('Description')); ?></th>
                                <?php if(\Auth::user()->type=='company'): ?>
                                <th class="text-right"><?php echo e(__('Action')); ?></th>
                                <?php endif; ?>
                            </tr>
                        </thead>

                        <tbody>
                            <?php $__currentLoopData = $items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

                            <tr data-id="<?= $item->id ?>" class="font-style">
                                <td></td>
                                <td><?php echo e($item->sku); ?></td>
                                <td><?php echo e($item->name); ?></td>
                                <td>
                                    <?php
                                    $taxes=\Utility::tax($item->tax);
                                    ?>

                                    <?php $__currentLoopData = $taxes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $tax): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <?php echo e(!empty($tax)?$tax->name:''); ?><br>

                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </td>
                                <td><?php echo e(\Auth::user()->priceFormat($item->purchase_price )); ?></td>
                                <td><?php echo e(\Auth::user()->priceFormat($item->sale_price)); ?></td>
                                <td><?php echo e(!empty($item->categories)?$item->categories->name:''); ?></td>
                                <td><?php echo e(!empty($item->units)?$item->units->name:''); ?></td>
                                <td><?php echo e($item->type); ?></td>
                                <td><?php echo e($item->description); ?></td>
                                <?php if(\Auth::user()->type=='company'): ?>
                                <td class="action text-right">
                                    <a href="#" data-url="<?php echo e(route('item.edit',$item->id)); ?>" data-ajax-popup="true" data-title="<?php echo e(__('Edit Item')); ?>" class="table-action" data-toggle="tooltip" data-original-title="<?php echo e(__('Edit')); ?>">
                                        <i class="far fa-edit"></i>
                                    </a>
                                    <a href="#!" class="table-action table-action-delete" data-toggle="tooltip" data-original-title="<?php echo e(__('Delete')); ?>" data-confirm="Are You Sure?|This action can not be undone. Do you want to continue?" data-confirm-yes="document.getElementById('delete-form-<?php echo e($item->id); ?>').submit();">
                                        <i class="fas fa-trash"></i>
                                    </a>
                                    <?php echo Form::open(['method' => 'DELETE', 'route' => ['item.destroy', $item->id],'id'=>'delete-form-'.$item->id]); ?>

                                    <?php echo Form::close(); ?>

                                </td>
                                <?php endif; ?>
                            </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/mitaapps/public_html/dekomdmc/main_file/resources/views/item/prices.blade.php ENDPATH**/ ?>