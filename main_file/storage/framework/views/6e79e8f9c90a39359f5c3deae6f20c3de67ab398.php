<?php
$profile=asset(Storage::url('uploads/avatar/'));
?>
<?php $__env->startSection('page-title'); ?>
<?php echo e(__('Project')); ?>

<?php $__env->stopSection(); ?>
<?php $__env->startPush('css-page'); ?>
<?php $__env->stopPush(); ?>
<?php $__env->startSection('breadcrumb'); ?>
<h6 class="h2 d-inline-block mb-0"><?php echo e(__('Project')); ?></h6>
<nav aria-label="breadcrumb" class="d-none d-md-inline-block ml-md-4">
    <ol class="breadcrumb breadcrumb-links">
        <li class="breadcrumb-item"><a href="#"><i class="fas fa-home"></i></a></li>
        <li class="breadcrumb-item"><a href="<?php echo e(route('dashboard')); ?>"><?php echo e(__('Dashboard')); ?></a></li>
        <li class="breadcrumb-item active" aria-current="page"><?php echo e(__('Project')); ?></li>
    </ol>
</nav>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
<div class="container-fluid">
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <div class="col-6">
                            <h3 class="mb-0"><?php echo e(__('Manage Project')); ?></h3>
                        </div>
                        <?php if(\Auth::user()->type=='company'): ?>
                        <div class="col-6 text-right">
                            <span class="create-btn">
                                <a href="<?php echo e(route('project.create')); ?>" class="btn btn-outline-primary btn-sm">
                                    <i class="fa fa-plus"></i> <?php echo e(__('Create')); ?>

                                </a>
                            </span>
                        </div>
                        <?php endif; ?>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <?php $__empty_1 = true; $__currentLoopData = $projects; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $project): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <?php
                        $percentages=0;
                        $total=count($project->tasks);

                        if($total!=0){
                        $percentages= $project->completedTask() / ($total /100);
                        }
                        ?>
                        <div class="col-lg-6">
                            <div class="project-wrap">
                                <div class="project-body">
                                    <div>
                                        <a href="<?php echo e(route('project.show',\Crypt::encrypt($project->id))); ?>">
                                            <h4><?php echo e($project->title); ?></h4>
                                        </a>
                                        <?php if($project->status=='not_started'): ?>
                                        <span class="badge badge-primary"><?php echo e(__('Not Started')); ?></span>
                                        <?php elseif($project->status=='in_progress'): ?>
                                        <span class="badge badge-success"><?php echo e(__('In Progress')); ?></span>
                                        <?php elseif($project->status=='on_hold'): ?>
                                        <span class="badge badge-info"><?php echo e(__('On Hold')); ?></span>
                                        <?php elseif($project->status=='canceled'): ?>
                                        <span class="badge badge-danger"><?php echo e(__('Canceled')); ?></span>
                                        <?php elseif($project->status=='finished'): ?>
                                        <span class="badge badge-warning"><?php echo e(__('Finished')); ?></span>
                                        <?php endif; ?>

                                        <div class="tx-gray-500 small mt-1"><?php echo e(count($project->tasks)); ?> <?php echo e(__('opened tasks')); ?>, <?php echo e($project->completedTask()); ?> <?php echo e(__('tasks completed')); ?></div>
                                    </div>
                                    <?php if(\Auth::user()->type=='company'): ?>
                                    <div class="project-actions custom-menu-dropdown">
                                        <a class="dropdown" data-toggle="dropdown" aria-expanded="false">
                                            <i class="fas fa-ellipsis-v"></i>
                                        </a>
                                        <div class="dropdown-menu dropdown-menu-right">

                                            <a href="<?php echo e(route('project.edit',\Crypt::encrypt($project->id))); ?>" class="dropdown-item">
                                                <i class="far fa-edit"></i>
                                                <?php echo e(__('Edit')); ?>

                                            </a>
                                            <a href="<?php echo e(route('project.show',\Crypt::encrypt($project->id))); ?>" class="dropdown-item">
                                                <i class="fas fa-view"></i>
                                                <?php echo e(__('Show')); ?>

                                            </a>
                                            <a href="#" class="dropdown-item" data-confirm="Are You Sure?|This action can not be undone. Do you want to continue?" data-confirm-yes="document.getElementById('delete-form-<?php echo e($project->id); ?>').submit();">
                                                <i class="fas fa-trash"></i>
                                                <?php echo e(__('Delete')); ?>

                                            </a>
                                            <?php echo Form::open(['method' => 'DELETE', 'route' => ['project.destroy', $project->id],'id'=>'delete-form-'.$project->id]); ?>

                                            <?php echo Form::close(); ?>

                                        </div>
                                    </div>
                                    <?php endif; ?>
                                </div>
                                <div class="progress m-0" style="height: 3px;">
                                    <div class="progress-bar bg-primary" style="width: <?php echo e($percentages); ?>%;"></div>
                                </div>
                                <div class="progreess-status mt-3">
                                    <strong><?php echo e($percentages); ?>%</strong>&nbsp;<?php echo e(__('completed')); ?>

                                </div>
                                <div class="project-text">
                                    <?php echo e($project->description); ?>

                                </div>
                                <div class="project-details">
                                    <div class="row">
                                        <div class="col">
                                            <div class="tx-gray-500 small"><?php echo e(__('Start Date')); ?></div>
                                            <div class="font-weight-bold"><?php echo e(\Auth::user()->dateFormat($project->start_date)); ?></div>
                                        </div>
                                        <div class="col">
                                            <div class="tx-gray-500 small"><?php echo e(__('Due Date')); ?></div>
                                            <div class="font-weight-bold"><?php echo e(\Auth::user()->dateFormat($project->due_date)); ?></div>
                                        </div>
                                        <div class="col">
                                            <div class="tx-gray-500 small"><?php echo e(__('Budget')); ?></div>
                                            <div class="font-weight-bold"><?php echo e(\Auth::user()->priceFormat($project->price)); ?></div>
                                        </div>
                                        <div class="col">
                                            <div class="tx-gray-500 small"><?php echo e(__('Expense')); ?></div>
                                            <div class="font-weight-bold"><?php echo e(\Auth::user()->priceFormat($project->totalExpense())); ?></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="project-footer">
                                    <div class="project-footer-item">
                                        <div class="team">
                                            <div class="tx-gray-500 small mb-2"><?php echo e(__('Team Member')); ?></div>
                                            <div class="d-flex flex-wrap team-avatar">
                                                <?php $__currentLoopData = $project->projectUser(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $projectUser): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <a href="" class="d-block mr-1 mb-1">
                                                    <img width="30" src="<?php echo e((!empty($projectUser->avatar)? $profile.'/'.$projectUser->avatar :  $profile.'/avatar.png')); ?>" alt="" class="wd-30 rounded-circle" data-toggle="tooltip" data-placement="top" title="" data-original-title="<?php echo e((!empty($projectUser)?$projectUser->name:'')); ?>">
                                                </a>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            </div>
                                        </div>
                                        <?php
                                        $client=(!empty($project->clients)?$project->clients->avatar:'')
                                        ?>
                                        <div class="client">
                                            <div class="tx-gray-500 small mb-2"><?php echo e(__('Client')); ?></div>
                                            <div class="d-flex flex-wrap team-avatar">
                                                <a href="" class="d-block mr-1 mb-1">
                                                    <img width="30" src="<?php echo e((!empty($client)?  $profile.'/'.$client : $profile.'/avatar.png')); ?>" alt="" class="wd-30 rounded-circle mg-l--10" data-toggle="tooltip" data-placement="top" title="" data-original-title="<?php echo e(!empty($project->clients)?$project->clients->name:''); ?>">
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <div class="col-md-12 text-center">
                            <h4><?php echo e(__('No data available')); ?></h4>
                        </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/mitaapps/public_html/dekomdmc/main_file/resources/views/project/index.blade.php ENDPATH**/ ?>