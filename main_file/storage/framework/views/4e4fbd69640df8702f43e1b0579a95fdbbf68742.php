<?php
$profile=asset(Storage::url('uploads/avatar'));
?>
<?php $__env->startSection('page-title'); ?>
<?php echo e(__('Employee')); ?>

<?php $__env->stopSection(); ?>
<?php $__env->startSection('breadcrumb'); ?>
<h6 class="h2 d-inline-block mb-0"><?php echo e(__('Employee')); ?></h6>
<nav aria-label="breadcrumb" class="d-none d-md-inline-block ml-md-4">
    <ol class="breadcrumb breadcrumb-links">
        <li class="breadcrumb-item"><a href="#"><i class="fas fa-home"></i></a></li>
        <li class="breadcrumb-item"><a href="<?php echo e(route('dashboard')); ?>"><?php echo e(__('Dashboard')); ?></a></li>
        <li class="breadcrumb-item active" aria-current="page"><?php echo e(__('Employee')); ?></li>
    </ol>
</nav>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
<div class="container-fluid">
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <?php echo e(Form::open(array('url' => 'employee','method'=>'get'))); ?>

                    <div class="row">
                        <div class="col">
                            <h2 class="h3 mb-0"><?php echo e(__('Filter')); ?></h2>
                        </div>
                        <div class="col-md-2">
                            <?php echo e(Form::label('department', __('Department'))); ?>

                            <?php echo e(Form::select('department', $department,isset($_GET['department'])?$_GET['department']:'', array('class' => 'form-control custom-select'))); ?>

                        </div>
                        <div class="col-md-2">
                            <?php echo e(Form::label('designation', __('Designation'))); ?>

                            <?php echo e(Form::select('designation', $designation,isset($_GET['designation'])?$_GET['designation']:'', array('class' => 'form-control custom-select'))); ?>

                        </div>
                        <div class="col-auto apply-btn">
                            <?php echo e(Form::submit(__('Apply'),array('class'=>'btn btn-outline-primary btn-sm'))); ?>

                            <a href="<?php echo e(route('employee.index')); ?>" class="btn btn-outline-danger btn-sm"><?php echo e(__('Reset')); ?></a>
                        </div>
                    </div>
                    <?php echo e(Form::close()); ?>

                </div>
            </div>
        </div>
        <div class="col">
            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <div class="col">
                            <h2 class="h3 mb-0"><?php echo e(__('Manage Employees')); ?></h2>
                        </div>
                        <div class="col-auto">
                            <a href="#" data-url="<?php echo e(route('employee.create')); ?>" data-ajax-popup="true" data-title="<?php echo e(__('Create New Employee')); ?>" class="btn btn-outline-primary btn-sm">
                                <i class="fa fa-plus"></i> <?php echo e(__('Create')); ?>

                            </a>
                        </div>
                    </div>
                </div>
                <div class="table-responsive py-4">
                    <table class="table table-flush" id="datatable-basic">
                        <thead class="thead-light">
                            <tr>
                                <th>
                                    <div class="btn btn-primary btn-sm"><i class="fa fa-check"></i></div>
                                </th>
                                <th><?php echo e(__('Employee ID')); ?></th>
                                <th><?php echo e(__('Name')); ?></th>
                                <th><?php echo e(__('Email')); ?></th>
                                <th><?php echo e(__('Department')); ?></th>
                                <th><?php echo e(__('Designation')); ?></th>
                                <th><?php echo e(__('Salary')); ?></th>
                                <th class="text-right"><?php echo e(__('Action')); ?></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $__currentLoopData = $employees; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $employee): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

                            <tr>
                                <td class="select"></td>
                                <td><a href="<?php echo e(route('employee.show',\Crypt::encrypt($employee->id))); ?>" class="btn btn-sm btn-primary"> <?php echo e(!empty($employee->employeeDetail)? \Auth::user()->employeeIdFormat($employee->employeeDetail->employee_id):''); ?></a></td>
                                <td class="table-user">
                                    <img src="<?php echo e($profile.'/'.$employee->avatar); ?>" class="avatar rounded-circle mr-3 tbl-avatar">
                                    <b><?php echo e($employee->name); ?></b>
                                </td>
                                <td><?php echo e($employee->email); ?></td>
                                <td><?php echo e(!empty($employee->employeeDetail)? !empty($employee->employeeDetail->departments)?$employee->employeeDetail->departments->name:'':''); ?></td>
                                <td><?php echo e(!empty($employee->employeeDetail)? !empty($employee->employeeDetail->designations)?$employee->employeeDetail->designations->name:'':''); ?></td>
                                <td><?php echo e(!empty($employee->employeeDetail)? \Auth::user()->priceFormat($employee->employeeDetail->salary):''); ?></td>
                                <td class="table-actions text-right">
                                    <a href="<?php echo e(route('employee.show',\Crypt::encrypt($employee->id))); ?>" class="table-action" data-toggle="tooltip" data-original-title="<?php echo e(__('View')); ?>">
                                        <i class="fas fa-eye"></i>
                                    </a>

                                    <a href="<?php echo e(route('employee.edit',\Crypt::encrypt($employee->id))); ?>" class="table-action" data-toggle="tooltip" data-original-title="<?php echo e(__('Edit')); ?>">
                                        <i class="far fa-edit"></i>
                                    </a>

                                    <a href="<?php echo e(route('permission',$employee->id)); ?>" class="table-action" data-toggle="tooltip" data-original-title="<?php echo e(__('Permissions')); ?>">
                                        <i class="ni ni-settings-gear-65"></i>
                                    </a>

                                    <a href="#!" class="table-action table-action-delete" data-toggle="tooltip" data-original-title="<?php echo e(__('Delete')); ?>" data-confirm="Are You Sure?|This action can not be undone. Do you want to continue?" data-confirm-yes="document.getElementById('delete-form-<?php echo e($employee->id); ?>').submit();">
                                        <i class="fas fa-trash"></i>
                                    </a>
                                    <?php echo Form::open(['method' => 'DELETE', 'route' => ['employee.destroy', $employee->id],'id'=>'delete-form-'.$employee->id]); ?>

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
<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/mitaapps/public_html/dekomdmc/main_file/resources/views/employee/index.blade.php ENDPATH**/ ?>