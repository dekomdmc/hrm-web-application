<?php $__env->startSection('page-title'); ?>
<?php echo e(__('Expense')); ?>

<?php $__env->stopSection(); ?>
<?php $__env->startPush('css-page'); ?>
<?php $__env->stopPush(); ?>
<?php $__env->startPush('script-page'); ?>
<?php $__env->stopPush(); ?>
<?php $__env->startSection('breadcrumb'); ?>
<h6 class="h2 d-inline-block mb-0"><?php echo e(__('Expense')); ?></h6>
<nav aria-label="breadcrumb" class="d-none d-md-inline-block ml-md-4">
    <ol class="breadcrumb breadcrumb-links">
        <li class="breadcrumb-item"><a href="#"><i class="fas fa-home"></i></a></li>
        <li class="breadcrumb-item"><a href="<?php echo e(route('dashboard')); ?>"><?php echo e(__('Dashboard')); ?></a></li>
        <li class="breadcrumb-item active" aria-current="page"><?php echo e(__('Expense')); ?></li>
    </ol>
</nav>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
<div class="container-fluid">
    <div class="row">
        <div class="col-lg-12">
            <div class="col">
                <div class="card">
                    <!-- Card header -->
                    <div class="card-header">
                        <div class="row">
                            <div class="col">
                                <h2 class="h3 mb-0"><?php echo e(__('Manage Expenses')); ?></h2>
                            </div>
                            <?php if(\Auth::user()->type=='company'): ?>
                            <div class="col-auto">
                                <span class="create-btn">
                                    <a href="#" data-url="<?php echo e(route('expense.create')); ?>" data-ajax-popup="true" data-title="<?php echo e(__('Create New Expense')); ?>" class="btn btn-outline-primary btn-sm">
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
                                    <th></th>
                                    <th> <?php echo e(__('Date')); ?></th>
                                    <th> <?php echo e(__('Amount')); ?></th>
                                    <th> <?php echo e(__('User')); ?></th>
                                    <th> <?php echo e(__('Project')); ?></th>
                                    <th> <?php echo e(__('Attachment')); ?></th>
                                    <th> <?php echo e(__('Description')); ?></th>
                                    <?php if(\Auth::user()->type=='company'): ?>
                                    <th class="text-right"> <?php echo e(__('Action')); ?></th>
                                    <?php endif; ?>
                                </tr>
                            </thead>

                            <tbody>
                                <?php $__currentLoopData = $expenses; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $expense): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr class="font-style">
                                    <td></td>
                                    <td><?php echo e(Auth::user()->dateFormat($expense->date)); ?></td>
                                    <td><?php echo e(Auth::user()->priceFormat($expense->amount)); ?></td>
                                    <td><?php echo e((!empty($expense->users)?$expense->users->name:'')); ?></td>
                                    <td><?php echo e(!empty($expense->projects)?$expense->projects->title:''); ?></td>
                                    <td>
                                        <?php if(!empty($expense->attachment)): ?>
                                        <a href="<?php echo e(asset(Storage::url('uploads/attachment/'. $expense->attachment))); ?>" target="_blank"><?php echo e($expense->attachment); ?></a>
                                        <?php else: ?>
                                        --
                                        <?php endif; ?>
                                    </td>
                                    <td><?php echo e($expense->description); ?></td>
                                    <?php if(\Auth::user()->type=='company'): ?>
                                    <td class="action text-right">
                                        <a href="#" data-url="<?php echo e(route('expense.edit',$expense->id)); ?>" data-ajax-popup="true" data-title="<?php echo e(__('Edit Expense')); ?>" class="table-action" data-toggle="tooltip" data-original-title="<?php echo e(__('Edit')); ?>">
                                            <i class="far fa-edit"></i>
                                        </a>
                                        <a href="#!" class="table-action table-action-delete" data-toggle="tooltip" data-original-title="<?php echo e(__('Delete')); ?>" data-confirm="Are You Sure?|This action can not be undone. Do you want to continue?" data-confirm-yes="document.getElementById('delete-form-<?php echo e($expense->id); ?>').submit();">
                                            <i class="fas fa-trash"></i>
                                        </a>
                                        <?php echo Form::open(['method' => 'DELETE', 'route' => ['expense.destroy', $expense->id],'id'=>'delete-form-'.$expense->id]); ?>

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
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/mitaapps/public_html/dekomdmc/main_file/resources/views/expense/index.blade.php ENDPATH**/ ?>