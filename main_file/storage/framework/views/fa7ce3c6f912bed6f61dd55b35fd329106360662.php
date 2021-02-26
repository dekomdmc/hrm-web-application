<?php
    $profile=asset(Storage::url('uploads/avatar'));
?>
<?php $__env->startSection('page-title'); ?>
    <?php echo e(__('Employee')); ?>

<?php $__env->stopSection(); ?>
<?php $__env->startPush('css-page'); ?>
<?php $__env->stopPush(); ?>
<?php $__env->startPush('script-page'); ?>
<?php $__env->stopPush(); ?>
<?php $__env->startSection('breadcrumb'); ?>
    <h6 class="h2 d-inline-block mb-0"><?php echo e(\Auth::user()->employeeIdFormat($employee->employee_id)."'s Detail"); ?></h6>
    <nav aria-label="breadcrumb" class="d-none d-md-inline-block ml-md-4">
        <ol class="breadcrumb breadcrumb-links">
            <li class="breadcrumb-item"><a href="#"><i class="fas fa-home"></i></a></li>
            <li class="breadcrumb-item"><a href="<?php echo e(route('dashboard')); ?>"><?php echo e(__('Dashboard')); ?></a></li>
            <li class="breadcrumb-item"><a href="<?php echo e(route('employee.index')); ?>"><?php echo e(__('Employee')); ?></a></li>
            <li class="breadcrumb-item active" aria-current="page"><?php echo e(__('View')); ?></li>
        </ol>
    </nav>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
    <div class="container-fluid">
        <div class="card">
            <div class="card-body">
                <div class="row custmer-detail-wrap">
                    <div class="col-md-6">
                        <h2 class="sub-title col"><?php echo e(__('Personal Detail')); ?></h2>
                        <div class="row mb-10">
                            <div class="col">
                                <h3 class="mb-0"><?php echo e(__('Name')); ?> </h3>  <?php echo e($user->name); ?>

                            </div>
                        </div>
                        <div class="row mb-10">
                            <div class="col">
                                <h3 class="mb-0"><?php echo e(__('ID')); ?> </h3> <?php echo e(\Auth::user()->employeeIdFormat($employee->employee_id)); ?>

                            </div>
                            <div class="col">
                                <h3 class="mb-0"><?php echo e(__('Date of Birth')); ?> </h3>   <?php echo e(\Auth::user()->dateFormat($employee->dob)); ?>

                            </div>
                        </div>
                        <div class="row mb-10">
                            <div class="col">
                                <h3 class="mb-0"><?php echo e(__('Mobile')); ?> </h3> <?php echo e($employee->mobile); ?>

                            </div>
                            <div class="col">
                                <h4 class="mb-0"><?php echo e(__('Gender')); ?> </h4>   <?php echo e($employee->gender); ?>

                            </div>
                        </div>
                        <div class="row mb-10">
                            <div class="col">
                                <h4 class="mb-0"><?php echo e(__('Address')); ?> </h4>  <?php echo e($employee->address); ?>

                            </div>
                        </div>

                    </div>
                    <div class="col-md-6">
                        <h2 class="sub-title"><?php echo e(__('Company Detail')); ?></h2>
                        <div class="row mb-10">
                            <div class="col">
                                <h3 class="mb-0"><?php echo e(__('Department')); ?> </h3> <?php echo e(!empty($employee->departments)?$employee->departments->name:''); ?>

                            </div>
                            <div class="col">
                                <h3 class="mb-0"><?php echo e(__('Designation')); ?> </h3> <?php echo e(!empty($employee->designations)?$employee->designations->name:''); ?>

                            </div>
                        </div>
                        <div class="row mb-10">
                            <div class="col">
                                <h3 class="mb-0"><?php echo e(__('Date of Joining')); ?> </h3> <?php echo e(\Auth::user()->dateFormat($employee->joining_date)); ?>

                            </div>
                            <div class="col">
                                <h3 class="mb-0"><?php echo e(__('Salary Type')); ?> </h3><?php echo e(!empty($employee->salaryType)?$employee->salaryType->name:''); ?>

                            </div>
                        </div>
                        <div class="row mb-10">
                            <div class="col">
                                <h3 class="mb-0"><?php echo e(__('Salary')); ?> </h3> <?php echo e(\Auth::user()->priceFormat($employee->salary)); ?>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>


<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/mitaapps/public_html/dekomdmc/main_file/resources/views/employee/view.blade.php ENDPATH**/ ?>