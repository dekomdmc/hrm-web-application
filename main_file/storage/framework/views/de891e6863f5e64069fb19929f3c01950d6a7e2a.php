<?php
$profile=asset(Storage::url('uploads/avatar'));
?>
<?php $__env->startSection('page-title'); ?>
<?php echo e(__('Client')); ?>

<?php $__env->stopSection(); ?>
<?php $__env->startPush('css-page'); ?>
<?php $__env->stopPush(); ?>
<?php $__env->startPush('script-page'); ?>
<?php $__env->stopPush(); ?>
<?php $__env->startSection('breadcrumb'); ?>
<h6 class="h2 d-inline-block mb-0"><?php echo e(__('Client')); ?></h6>
<nav aria-label="breadcrumb" class="d-none d-md-inline-block ml-md-4">
    <ol class="breadcrumb breadcrumb-links">
        <li class="breadcrumb-item"><a href="#"><i class="fas fa-home"></i></a></li>
        <li class="breadcrumb-item"><a href="<?php echo e(route('dashboard')); ?>"><?php echo e(__('Dashboard')); ?></a></li>
        <li class="breadcrumb-item active" aria-current="page"><?php echo e(__('Client')); ?></li>
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
                            <h2 class="h3 mb-0"><?php echo e(__('Manage Clients')); ?></h2>
                        </div>
                        <div class="col-auto">
                            <a data-deleteselected class="btn btn-danger btn-sm">
                                <i class="fa fa-plus"></i> <?php echo e(__('Delete')); ?>

                            </a>
                            <a href="#" data-url="<?php echo e(route('client.create')); ?>" data-ajax-popup="true" data-title="<?php echo e(__('Create New Client')); ?>" class="btn btn-outline-primary btn-sm">
                                <i class="fa fa-plus"></i> <?php echo e(__('Create')); ?>

                            </a>
                            <a data-importclients class="btn btn-sm btn-primary">
                                <i class="fa fa-file-excel"></i> <?php echo e(__('Import')); ?>

                            </a>
                            <a href="/client/export" class="btn btn-danger btn-sm">
                                <i class="fa fa-file-excel"></i> <?php echo e(__('Export')); ?>

                            </a>
                        </div>
                    </div>
                </div>
                <div class="table-responsive py-4">
                    <table class="table table-flush" id="datatable-basic">
                        <thead class="thead-light">
                            <tr>
                                <th class="select-checkbox">
                                    <div class="btn">✔</div>
                                </th>
                                <th><?php echo e(__('Client ID')); ?></th>
                                <th><?php echo e(__('Name')); ?></th>
                                <th><?php echo e(__('Email')); ?></th>
                                <th><?php echo e(__('Phone')); ?></th>
                                <th><?php echo e(__('Status')); ?></th>
                                <th class="text-right"><?php echo e(__('Action')); ?></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $__currentLoopData = $clients; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $client): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr data-id="<?php echo e($client->id); ?>">
                                <td></td>
                                <td>
                                    <a href="<?php echo e(route('client.show',\Crypt::encrypt($client->id))); ?>" class="btn btn-sm btn-primary"><?php echo e(!empty($client->clientDetail)? \Auth::user()->clientIdFormat($client->clientDetail->client_id):''); ?></a>
                                </td>
                                <td class="table-user">
                                    <img src="<?php echo e($profile.'/'.$client->avatar); ?>" class="avatar rounded-circle mr-3 tbl-avatar">
                                    <b><?php echo e($client->name); ?></b>
                                </td>
                                <td><?php echo e($client->email); ?></td>
                                <td><?php echo e($client->phone); ?></td>
                                <td>
                                    <?php if($client->is_active == 0): ?>
                                    <span class="badge badge-danger"><?php echo e(__(\App\Client::$statues[$client->is_active])); ?></span>
                                    <?php elseif($client->is_active == 1): ?>
                                    <span class="badge badge-success"><?php echo e(__(\App\Client::$statues[$client->is_active])); ?></span>
                                    <?php endif; ?>
                                </td>
                                <td class="table-actions text-right">
                                    <a href="<?php echo e(route('client.show',\Crypt::encrypt($client->id))); ?>" class="table-action" data-toggle="tooltip" data-original-title="<?php echo e(__('View')); ?>">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="<?php echo e(route('client.edit',$client->id)); ?>" class="table-action" data-toggle="tooltip" data-original-title="<?php echo e(__('Edit')); ?>">
                                        <i class="far fa-edit"></i>
                                    </a>
                                    <a href="#!" class="table-action table-action-delete" data-toggle="tooltip" data-original-title="<?php echo e(__('Delete')); ?>" data-confirm="Are You Sure?|This action can not be undone. Do you want to continue?" data-confirm-yes="document.getElementById('delete-form-<?php echo e($client->id); ?>').submit();">
                                        <i class="fas fa-trash"></i>
                                    </a>
                                    <?php echo Form::open(['method' => 'DELETE', 'route' => ['client.destroy', $client->id],'id'=>'delete-form-'.$client->id]); ?>

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
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/mitaapps/public_html/dekomdmc/main_file/resources/views/client/index.blade.php ENDPATH**/ ?>