<?php $__env->startPush('script-page'); ?>
    <script>


        var PieChart = (function () {

            var $chart = $('#chart-project');

            function init($this) {
                var randomScalingFactor = function () {
                    return Math.round(Math.random() * 100);
                };

                var pieChart = new Chart($this, {
                    type: 'pie',
                    data: {
                        labels: <?php echo json_encode($data['projectLabel']); ?>,
                        datasets: [{
                            data: <?php echo json_encode($data['projectData']); ?>,
                            backgroundColor: ['#11cdef', '#172b4d', '#5e72e4', '#2dce89', '#fb6340'],
                            label: 'Project'
                        }],
                    },
                    options: {
                        responsive: true,
                        legend: {
                            position: 'top',
                        },
                        animation: {
                            animateScale: true,
                            animateRotate: true
                        }
                    }
                });

                $this.data('chart', pieChart);

            };

            if ($chart.length) {
                init($chart);
            }

        })();

    </script>
<?php $__env->stopPush(); ?>
<?php $__env->startSection('page-title'); ?>
    <?php echo e(__('Dashboard')); ?>

<?php $__env->stopSection(); ?>
<?php $__env->startSection('breadcrumb'); ?>
    <h6 class="h2 d-inline-block mb-0"><?php echo e(__('Dashboard')); ?></h6>
    <nav aria-label="breadcrumb" class="d-none d-md-inline-block ml-md-4">
        <ol class="breadcrumb breadcrumb-links">
            <li class="breadcrumb-item"><a href="#"><i class="fas fa-home"></i></a></li>
            <li class="breadcrumb-item"><a href="#"><?php echo e(__('Dashboard')); ?></a></li>
        </ol>
    </nav>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
    <div class="container-fluid">
        <?php if(\Auth::user()->type=='company'): ?>
            <div class="row">

                <?php if($data['pipelines']<=0): ?>
                    <div class="col-3">
                        <div class="alert alert-danger">
                            <?php echo e(__('Please add constant pipeline.')); ?> <a href="<?php echo e(route('pipeline.index')); ?>"><b class="text-white"><?php echo e(__('click here')); ?></b></a>
                        </div>
                    </div>
                <?php endif; ?>
                <?php if($data['leadStages']<=0): ?>
                    <div class="col-3">
                        <div class="alert alert-danger">
                            <?php echo e(__('Please add constant lead stage.')); ?> <a href="<?php echo e(route('leadStage.index')); ?>"><b class="text-white"><?php echo e(__('click here')); ?></b></a>
                        </div>
                    </div>
                <?php endif; ?>
                <?php if($data['dealStages']<=0): ?>
                    <div class="col-3">
                        <div class="alert alert-danger">
                            <?php echo e(__('Please add constant deal stage.')); ?> <a href="<?php echo e(route('dealStage.index')); ?>"><b class="text-white"><?php echo e(__('click here')); ?></b></a>
                        </div>
                    </div>
                <?php endif; ?>
                <?php if($data['projectStages']<=0): ?>
                    <div class="col-3">
                        <div class="alert alert-danger">
                            <?php echo e(__('Please add constant project stage.')); ?> <a href="<?php echo e(route('projectStage.index')); ?>"><b class="text-white"><?php echo e(__('click here')); ?></b></a>
                        </div>
                    </div>
                <?php endif; ?>
            </div>
        <?php endif; ?>
        <div class="row">
            <?php if(\Auth::user()->type=='company'): ?>
                <div class="col-xl-3 col-md-6">
                    <div class="card bg-gradient-primary border-0">
                        <div class="card-body">
                            <div class="row">
                                <div class="col">
                                    <div class="row">
                                        <div class="col">
                                            <h5 class="card-title text-uppercase text-muted mb-0 text-white"><?php echo e(__('Total Clients')); ?></h5>
                                            <span class="h2 font-weight-bold mb-0 text-white"><?php echo e($data['totalClient']); ?></span>
                                        </div>
                                        <div class="col-auto">
                                            <div class="icon icon-shape bg-gradient-red text-white rounded-circle shadow">
                                                <i class="fas fa-users"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endif; ?>
            <?php if(\Auth::user()->type=='company'): ?>
                <div class="col-xl-3 col-md-6">
                    <div class="card bg-gradient-info border-0">
                        <!-- Card body -->
                        <div class="card-body">
                            <div class="row">
                                <div class="col">
                                    <div class="row">
                                        <div class="col">
                                            <h5 class="card-title text-uppercase text-muted mb-0 text-white"><?php echo e(__('Total Employees')); ?></h5>
                                            <span class="h2 font-weight-bold mb-0 text-white"><?php echo e($data['totalEmployee']); ?></span>
                                        </div>
                                        <div class="col-auto">
                                            <div class="icon icon-shape bg-gradient-orange text-white rounded-circle shadow">
                                                <i class="fas fa-users"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endif; ?>
            <?php if(\Auth::user()->type=='company' || \Auth::user()->type=='client' || \Auth::user()->type=='employee'): ?>
                <div class="col-xl-3 col-md-6">
                    <div class="card bg-gradient-danger border-0">
                        <!-- Card body -->
                        <div class="card-body">
                            <div class="row">
                                <div class="col">
                                    <div class="row">
                                        <div class="col">
                                            <h5 class="card-title text-uppercase text-muted mb-0 text-white"><?php echo e(__('Total Projects')); ?></h5>
                                            <span class="h2 font-weight-bold mb-0 text-white"><?php echo e($data['totalProject']); ?></span>
                                        </div>
                                        <div class="col-auto">
                                            <div class="icon icon-shape bg-gradient-green text-white rounded-circle shadow">
                                                <i class="ni ni-money-coins"></i>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endif; ?>
            <?php if(\Auth::user()->type=='company' || \Auth::user()->type=='client'): ?>
                <div class="col-xl-3 col-md-6">
                    <div class="card bg-gradient-default border-0">
                        <!-- Card body -->
                        <div class="card-body">
                            <div class="row">
                                <div class="col">
                                    <div class="row">
                                        <div class="col">
                                            <h5 class="card-title text-uppercase text-muted mb-0 text-white"><?php echo e(__('Total Estimation')); ?></h5>
                                            <span class="h2 font-weight-bold mb-0 text-white"><?php echo e($data['totalEstimation']); ?></span>
                                        </div>
                                        <div class="col-auto">
                                            <div class="icon icon-shape bg-gradient-info text-white rounded-circle shadow">
                                                <i class="ni ni-chart-bar-32"></i>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endif; ?>
            <?php if(\Auth::user()->type=='company' || \Auth::user()->type=='client'): ?>
                <div class="col-xl-3 col-md-6">
                    <div class="card <?php echo e((\Auth::user()->type=='company')?'bg-gradient-default':'bg-gradient-primary'); ?> border-0">
                        <!-- Card body -->
                        <div class="card-body">
                            <div class="row">
                                <div class="col">
                                    <div class="row">
                                        <div class="col">
                                            <h5 class="card-title text-uppercase text-muted mb-0 text-white"><?php echo e(__('Total Invoices')); ?></h5>
                                            <span class="h2 font-weight-bold mb-0 text-white"><?php echo e($data['totalInvoice']); ?></span>
                                        </div>
                                        <div class="col-auto">
                                            <div class="icon icon-shape bg-gradient-info text-white rounded-circle shadow">
                                                <i class="ni ni-chart-bar-32"></i>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endif; ?>
            <?php if(\Auth::user()->type=='company' || \Auth::user()->type=='employee'): ?>
                <div class="col-xl-3 col-md-6">
                    <div class="card <?php echo e((\Auth::user()->type=='employee')?'bg-gradient-primary':'bg-gradient-danger'); ?> border-0">
                        <!-- Card body -->
                        <div class="card-body">
                            <div class="row">
                                <div class="col">
                                    <div class="row">
                                        <div class="col">
                                            <h5 class="card-title text-uppercase text-muted mb-0 text-white"><?php echo e(__('Total Lead')); ?></h5>
                                            <span class="h2 font-weight-bold mb-0 text-white"><?php echo e($data['totalLead']); ?></span>
                                        </div>
                                        <div class="col-auto">
                                            <div class="icon icon-shape bg-gradient-green text-white rounded-circle shadow">
                                                <i class="ni ni-paper-diploma"></i>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endif; ?>
            <?php if(\Auth::user()->type=='company' || \Auth::user()->type=='client' || \Auth::user()->type=='employee'): ?>
                <div class="col-xl-3 col-md-6">
                    <div class="card bg-gradient-info border-0">
                        <!-- Card body -->
                        <div class="card-body">
                            <div class="row">
                                <div class="col">
                                    <div class="row">
                                        <div class="col">
                                            <h5 class="card-title text-uppercase text-muted mb-0 text-white"><?php echo e(__('Total Deal')); ?></h5>
                                            <span class="h2 font-weight-bold mb-0 text-white"><?php echo e($data['totalDeal']); ?></span>
                                        </div>
                                        <div class="col-auto">
                                            <div class="icon icon-shape bg-gradient-orange text-white rounded-circle shadow">
                                                <i class="ni ni-paper-diploma"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endif; ?>
            <?php if(\Auth::user()->type=='company'): ?>
                <div class="col-xl-3 col-md-6">
                    <div class="card bg-gradient-primary border-0">
                        <div class="card-body">
                            <div class="row">
                                <div class="col">
                                    <div class="row">
                                        <div class="col">
                                            <h5 class="card-title text-uppercase text-muted mb-0 text-white"><?php echo e(__('Total Items')); ?></h5>
                                            <span class="h2 font-weight-bold mb-0 text-white"><?php echo e($data['totalItem']); ?></span>
                                        </div>
                                        <div class="col-auto">
                                            <div class="icon icon-shape bg-gradient-red text-white rounded-circle shadow">
                                                <i class="ni ni-badge"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endif; ?>
        </div>

        <?php if(\Auth::user()->type=='company' || \Auth::user()->type=='client'): ?>
            <div class="row">
                <div class="col-md-6 col-lg-6 col-sm-6">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="h3 mb-0"><?php echo e(__('Estimation Overview')); ?></h5>
                        </div>
                        <div class="card-body" style="min-height: 402px;">
                            <?php $__empty_1 = true; $__currentLoopData = $data['estimationOverview']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $estimation): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                <div class="progress-wrapper">
                                    <div class="progress-info">
                                        <div class="progress-percentage">
                                            <?php echo e($estimation['status']); ?> <span> <?php echo e($estimation['total']); ?></span>
                                        </div>
                                        <div class="progress-percentage">
                                            <span><?php echo e($estimation['percentage']); ?>%</span>
                                        </div>
                                    </div>
                                    <div class="progress progress-xs mb-0">
                                        <div class="progress-bar <?php echo e($data['estimateOverviewColor'][$estimation['status']]); ?>" role="progressbar" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100" style="width: <?php echo e($estimation['percentage']); ?>%;"></div>
                                    </div>
                                </div>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                <div class="col-md-12 text-center">
                                    <h4><?php echo e(__('Estimation record not found')); ?></h4>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-lg-6 col-sm-6">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="h3 mb-0"><?php echo e(__('Invoice Overview')); ?></h5>
                        </div>
                        <div class="card-body">
                            <?php $__empty_1 = true; $__currentLoopData = $data['invoiceOverview']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $invoice): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                <div class="progress-wrapper">
                                    <div class="progress-info">
                                        <div class="progress-percentage">
                                            <?php echo e($invoice['status']); ?> <span> <?php echo e($invoice['total']); ?></span>
                                        </div>
                                        <div class="progress-percentage">
                                            <span><?php echo e($invoice['percentage']); ?>%</span>
                                        </div>
                                    </div>
                                    <div class="progress progress-xs mb-0">
                                        <div class="progress-bar <?php echo e($data['invoiceOverviewColor'][$invoice['status']]); ?>" role="progressbar" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100" style="width: <?php echo e($invoice['percentage']); ?>%;"></div>
                                    </div>
                                </div>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                <div class="col-md-12 text-center">
                                    <h4><?php echo e(__('Invoice record not found')); ?></h4>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        <?php endif; ?>

        <div class="row">
            <?php if(\Auth::user()->type=='company' || \Auth::user()->type=='client' || \Auth::user()->type=='employee'): ?>
                <div class="col-xl-6">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="h3 mb-0"><?php echo e(__('Project Status')); ?></h5>
                        </div>
                        <div class="card-body top-payment-box">

                            <div class="chart">
                                <div class="chartjs-size-monitor">
                                    <div class="chartjs-size-monitor-expand">
                                        <div class=""></div>
                                    </div>
                                    <div class="chartjs-size-monitor-shrink">
                                        <div class=""></div>
                                    </div>
                                </div>
                                <canvas id="chart-project" class="chart-canvas chartjs-render-monitor" width="734" height="350" style="display: block; width: 734px; height: 350px;"></canvas>
                            </div>

                            <div class="project-details" style="margin-top: 15px;">
                                <div class="row">
                                    <?php $__empty_1 = true; $__currentLoopData = $data['projects']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $project): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                        <div class="col text-center">
                                            <div class="tx-gray-500 small"><?php echo e($project['status']); ?></div>
                                            <div class="font-weight-bold"><?php echo e($project['percentage'].'%'); ?></div>
                                        </div>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                        <div class="col-md-12 text-center">
                                            <h4><?php echo e(__('Project record not found')); ?></h4>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endif; ?>
            <?php if(\Auth::user()->type=='employee'): ?>
                <div class="col-xl-6">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="h3 mb-0"><?php echo e(__('Mark Attendance')); ?></h5>
                        </div>
                        <div class="card-body top-payment-box">
                            <center>
                                <div class="row">

                                    <div class="col-md-6 float-right border-right">
                                        <?php echo e(Form::open(array('route'=>array('employee.attendance'),'method'=>'post'))); ?>

                                        <?php if(empty($data['employeeAttendance']) || $data['employeeAttendance']->clock_out != '00:00:00'): ?>
                                            <?php echo e(Form::submit(__('CLOCK IN'),array('class'=>'btn btn-success','name'=>'in','value'=>'0','id'=>'clock_in'))); ?>

                                        <?php else: ?>
                                            <?php echo e(Form::submit(__('CLOCK IN'),array('class'=>'btn btn-success disabled','disabled','name'=>'in','value'=>'0','id'=>'clock_in'))); ?>

                                        <?php endif; ?>
                                        <?php echo e(Form::close()); ?>

                                    </div>
                                    <div class="col-md-6 float-left">
                                        <?php if(!empty($data['employeeAttendance']) && $data['employeeAttendance']->clock_out == '00:00:00'): ?>
                                            <?php echo e(Form::model($data['employeeAttendance'],array('route'=>array('attendance.update',$data['employeeAttendance']->id),'method' => 'PUT'))); ?>

                                            <?php echo e(Form::submit(__('CLOCK OUT'),array('class'=>'btn btn-danger','name'=>'out','value'=>'1','id'=>'clock_out'))); ?>

                                        <?php else: ?>
                                            <?php echo e(Form::submit(__('CLOCK OUT'),array('class'=>'btn btn-danger disabled','name'=>'out','disabled','value'=>'1','id'=>'clock_out'))); ?>

                                        <?php endif; ?>
                                        <?php echo e(Form::close()); ?>

                                    </div>
                                </div>
                            </center>
                        </div>
                    </div>
                </div>
            <?php endif; ?>
            <?php if(\Auth::user()->type=='company' || \Auth::user()->type=='client' ): ?>
                <div class="col-xl-6">

                    <div class="card widget-calendar">
                        <!-- Card header -->
                        <div class="card-header">
                            <div class="row align-items-center">
                                <div class="col-8">
                                    <!-- Title -->
                                    <h5 class="h3 mb-0"><?php echo e(__('Top Due Payment')); ?></h5>
                                </div>
                            </div>
                        </div>
                        <!-- Card body -->
                        <div class="card-body top-payment-box">
                            <!-- List group -->
                            <ul class="list-group list-group-flush list my--3">
                                <?php $__empty_1 = true; $__currentLoopData = $data['topDueInvoice']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $invoice): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                    <li class="list-group-item px-0">
                                        <div class="row align-items-center">
                                            <div class="col-xl-8">
                                                <h5 class="mb-0"><?php echo e(\Auth::user()->invoiceNumberFormat($invoice->invoice_id)); ?></h5>
                                                <small><?php echo e(__('Due Amount')); ?> <?php echo e(\Auth::user()->priceFormat($invoice->getDue())); ?></small>
                                            </div>
                                            <div class="col-xl-2">
                                                <small><?php echo e(\Auth::user()->dateFormat($invoice->due_date)); ?></small>
                                            </div>
                                            <div class="col-xl-2">
                                                <div class="div-actions">
                                                    <a href="<?php echo e(route('invoice.show',\Crypt::encrypt($invoice->id))); ?>">
                                                        <i class="far fa-eye"></i>
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </li>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                    <div class="col-md-12 text-center">
                                        <h4><?php echo e(__('Payment record not found')); ?></h4>
                                    </div>
                                <?php endif; ?>
                            </ul>
                        </div>
                    </div>
                </div>
            <?php endif; ?>
        </div>

        <div class="row">
            <?php if(\Auth::user()->type=='company' || \Auth::user()->type=='client' || \Auth::user()->type=='employee'): ?>
                <div class="<?php echo e((\Auth::user()->type == 'client') ? 'col-md-12':'col-md-6'); ?>">
                    <div class="card widget-calendar">
                        <div class="card-header">
                            <div class="row align-items-center">
                                <div class="col-8">
                                    <h5 class="h3 mb-0"><?php echo e(__('Top Due Project')); ?></h5>
                                </div>
                            </div>
                        </div>
                        <div class="card-body min-height">
                            <!-- List group -->
                            <ul class="list-group list-group-flush list my--3">
                                <?php $__empty_1 = true; $__currentLoopData = $data['topDueProject']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $project): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                    <li class="list-group-item px-0">
                                        <div class="row align-items-center">
                                            <div class="col-xl-8">
                                                <h5 class="mb-0"><?php echo e($project->title); ?></h5>
                                                <small> <?php echo e($project->dueTask()); ?> <?php echo e(__('Task Remain')); ?> </small>
                                            </div>
                                            <div class="col-xl-2">
                                                <small><?php echo e(\Auth::user()->dateFormat($project->due_date)); ?></small>
                                            </div>
                                            <div class="col-xl-2">
                                                <div class="div-actions">
                                                    <a href="<?php echo e(route('project.show',\Crypt::encrypt($project->id))); ?>">
                                                        <i class="far fa-eye"></i>
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </li>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                    <div class="col-md-12 text-center">
                                        <h4><?php echo e(__('Project record not found')); ?></h4>
                                    </div>
                                <?php endif; ?>
                            </ul>
                        </div>
                    </div>
                </div>
            <?php endif; ?>

            <?php if(\Auth::user()->type == 'company' || \Auth::user()->type == 'employee'): ?>
                <div class="col-xl-6">
                    <div class="card widget-calendar">
                        <div class="card-header">
                            <div class="row align-items-center">
                                <div class="col-8">
                                    <h5 class="h3 mb-0"><?php echo e(__('Top Due Task')); ?></h5>
                                </div>
                            </div>
                        </div>

                        <div class="card-body min-height">
                            <ul class="list-group list-group-flush list my--3">
                                <?php $__empty_1 = true; $__currentLoopData = $data['topDueTask']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $topDueTask): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                    <li class="list-group-item px-0">
                                        <div class="row align-items-center">
                                            <div class="col-xl-6">
                                                <h5 class="mb-0"><?php echo e($topDueTask->title); ?></h5>
                                                <small><?php echo e(__('Assign to')); ?> <?php echo e(!empty($topDueTask->taskUser)?$topDueTask->taskUser->name  :''); ?></small>
                                            </div>
                                            <div class="col-xl-2">
                                                <small><?php echo e($topDueTask->project_title); ?></small>
                                            </div>
                                            <div class="col-xl-2">
                                                <small><?php echo e(\Auth::user()->dateFormat($topDueTask->due_date)); ?></small>
                                            </div>
                                            <div class="col-xl-2">
                                                <div class="div-actions">
                                                    <a href="<?php echo e(route('project.show',\Crypt::encrypt($topDueTask->project_id))); ?>">
                                                        <i class="far fa-eye"></i>
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </li>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                    <div class="col-md-12 text-center">
                                        <h4><?php echo e(__('Task record not found')); ?></h4>
                                    </div>
                                <?php endif; ?>
                            </ul>
                        </div>

                    </div>
                </div>
            <?php endif; ?>

            <?php if(\Auth::user()->type=='company' || \Auth::user()->type == 'employee'): ?>
                <div class="col-xl-6">
                    <div class="card widget-calendar">
                        <div class="card-header">
                            <div class="row align-items-center">
                                <div class="col-8">
                                    <!-- Title -->
                                    <h5 class="h3 mb-0"><?php echo e(__('Meeting Schedule')); ?></h5>
                                </div>
                            </div>
                        </div>
                        <!-- Card body -->
                        <div class="card-body min-height">
                            <ul class="list-group list-group-flush list my--3">
                                <?php $__empty_1 = true; $__currentLoopData = $data['topMeeting']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $meeting): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                    <li class="list-group-item px-0">
                                        <div class="row align-items-center">
                                            <div class="col-xl-6">
                                                <h5 class="mb-0"><?php echo e($meeting->title); ?></h5>
                                                <small><?php echo e($meeting->date.' '.$meeting->time); ?></small>
                                            </div>
                                            <div class="col-xl-6 text-right">
                                                <small><?php echo e($meeting->notes); ?></small>
                                            </div>
                                        </div>
                                    </li>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                    <div class="col-md-12 text-center">
                                        <h4><?php echo e(__('Meeting record not found')); ?></h4>
                                    </div>
                                <?php endif; ?>
                            </ul>
                        </div>
                    </div>
                </div>
            <?php endif; ?>

            <?php if(\Auth::user()->type=='company' || \Auth::user()->type == 'employee'): ?>
                <div class="col-xl-6">
                    <div class="card widget-calendar">
                        <!-- Card header -->
                        <div class="card-header">
                            <div class="row align-items-center">
                                <div class="col-8">
                                    <!-- Title -->
                                    <h5 class="h3 mb-0"><?php echo e(__('This Week Event')); ?></h5>
                                </div>
                            </div>
                        </div>
                        <!-- Card body -->
                        <div class="card-body min-height">
                            <ul class="list-group list-group-flush list my--3">
                                <?php $__empty_1 = true; $__currentLoopData = $data['thisWeekEvent']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $event): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                    <li class="list-group-item px-0">
                                        <div class="row align-items-center">
                                            <div class="col-xl-2">
                                                <h5 class="mb-0"><?php echo e($event->name); ?></h5>
                                            </div>
                                            <div class="col-xl-3">
                                                <small><?php echo e($event->start_date.' '.$event->start_time); ?></small>
                                            </div>
                                            <div class="col-xl-3">
                                                <small><?php echo e($event->end_date.' '.$event->end_time); ?></small>
                                            </div>
                                            <div class="col-xl-4 text-right">
                                                <small><?php echo e($event->description); ?></small>
                                            </div>
                                        </div>
                                    </li>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                    <div class="col-md-12 text-center">
                                        <h4><?php echo e(__('Event record not found')); ?></h4>
                                    </div>
                                <?php endif; ?>
                            </ul>
                        </div>
                    </div>
                </div>
            <?php endif; ?>

            <?php if(\Auth::user()->type=='company' || \Auth::user()->type=='client'): ?>
                <div class="col-xl-12">
                    <div class="card widget-calendar">
                        <!-- Card header -->
                        <div class="card-header">
                            <div class="row align-items-center">
                                <div class="col-8">
                                    <!-- Title -->
                                    <h5 class="h3 mb-0"><?php echo e(__('Contracts Expiring Soon')); ?></h5>
                                </div>
                            </div>
                        </div>
                        <div class="table-responsive py-4">
                            <table class="table table-flush" id="datatable-basic">
                                <thead class="thead-light">
                                <tr>
                                    <th><?php echo e(__('Subject')); ?></th>
                                    <th> <?php echo e(__('Client')); ?></th>
                                    <th><?php echo e(__('Contract Type')); ?></th>
                                    <th><?php echo e(__('Contract Value')); ?></th>
                                    <th><?php echo e(__('Start Date')); ?></th>
                                    <th><?php echo e(__('End Date')); ?></th>
                                </tr>
                                </thead>

                                <tbody>
                                <?php $__currentLoopData = $data['contractExpirySoon']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $contract): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

                                    <tr class="font-style">
                                        <td><?php echo e($contract->subject); ?></td>
                                        <td><?php echo e(!empty($contract->clients)?$contract->clients->name:''); ?></td>
                                        <td><?php echo e(!empty($contract->types)?$contract->types->name:''); ?></td>
                                        <td><?php echo e(\Auth::user()->priceFormat($contract->value)); ?></td>
                                        <td><?php echo e(\Auth::user()->dateFormat($contract->start_date )); ?></td>
                                        <td><?php echo e(\Auth::user()->dateFormat($contract->end_date )); ?></td>
                                    </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            <?php endif; ?>

            <?php if(\Auth::user()->type=='company'): ?>
                <div class="col-xl-6">
                    <div class="card widget-calendar">
                        <!-- Card header -->
                        <div class="card-header">
                            <div class="row align-items-center">
                                <div class="col-8">
                                    <!-- Title -->
                                    <h5 class="h3 mb-0"><?php echo e(__('New Support')); ?></h5>
                                </div>
                            </div>
                        </div>
                        <!-- Card body -->
                        <div class="card-body min-height">
                            <ul class="list-group list-group-flush list my--3">
                                <?php $__empty_1 = true; $__currentLoopData = $data['newTickets']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $ticket): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                    <li class="list-group-item px-0">
                                        <div class="row align-items-center">
                                            <div class="col-xl-12">
                                                <a href="<?php echo e(route('support.reply',\Crypt::encrypt($ticket->id))); ?>"><h5 class="mb-0"><?php echo e($ticket->subject); ?></h5></a>
                                                <small><?php echo e(\Auth::user()->dateFormat($ticket->created_at)); ?></small>
                                            </div>
                                        </div>
                                    </li>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                    <div class="col-md-12 text-center">
                                        <h4><?php echo e(__('Support record not found')); ?></h4>
                                    </div>
                                <?php endif; ?>
                            </ul>
                        </div>
                    </div>
                </div>
            <?php endif; ?>

            <?php if(\Auth::user()->type=='company'): ?>
                <div class="col-xl-6">
                    <div class="card widget-calendar">
                        <!-- Card header -->
                        <div class="card-header">
                            <div class="row align-items-center">
                                <div class="col-8">
                                    <!-- Title -->
                                    <h5 class="h3 mb-0"><?php echo e(__('New Client')); ?></h5>
                                </div>
                            </div>
                        </div>
                        <!-- Card body -->
                        <div class="card-body min-height">
                            <ul class="list-group list-group-flush list my--3">
                                <?php $__empty_1 = true; $__currentLoopData = $data['newClients']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $client): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>

                                    <li class="list-group-item px-0">
                                        <div class="row align-items-center">
                                            <div class="col-xl-2">
                                                <img src="<?php echo e(asset(Storage::url('uploads/avatar')).'/'.$client->avatar); ?>" class="avatar rounded-circle mr-3">
                                            </div>
                                            <div class="col-xl-6">
                                                <h5 class="mb-0"><?php echo e($client->name); ?></h5>
                                                <small><?php echo e(\Auth::user()->dateFormat($client->created_at)); ?></small>
                                            </div>
                                            <div class="col-xl-4">
                                                <h5 class="mb-0"><?php echo e($client->email); ?></h5>
                                            </div>
                                        </div>
                                    </li>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                    <div class="col-md-12 text-center">
                                        <h4><?php echo e(__('Client record not found')); ?></h4>
                                    </div>
                                <?php endif; ?>
                            </ul>
                        </div>
                    </div>
                </div>
            <?php endif; ?>

            <?php if(\Auth::user()->type=='company'): ?>
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h4><?php echo e(__('Goal')); ?></h4>
                        </div>
                        <div class="card-body">

                            <?php $__empty_1 = true; $__currentLoopData = $data['goals']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $goal): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                <?php

                                    $total= $goal->target($goal->goal_type,$goal->from,$goal->to,$goal->amount)['total'];
                                $percentage=$goal->target($goal->goal_type,$goal->from,$goal->to,$goal->amount)['percentage'];
                                ?>
                                <div class="col-12">
                                    <div class="card card-statistic-1 card-statistic-2">
                                        <div class="card-wrap">
                                            <div class="row">
                                                <div class="col-xs-12 col-sm-12 col-md-2">
                                                    <div class="card-header">
                                                        <h4><?php echo e(__('Name')); ?></h4>
                                                    </div>
                                                    <div class="card-body">
                                                        <?php echo e($goal->name); ?>

                                                    </div>
                                                </div>
                                                <div class="col-xs-12 col-sm-12 col-md-2">
                                                    <div class="card-header">
                                                        <h4><?php echo e(__('Type')); ?></h4>
                                                    </div>
                                                    <div class="card-body">
                                                        <?php echo e(__(\App\Goal::$goalType[$goal->goal_type])); ?>

                                                    </div>
                                                </div>
                                                <div class="col-xs-12 col-sm-12 col-md-3">
                                                    <div class="card-header">
                                                        <h4><?php echo e(__('Duration')); ?></h4>
                                                    </div>
                                                    <div class="card-body">
                                                        <?php echo e($goal->from .' To '.$goal->to); ?>

                                                    </div>
                                                </div>

                                                <div class="col-xs-12 col-sm-12 col-md-5">
                                                    <div class="card-header">
                                                        <div class="row">
                                                            <div class="col-9">
                                                                <?php echo e(\Auth::user()->priceFormat($total).' of '. \Auth::user()->priceFormat($goal->amount)); ?>

                                                            </div>
                                                            <div class="col-auto">
                                                                <?php echo e(number_format($percentage, 2, '.', '')); ?>%
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="card-body">
                                                        <div class="progress">
                                                            <div class="progress-bar bg-warning" style="width:<?php echo e(number_format($goal->target($goal->goal_type,$goal->from,$goal->to,$goal->amount)['percentage'], 2, '.', '')); ?>%"></div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                <tr>
                                    <td colspan="6">
                                        <div class="text-center">
                                            <h4><?php echo e(__('Goal record not found')); ?></h4>
                                        </div>
                                    </td>
                                </tr>
                            <?php endif; ?>

                        </div>
                    </div>
                </div>
            <?php endif; ?>

        </div>

    </div>
<?php $__env->stopSection(); ?>


<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/mitaapps/public_html/dekomdmc/main_file/resources/views/dashboard/index.blade.php ENDPATH**/ ?>