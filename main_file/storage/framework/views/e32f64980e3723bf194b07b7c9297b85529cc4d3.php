<?php $__env->startSection('page-title'); ?>
    <?php echo e(__('Attendance')); ?>

<?php $__env->stopSection(); ?>
<?php $__env->startPush('script-page'); ?>
    <script>
        $('#present_all').click(function (event) {
            if (this.checked) {
                $('.present').each(function () {
                    this.checked = true;
                });

                $('.present_check_in').removeClass('d-none');
                $('.present_check_in').addClass('d-block');

            } else {
                $('.present').each(function () {
                    this.checked = false;
                });
                $('.present_check_in').removeClass('d-block');
                $('.present_check_in').addClass('d-none');

            }
        });

        $('.present').click(function (event) {
            var div = $(this).parent().parent().parent().parent().find('.present_check_in');
            if (this.checked) {
                div.removeClass('d-none');
                div.addClass('d-block');

            } else {
                div.removeClass('d-block');
                div.addClass('d-none');
            }

        });


    </script>
    <script>
        $(document).ready(function () {
            $('.daterangepicker').daterangepicker({
                format: 'yyyy-mm-dd',
                locale: {format: 'YYYY-MM-DD'},
            });
        });
    </script>
<?php $__env->stopPush(); ?>
<?php $__env->startSection('breadcrumb'); ?>
    <h6 class="h2 d-inline-block mb-0"><?php echo e(__('Attendance')); ?></h6>
    <nav aria-label="breadcrumb" class="d-none d-md-inline-block ml-md-4">
        <ol class="breadcrumb breadcrumb-links">
            <li class="breadcrumb-item"><a href="#"><i class="fas fa-home"></i></a></li>
            <li class="breadcrumb-item"><a href="<?php echo e(route('dashboard')); ?>"><?php echo e(__('Dashboard')); ?></a></li>
            <li class="breadcrumb-item active" aria-current="page"><?php echo e(__('Attendance')); ?></li>
        </ol>
    </nav>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <?php echo e(Form::open(array('route' => array('bulk.attendance'),'method'=>'get'))); ?>

                        <div class="row mb-4">
                            <div class="col">
                                <h4 class="h4 mb-0"></h4>
                            </div>
                            <div class="col-md-2">
                                <?php echo e(Form::label('date',__('Date'))); ?>

                                <?php echo e(Form::date('date',isset($_GET['date'])?$_GET['date']:date('Y-m-d'),array('class'=>'form-control'))); ?>

                            </div>
                            <div class="col-md-2">
                                <?php echo e(Form::label('department', __('Department'))); ?>

                                <?php echo e(Form::select('department', $department,isset($_GET['department'])?$_GET['department']:'', array('class' => 'form-control custom-select','required'))); ?>

                            </div>
                            <div class="col-auto apply-btn">
                                <?php echo e(Form::submit(__('Apply'),array('class'=>'btn btn-outline-primary btn-sm'))); ?>

                            </div>
                        </div>
                        <?php echo e(Form::close()); ?>


                    </div>
                </div>
            </div>
            <div class="col">
                <div class="card">
                    <div class="table-responsive py-4">
                        <table class="table table-flush" id="">
                            <thead class="thead-light">
                            <tr>
                                <th width="10%"><?php echo e(__('Employee Id')); ?></th>
                                <th><?php echo e(__('Employee')); ?></th>
                                <th><?php echo e(__('Department')); ?></th>
                                <th>
                                    <div class="form-group">
                                        <div class="custom-control custom-checkbox">
                                            <input class="custom-control-input" type="checkbox" name="present_all" id="present_all" <?php echo e(old('remember') ? 'checked' : ''); ?>>
                                            <label class="custom-control-label" for="present_all"> <?php echo e(__('Attendance')); ?></label>
                                        </div>
                                    </div>
                                </th>
                            </tr>
                            </thead>

                            <?php echo e(Form::open(array('route'=>array('bulk.attendance'),'method'=>'post'))); ?>

                            <tbody>
                            <input type="hidden" value="<?php echo e(isset($_GET['date'])?$_GET['date']:date('Y-m-d')); ?>" name="date">
                            <input type="hidden" value="<?php echo e(isset($_GET['branch'])?$_GET['branch']:''); ?>" name="branch">
                            <input type="hidden" value="<?php echo e(isset($_GET['department'])?$_GET['department']:''); ?>" name="department">
                            <?php $__empty_1 = true; $__currentLoopData = $employees; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $employee): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                <?php

                                    $attendance=$employee->present_status($employee->user_id,isset($_GET['date'])?$_GET['date']:date('Y-m-d'));

                                ?>
                                <tr>
                                    <td>
                                        <input type="hidden" value="<?php echo e($employee->user_id); ?>" name="employee_id[]">
                                      <?php echo e(\Auth::user()->employeeIdFormat($employee->employee_id)); ?>

                                    </td>
                                    <td><?php echo e(!empty($employee->users)?$employee->users->name:''); ?></td>
                                    <td><?php echo e(!empty($employee->departments)?$employee->departments->name:''); ?></td>
                                    <td>
                                        <div class="row">
                                            <div class="col-md-1">
                                                <div class="form-group">
                                                    <div class="custom-control custom-checkbox">
                                                        <input class="custom-control-input present" type="checkbox" name="present-<?php echo e($employee->user_id); ?>" id="present<?php echo e($employee->user_id); ?>" <?php echo e((!empty($attendance)&&$attendance->status == 'Present') ? 'checked' : ''); ?>>
                                                        <label class="custom-control-label" for="present<?php echo e($employee->user_id); ?>"></label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-8 present_check_in <?php echo e(empty($attendance) ? 'd-none' : ''); ?> ">
                                                <div class="row">
                                                    <label class="col-md-2 control-label"><?php echo e(__('In')); ?></label>
                                                    <div class="col-md-4">
                                                        <input type="time" class="form-control" name="in-<?php echo e($employee->user_id); ?>" value="<?php echo e(!empty($attendance) && $attendance->clock_in!='00:00:00' ? $attendance->clock_in : \Utility::getValByName('company_start_time')); ?>">
                                                    </div>

                                                    <label for="inputValue" class="col-md-2 control-label"><?php echo e(__('Out')); ?></label>
                                                    <div class="col-md-4">
                                                        <input type="time" class="form-control" name="out-<?php echo e($employee->user_id); ?>" value="<?php echo e(!empty($attendance) &&  $attendance->clock_out !='00:00:00'? $attendance->clock_out : \Utility::getValByName('company_end_time')); ?>">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </td>

                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                <tr>
                                    <td colspan="6" class="text-center"><?php echo e(__('No data available in table')); ?></td>
                                </tr>
                            <?php endif; ?>

                            </tbody>
                            <div class="attendance-btn">
                                <?php echo e(Form::submit(__('Update'),array('class'=>'btn btn-primary'))); ?>

                            </div>
                            <?php echo e(Form::close()); ?>

                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>


<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/mitaapps/public_html/dekomdmc/main_file/resources/views/attendance/bulk.blade.php ENDPATH**/ ?>