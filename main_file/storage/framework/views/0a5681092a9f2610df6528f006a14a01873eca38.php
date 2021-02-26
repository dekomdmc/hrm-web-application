<?php $__env->startSection('page-title'); ?>
    <?php echo e(__('Contract')); ?>

<?php $__env->stopSection(); ?>
<?php $__env->startPush('css-page'); ?>
<?php $__env->stopPush(); ?>
<?php $__env->startPush('script-page'); ?>
<?php $__env->stopPush(); ?>
<?php $__env->startSection('breadcrumb'); ?>
    <h6 class="h2 d-inline-block mb-0"><?php echo e(__('Contract')); ?></h6>
    <nav aria-label="breadcrumb" class="d-none d-md-inline-block ml-md-4">
        <ol class="breadcrumb breadcrumb-links">
            <li class="breadcrumb-item"><a href="#"><i class="fas fa-home"></i></a></li>
            <li class="breadcrumb-item"><a href="<?php echo e(route('dashboard')); ?>"><?php echo e(__('Dashboard')); ?></a></li>
            <li class="breadcrumb-item active" aria-current="page"><?php echo e(__('Contract')); ?></li>
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
                                <h2 class="h3 mb-0"><?php echo e(__('Manage Contracts')); ?></h2>
                            </div>
                            <?php if(\Auth::user()->type=='company'): ?>
                                <div class="col-auto">
                                <span class="create-btn">
                                    <a href="#" data-url="<?php echo e(route('contract.create')); ?>" data-ajax-popup="true" data-title="<?php echo e(__('Create New Contract')); ?>" class="btn btn-outline-primary btn-sm">
                                        <i class="fa fa-plus"></i>  <?php echo e(__('Create')); ?>

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
                                <th><?php echo e(__('Subject')); ?></th>
                                <?php if(\Auth::user()->type!='client'): ?>
                                    <th> <?php echo e(__('Client')); ?></th>
                                <?php endif; ?>
                                <th><?php echo e(__('Contract Type')); ?></th>
                                <th><?php echo e(__('Contract Value')); ?></th>
                                <th><?php echo e(__('Start Date')); ?></th>
                                <th><?php echo e(__('End Date')); ?></th>
                                <th><?php echo e(__('Description')); ?></th>
                                <?php if(\Auth::user()->type=='company'): ?>
                                    <th class="text-right"><?php echo e(__('Action')); ?></th>
                                <?php endif; ?>
                            </tr>
                            </thead>

                            <tbody>
                            <?php $__currentLoopData = $contracts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $contract): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

                                <tr class="font-style">
                                    <td><?php echo e($contract->subject); ?></td>
                                    <?php if(\Auth::user()->type!='client'): ?>
                                        <td><?php echo e(!empty($contract->clients)?$contract->clients->name:''); ?></td>
                                    <?php endif; ?>
                                    <td><?php echo e(!empty($contract->types)?$contract->types->name:''); ?></td>
                                    <td><?php echo e(\Auth::user()->priceFormat($contract->value)); ?></td>
                                    <td><?php echo e(\Auth::user()->dateFormat($contract->start_date )); ?></td>
                                    <td><?php echo e(\Auth::user()->dateFormat($contract->end_date )); ?></td>
                                    <td>
                                        <a href="#" data-url="<?php echo e(route('contract.description',$contract->id)); ?>" data-ajax-popup="true" data-toggle="tooltip" data-title="<?php echo e(__('Desciption')); ?>"><i class="fa fa-comment"></i></a>
                                    </td>
                                    <?php if(\Auth::user()->type=='company'): ?>
                                        <td class="action text-right">
                                            <a href="#" data-url="<?php echo e(route('contract.edit',$contract->id)); ?>" data-ajax-popup="true" data-title="<?php echo e(__('Edit Contract')); ?>" class="table-action" data-toggle="tooltip" data-original-title="<?php echo e(__('Edit')); ?>">
                                                <i class="far fa-edit"></i>
                                            </a>
                                            <a href="#!" class="table-action table-action-delete" data-toggle="tooltip" data-original-title="<?php echo e(__('Delete')); ?>" data-confirm="Are You Sure?|This action can not be undone. Do you want to continue?" data-confirm-yes="document.getElementById('delete-form-<?php echo e($contract->id); ?>').submit();">
                                                <i class="fas fa-trash"></i>
                                            </a>
                                            <?php echo Form::open(['method' => 'DELETE', 'route' => ['contract.destroy', $contract->id],'id'=>'delete-form-'.$contract->id]); ?>

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


<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/mitaapps/public_html/dekomdmc/main_file/resources/views/contract/index.blade.php ENDPATH**/ ?>