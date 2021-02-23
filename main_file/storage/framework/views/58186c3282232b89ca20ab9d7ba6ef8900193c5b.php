<?php
$logo=asset(Storage::url('uploads/logo/'));
$company_logo=Utility::getValByName('company_logo');
$company_small_logo=Utility::getValByName('company_small_logo');
?>
<nav class="sidenav navbar navbar-vertical fixed-left navbar-expand-xs navbar-light bg-white" id="sidenav-main">
    <div class="scrollbar-inner">
        <!-- Brand -->
        <div class="sidenav-header d-flex align-items-center">
            <a class="navbar-brand" href="<?php echo e(route('dashboard')); ?>">
                <img class="img-fluid" src="<?php echo e($logo.'/'.(isset($company_logo) && !empty($company_logo)?$company_logo:'logo.png')); ?>" alt="">
            </a>
            <div class="ml-auto">
                <div class="sidenav-toggler d-none d-xl-block" data-action="sidenav-unpin" data-target="#sidenav-main">
                    <div class="sidenav-toggler-inner">
                        <i class="sidenav-toggler-line"></i>
                        <i class="sidenav-toggler-line"></i>
                        <i class="sidenav-toggler-line"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="navbar-inner">
            <!-- Collapse -->
            <div class="collapse navbar-collapse" id="sidenav-collapse-main">
                <ul class="navbar-nav">

                    <li class="nav-item">
                        <a class="nav-link nav-toggle <?php echo e((Request::segment(1) == 'dashboard' || Request::segment(1) == '')?'active':''); ?>" href="<?php echo e(route('dashboard')); ?>">
                            <i class="ni ni-shop text-primary"></i>
                            <span class="nav-link-text"><?php echo e(__('Dashboard')); ?></span>
                        </a>
                    </li>
                    <?php if(\Auth::user()->type == 'super admin'): ?>
                    <li class="nav-item ">
                        <a class="nav-link nav-toggle <?php echo e((Request::segment(1) == 'users')?'active':''); ?>" href="<?php echo e(route('users.index')); ?>">
                            <i class="fas fa-users text-primary"></i>
                            <span class="nav-link-text"><?php echo e(__('User')); ?></span>
                        </a>
                    </li>
                    <?php endif; ?>
                    <?php if(\Auth::user()->type=='company'): ?>

                    <?php elseif(\Auth::user()->type=='employee'): ?>
                    <li class="nav-item ">
                        <a class="nav-link nav-toggle <?php echo e((Request::segment(1) == 'employee')?'active':''); ?>" href="<?php echo e(route('employee.show',\Crypt::encrypt(\Auth::user()->id))); ?>">
                            <i class="ni ni-single-02 text-pink"></i>
                            <span class="nav-link-text"><?php echo e(__('My Profile')); ?></span>
                        </a>
                    </li>
                    <?php elseif(\Auth::user()->type=='client'): ?>
                    <li class="nav-item ">
                        <a class="nav-link nav-toggle <?php echo e((Request::segment(1) == 'client')?'active':''); ?>" href="<?php echo e(route('client.show',\Crypt::encrypt(\Auth::user()->id))); ?>">
                            <i class="ni ni-single-02 text-pink"></i>
                            <span class="nav-link-text"><?php echo e(__('My Profile')); ?></span>
                        </a>
                    </li>
                    <?php endif; ?>

                    <?php if(\Auth::user()->type=='company' || \Auth::user()->type=='employee'): ?>
                    <li class="nav-item ">
                        <a class="nav-link <?php echo e((Request::segment(1) == 'attendance' || Request::segment(1) == 'holiday' || Request::segment(1) == 'leave' || Request::segment(1) == 'meeting' || Request::segment(1) == 'account-assets' || Request::segment(1) == 'document-upload'  || Request::segment(1) == 'company-policy' || Request::segment(1) == 'award' || Request::segment(1) == 'transfer' || Request::segment(1) == 'resignation' || Request::segment(1) == 'trip' || Request::segment(1) ==
                        'promotion'  || Request::segment(1) == 'complaint' || Request::segment(1) == 'warning' || Request::segment(1) == 'termination' || Request::segment(1) == 'indicator' || Request::segment(1) == 'appraisal' || Request::segment(1) == 'trainer' || Request::segment(1) == 'training' || Request::segment(1) == 'bulk-attendance')
                        ?'active':''); ?>" href="#hr" data-toggle="collapse" role="button" aria-expanded="<?php echo e((Request::segment(1) == 'attendance' || Request::segment(1) == 'holiday' || Request::segment(1) == 'leave' || Request::segment(1) == 'meeting' || Request::segment(1) == 'account-assets' || Request::segment(1) == 'document-upload'  || Request::segment(1) == 'company-policy' || Request::segment(1) == 'award' || Request::segment(1) == 'transfer' || Request::segment(1) ==
                            'resignation' || Request::segment(1) == 'trip' || Request::segment(1) == 'promotion'  || Request::segment(1) == 'complaint' || Request::segment(1) == 'warning' || Request::segment(1) == 'termination' || Request::segment(1) == 'indicator' || Request::segment(1) == 'appraisal' || Request::segment(1) == 'trainer' || Request::segment(1) == 'training' || Request::segment(1) == 'bulk-attendance')
                            ?'true':'false'); ?>" aria-controls="navbar-dashboards1">
                            <i class="ni ni-collection text-info"></i>
                            <span class="nav-link-text "><?php echo e(__('HR')); ?></span>
                        </a>
                        <div class="collapse <?php echo e((Request::segment(1) == 'attendance' || Request::segment(1) == 'holiday' || Request::segment(1) == 'leave' || Request::segment(1) == 'meeting' || Request::segment(1) == 'account-assets' || Request::segment(1) == 'document-upload'  || Request::segment(1) == 'company-policy' || Request::segment(1) == 'award' || Request::segment(1) == 'transfer' || Request::segment(1) == 'resignation' || Request::segment(1) == 'trip' || Request::segment(1) ==
                            'promotion' || Request::segment(1) == 'complaint' || Request::segment(1) == 'warning' || Request::segment(1) == 'termination' || Request::segment(1) == 'indicator' || Request::segment(1) == 'appraisal' || Request::segment(1) == 'trainer' || Request::segment(1) == 'training' || Request::segment(1) == 'bulk-attendance')?'show':''); ?>" id="hr">
                            <ul class="nav nav-sm flex-column">

                                <?php if(\Auth::user()->type == 'company'): ?>
                                <li class="nav-item <?php echo e((Request::segment(1) == 'employee')?'active open':''); ?>">
                                    <a href="<?php echo e(route('employee.index')); ?>" class="nav-link">
                                        <span class="nav-link-text"><?php echo e(__('Employee')); ?></span>
                                    </a>
                                </li>
                                <?php endif; ?>

                                <a class="nav-link" href="#performance" data-toggle="collapse" role="button" aria-expanded="<?php echo e((Request::segment(1) == 'attendance' || Request::segment(1) == 'bulk-attendance' )?'true':''); ?>" aria-controls="navbar-dashboards1">
                                    <span class="nav-link-text "><?php echo e(__('Attendance')); ?></span>
                                </a>
                                <div class="collapse <?php echo e((Request::segment(1) == 'attendance' || Request::segment(1) == 'bulk-attendance')?'show':''); ?>" id="performance">
                                    <ul class="nav nav-sm flex-column">
                                        <li class="nav-item <?php echo e((Request::segment(1) == 'attendance')?'active open':''); ?>">
                                            <a href="<?php echo e(route('attendance.index')); ?>" class="nav-link"><?php echo e(__('Attendance')); ?></a>
                                        </li>
                                        <li class="nav-item <?php echo e((Request::segment(1) == 'bulk-attendance')?'active open':''); ?>">
                                            <a href="<?php echo e(route('bulk.attendance')); ?>" class="nav-link"><?php echo e(__('Bulk Attendance')); ?></a>
                                        </li>
                                    </ul>
                                </div>
                                <li class="nav-item <?php echo e((Request::segment(1) == 'holiday')?'active open':''); ?>">
                                    <a href="<?php echo e(route('holiday.index')); ?>" class="nav-link"><?php echo e(__('Holiday')); ?></a>
                                </li>
                                <li class="nav-item <?php echo e((Request::segment(1) == 'leave')?'active open':''); ?>">
                                    <a href="<?php echo e(route('leave.index')); ?>" class="nav-link"><?php echo e(__('Leave')); ?></a>
                                </li>
                                <li class="nav-item <?php echo e((Request::segment(1) == 'meeting')?'active open':''); ?>">
                                    <a href="<?php echo e(route('meeting.index')); ?>" class="nav-link"><?php echo e(__('Meeting')); ?></a>
                                </li>
                                <li class="nav-item <?php echo e((Request::segment(1) == 'account-assets')?'active open':''); ?>">
                                    <a href="<?php echo e(route('account-assets.index')); ?>" class="nav-link"><?php echo e(__('Asset')); ?></a>
                                </li>
                                <li class="nav-item <?php echo e((Request::segment(1) == 'document-upload')?'active open':''); ?>">
                                    <a href="<?php echo e(route('document-upload.index')); ?>" class="nav-link"><?php echo e(__('Document')); ?></a>
                                </li>
                                <li class="nav-item <?php echo e((Request::segment(1) == 'company-policy')?'active open':''); ?>">
                                    <a href="<?php echo e(route('company-policy.index')); ?>" class="nav-link"><?php echo e(__('Company Policy')); ?></a>
                                </li>
                                <a class="nav-link" href="#inner-hr" data-toggle="collapse" role="button" aria-expanded="<?php echo e((Request::segment(1) == 'award' || Request::segment(1) == 'transfer' || Request::segment(1) == 'resignation' || Request::segment(1) == 'trip' || Request::segment(1) == 'promotion'  || Request::segment(1) == 'complaint' || Request::segment(1) == 'warning' || Request::segment(1) == 'termination' )?'true':''); ?>" aria-controls="navbar-dashboards1">
                                    <span class="nav-link-text "><?php echo e(__('HR')); ?></span>
                                </a>
                                <div class="collapse <?php echo e((Request::segment(1) == 'award' || Request::segment(1) == 'transfer' || Request::segment(1) == 'resignation' || Request::segment(1) == 'trip' || Request::segment(1) == 'promotion'  || Request::segment(1) == 'complaint' || Request::segment(1) == 'warning' || Request::segment(1) == 'termination')?'show':''); ?>" id="inner-hr">
                                    <ul class="nav nav-sm flex-column">
                                        <li class="nav-item <?php echo e((Request::segment(1) == 'award')?'active open':''); ?>">
                                            <a href="<?php echo e(route('award.index')); ?>" class="nav-link"><?php echo e(__('Award')); ?></a>
                                        </li>
                                        <li class="nav-item <?php echo e((Request::segment(1) == 'transfer')?'active open':''); ?>">
                                            <a href="<?php echo e(route('transfer.index')); ?>" class="nav-link"><?php echo e(__('Transfer')); ?></a>
                                        </li>
                                        <li class="nav-item <?php echo e((Request::segment(1) == 'resignation')?'active open':''); ?>">
                                            <a href="<?php echo e(route('resignation.index')); ?>" class="nav-link"><?php echo e(__('Resignation')); ?></a>
                                        </li>
                                        <li class="nav-item <?php echo e((Request::segment(1) == 'trip')?'active open':''); ?>">
                                            <a href="<?php echo e(route('trip.index')); ?>" class="nav-link"><?php echo e(__('Trip')); ?></a>
                                        </li>
                                        <li class="nav-item <?php echo e((Request::segment(1) == 'promotion')?'active open':''); ?>">
                                            <a href="<?php echo e(route('promotion.index')); ?>" class="nav-link"><?php echo e(__('Promotion')); ?></a>
                                        </li>
                                        <li class="nav-item <?php echo e((Request::segment(1) == 'complaint')?'active open':''); ?>">
                                            <a href="<?php echo e(route('complaint.index')); ?>" class="nav-link"><?php echo e(__('Complaints')); ?></a>
                                        </li>
                                        <li class="nav-item <?php echo e((Request::segment(1) == 'warning')?'active open':''); ?>">
                                            <a href="<?php echo e(route('warning.index')); ?>" class="nav-link"><?php echo e(__('Warning')); ?></a>
                                        </li>
                                        <li class="nav-item <?php echo e((Request::segment(1) == 'termination')?'active open':''); ?>">
                                            <a href="<?php echo e(route('termination.index')); ?>" class="nav-link"><?php echo e(__('Termination')); ?></a>
                                        </li>
                                    </ul>
                                </div>
                                <a class="nav-link" href="#performance" data-toggle="collapse" role="button" aria-expanded="<?php echo e((Request::segment(1) == 'indicator' || Request::segment(1) == 'appraisal' )?'true':''); ?>" aria-controls="navbar-dashboards1">
                                    <span class="nav-link-text "><?php echo e(__('Performance')); ?></span>
                                </a>
                                <div class="collapse <?php echo e((Request::segment(1) == 'indicator' || Request::segment(1) == 'appraisal')?'show':''); ?>" id="performance">
                                    <ul class="nav nav-sm flex-column">
                                        <li class="nav-item <?php echo e((Request::segment(1) == 'indicator')?'active open':''); ?>">
                                            <a href="<?php echo e(route('indicator.index')); ?>" class="nav-link"><?php echo e(__('Indicator')); ?></a>
                                        </li>
                                        <li class="nav-item <?php echo e((Request::segment(1) == 'appraisal')?'active open':''); ?>">
                                            <a href="<?php echo e(route('appraisal.index')); ?>" class="nav-link"><?php echo e(__('Appraisal')); ?></a>
                                        </li>
                                    </ul>
                                </div>
                                <a class="nav-link" href="#training-list" data-toggle="collapse" role="button" aria-expanded="<?php echo e((Request::segment(1) == 'trainer' || Request::segment(1) == 'training' )?'show':''); ?>" aria-controls="navbar-dashboards1">
                                    <span class="nav-link-text "><?php echo e(__('Training')); ?></span>
                                </a>
                                <div class="collapse <?php echo e((Request::segment(1) == 'training' || Request::segment(1) == 'trainer' || Request::segment(1) == 'training')?'show':''); ?>" id="training-list">
                                    <ul class="nav nav-sm flex-column">
                                        <li class="nav-item <?php echo e((Request::segment(1) == 'training')?'active open':''); ?>">
                                            <a href="<?php echo e(route('training.index')); ?>" class="nav-link"><?php echo e(__('Training List')); ?></a>
                                        </li>
                                        <li class="nav-item <?php echo e((Request::segment(1) == 'trainer')?'active open':''); ?>">
                                            <a href="<?php echo e(route('trainer.index')); ?>" class="nav-link"><?php echo e(__('Trainer')); ?></a>
                                        </li>
                                    </ul>
                                </div>
                            </ul>
                        </div>
                    </li>
                    <?php endif; ?>

                    <?php if(\Auth::user()->type=='company' || \Auth::user()->type=='employee' || \Auth::user()->type=='client'): ?>
                    <li class="nav-item ">
                        <a class="nav-link <?php echo e((Request::segment(1) == 'lead' || Request::segment(1) == 'deal' || Request::segment(1) == 'estimate')?'active':''); ?>" href="#presale" data-toggle="collapse" role="button" aria-expanded="<?php echo e((Request::segment(1) == 'lead' || Request::segment(1) == 'deal' || Request::segment(1) == 'estimate')?'true':'false'); ?>" aria-controls="navbar-dashboards1">
                            <i class="ni ni-cart text-primary"></i>
                            <span class="nav-link-text "><?php echo e(__('PreSale')); ?></span>
                        </a>
                        <div class="collapse <?php echo e((Request::segment(1) == 'lead' || Request::segment(1) == 'deal' || Request::segment(1) == 'estimate')?'show':''); ?>" id="presale">
                            <ul class="nav nav-sm flex-column">
                                <?php if(\Auth::user()->type=='company' || \Auth::user()->type=='employee'): ?>
                                <li class="nav-item <?php echo e((Request::segment(1) == 'lead')?'active open':''); ?>">
                                    <a href="<?php echo e(route('lead.index')); ?>" class="nav-link"><?php echo e(__('Lead')); ?></a>
                                </li>
                                <?php endif; ?>
                                <?php if(\Auth::user()->type=='company' || \Auth::user()->type=='client' || \Auth::user()->type=='employee'): ?>
                                <li class="nav-item <?php echo e((Request::segment(1) == 'deal')?'active open':''); ?>">
                                    <a href="<?php echo e(route('deal.index')); ?>" class="nav-link"><?php echo e(__('Deal')); ?></a>
                                </li>
                                <?php endif; ?>
                                <?php if(\Auth::user()->type=='company' || \Auth::user()->type=='client' || \Auth::user()->type=='employee'): ?>
                                <li class="nav-item <?php echo e((Request::segment(1) == 'estimate')?'active open':''); ?>">
                                    <a href="<?php echo e(route('estimate.index')); ?>" class="nav-link"><?php echo e(__('Estimate')); ?></a>
                                </li>
                                <?php endif; ?>
                            </ul>
                        </div>
                    </li>
                    <?php endif; ?>

                    <?php if(\Auth::user()->type=='company' || \Auth::user()->type=='client' || \Auth::user()->type=='employee'): ?>
                    <li class="nav-item ">
                        <a class="nav-link <?php echo e((Request::segment(1) == 'project')?'active':''); ?>" href="#navbar-dashboards1" data-toggle="collapse" role="button" aria-expanded="<?php echo e((Request::segment(1) == 'project' )?'true':'false'); ?>" aria-controls="navbar-dashboards1">
                            <i class="ni ni-collection text-pink"></i>
                            <span class="nav-link-text "><?php echo e(__('Project')); ?></span>
                        </a>
                        <div class="collapse <?php echo e((Request::segment(1) == 'project')?'show':''); ?>" id="navbar-dashboards1">
                            <ul class="nav nav-sm flex-column">

                                <li class="nav-item <?php echo e((Request::segment(1) == 'project' && Request::segment(2) != 'allTask' && Request::segment(2) != 'allTimesheet')?'active open':''); ?>">
                                    <a href="<?php echo e(route('project.index')); ?>" class="nav-link"><?php echo e(__('All Project')); ?></a>
                                </li>
                                <?php if(\Auth::user()->type=='company' || \Auth::user()->type=='employee'): ?>
                                <li class="nav-item <?php echo e((Request::segment(2) == 'allTask')?'active open':''); ?>">
                                    <a href="<?php echo e(route('project.all.task')); ?>" class="nav-link"><?php echo e(__('Task')); ?></a>
                                </li>
                                <?php endif; ?>
                                <?php if(\Auth::user()->type=='company' || \Auth::user()->type=='employee'): ?>
                                <li class="nav-item <?php echo e((Request::segment(2) == 'allTimesheet')?'active open':''); ?>">
                                    <a href="<?php echo e(route('project.all.timesheet')); ?>" class="nav-link"><?php echo e(__('Timesheets')); ?></a>
                                </li>
                                <?php endif; ?>
                            </ul>
                        </div>
                    </li>
                    <?php endif; ?>
                    <?php if(\Auth::user()->type=='company'): ?>
                    <li class="collapse <?php echo e((Request::segment(1) == 'invoice')?'show':''); ?>">
                        <a class="nav-link nav-toggle <?php echo e((Request::segment(1) == 'item')?'active':''); ?>" href="<?php echo e(route('item.index')); ?>">
                            <i class="ni ni-badge text-info"></i>
                            <span class="nav-link-text"><?php echo e(__('Items')); ?></span>
                        </a>
                    </li>
                    <?php endif; ?>
                    <?php if(\Auth::user()->type=='company' || \Auth::user()->type=='employee'): ?>
                    <li class="nav-item ">
                        <a class="nav-link <?php echo e((Request::segment(1) == 'stock')?'active':''); ?>" href="#stock" data-toggle="collapse" role="button" aria-expanded="<?php echo e((Request::segment(1) == 'stock' )?'true':'false'); ?>" aria-controls="navbar-dashboards1">
                            <i class="ni ni-building text-pink"></i>
                            <span class="nav-link-text "><?php echo e(__('Stocks')); ?></span>
                        </a>
                        <div class="collapse <?php echo e((Request::segment(1) == 'stock')?'show':''); ?>" id="stock">
                            <ul class="nav nav-sm flex-column">
                                <li class="nav-item <?php echo e((Request::segment(1) == 'suppliers')?'active open':''); ?>">
                                    <a href="<?php echo e(route('supplier.index')); ?>" class="nav-link">
                                        <!-- <i class="ni ni-single-02 text-success"></i> -->
                                        <span class="nav-link-text"><?php echo e(__('Suppliers')); ?></span>
                                    </a>
                                </li>
                                <li class="nav-item <?php echo e((Request::segment(1) == 'purchaseinvoice')?'active open':''); ?>">
                                    <a href="<?php echo e(route('purchaseinvoice.index')); ?>" class="nav-link"><?php echo e(__('Purchase Invoice')); ?></a>
                                </li>
                                <li class="nav-item <?php echo e((Request::segment(1) == 'payment')?'active open':''); ?>">
                                    <a href="<?php echo e(route('payment.index')); ?>" class="nav-link"><?php echo e(__('Payment')); ?></a>
                                </li>
                                <li class="nav-item <?php echo e((Request::segment(1) == 'item')?'active':''); ?>">
                                    <a class="nav-link" href="<?php echo e(route('item.index')); ?>"><?php echo e(__('Stock Price List')); ?></a>
                                </li>
                                <?php if(\Auth::user()->type=='company'): ?>
                                <li class="nav-item <?php echo e((Request::segment(1) == 'expense')?'active open':''); ?>">
                                    <a href="<?php echo e(route('expense.index')); ?>" class="nav-link"><?php echo e(__('Expense')); ?></a>
                                </li>
                                <?php endif; ?>
                            </ul>
                        </div>
                    </li>
                    <?php endif; ?>
                    <?php if(\Auth::user()->type=='company' || \Auth::user()->type=='employee'): ?>
                    <li class="nav-item ">
                        <a class="nav-link <?php echo e((Request::segment(1) == 'invoice' || Request::segment(1) == 'payment' || Request::segment(1) == 'creditNote' || Request::segment(1) == 'expense')?'active':''); ?>" href="#income" data-toggle="collapse" role="button" aria-expanded="<?php echo e((Request::segment(1) == 'invoice' || Request::segment(1) == 'payment' || Request::segment(1) == 'creditNote' || Request::segment(1) == 'expense')?'true':'false'); ?>" aria-controls="income">
                            <i class="ni ni-credit-card text-primary"></i>
                            <span class="nav-link-text "><?php echo e(__('Sales')); ?></span>
                        </a>
                        <div class="collapse <?php echo e((Request::segment(1) == 'invoice' || Request::segment(1) == 'payment' || Request::segment(1) == 'creditNote' || Request::segment(1) == 'expense')?'show':''); ?>" id="income">
                            <ul class="nav nav-sm flex-column">
                                <?php if(\Auth::user()->type=='company' || \Auth::user()->type=='employee'): ?>
                                <li class="nav-item <?php echo e((Request::segment(1) == 'client')?'active open':''); ?>">
                                    <a href="<?php echo e(route('client.index')); ?>" class="nav-link">
                                        <!-- <i class="ni ni-single-02 text-success"></i> -->
                                        <span class="nav-link-text"><?php echo e(__('Customers')); ?></span>
                                    </a>
                                </li>
                                <?php endif; ?>
                                <li class="nav-item <?php echo e((Request::segment(1) == 'invoice')?'active open':''); ?>">
                                    <a href="<?php echo e(route('invoice.index')); ?>" class="nav-link"><?php echo e(__('Sales Invoice')); ?></a>
                                </li>
                                <li class="nav-item <?php echo e((Request::segment(1) == 'payment')?'active open':''); ?>">
                                    <a href="<?php echo e(route('payment.index')); ?>" class="nav-link"><?php echo e(__('Payment')); ?></a>
                                </li>
                                <li class="nav-item <?php echo e((Request::segment(1) == 'creditNote')?'active open':''); ?>">
                                    <a href="<?php echo e(route('creditNote.index')); ?>" class="nav-link"><?php echo e(__('Credit Notes')); ?></a>
                                </li>
                            </ul>
                        </div>
                    </li>
                    <?php endif; ?>
                    <?php if(\Auth::user()->type=='company' || \Auth::user()->type=='client'): ?>
                    <li class="nav-item ">
                        <a class="nav-link nav-toggle <?php echo e((Request::segment(1) == 'contract')?'active':''); ?>" href="<?php echo e(route('contract.index')); ?>">
                            <i class="ni ni-single-copy-04 text-pink"></i>
                            <span class="nav-link-text"><?php echo e(__('Contract')); ?></span>
                        </a>
                    </li>
                    <?php endif; ?>
                    <?php if(\Auth::user()->type=='company' || \Auth::user()->type=='employee'): ?>
                    <li class="nav-item ">
                        <a class="nav-link nav-toggle <?php echo e((Request::segment(1) == 'messages')?'active':''); ?>" href="<?php echo e(url('messages')); ?>">
                            <i class="ni ni-chat-round text-info"></i>
                            <span class="nav-link-text"><?php echo e(__('Messenger')); ?></span>
                        </a>
                    </li>
                    <?php endif; ?>
                    <?php if(\Auth::user()->type=='company' || \Auth::user()->type=='client' || \Auth::user()->type=='employee'): ?>
                    <li class="nav-item ">
                        <a class="nav-link nav-toggle <?php echo e((Request::segment(1) == 'support')?'active':''); ?>" href="<?php echo e(route('support.index')); ?>">
                            <i class="ni ni-box-2 text-primary"></i>
                            <span class="nav-link-text"><?php echo e(__('Support')); ?></span>
                        </a>
                    </li>
                    <?php endif; ?>
                    <?php if(\Auth::user()->type=='company' || \Auth::user()->type=='employee'): ?>
                    <li class="nav-item ">
                        <a class="nav-link nav-toggle <?php echo e((Request::segment(1) == 'event')?'active':''); ?>" href="<?php echo e(route('event.index')); ?>">
                            <i class="ni ni-calendar-grid-58 text-pink"></i>
                            <span class="nav-link-text"><?php echo e(__('Event')); ?></span>
                        </a>
                    </li>
                    <?php endif; ?>
                    <?php if(\Auth::user()->type=='company' || \Auth::user()->type=='client' || \Auth::user()->type=='employee'): ?>
                    <li class="nav-item ">
                        <a class="nav-link nav-toggle <?php echo e((Request::segment(1) == 'noticeBoard')?'active':''); ?>" href="<?php echo e(route('noticeBoard.index')); ?>">
                            <i class="ni ni-tv-2 text-info"></i>
                            <span class="nav-link-text"><?php echo e(__('Notice Board')); ?></span>
                        </a>
                    </li>
                    <?php endif; ?>
                    <?php if(\Auth::user()->type=='company' || \Auth::user()->type=='employee'): ?>
                    <li class="nav-item ">
                        <a class="nav-link nav-toggle <?php echo e((Request::segment(1) == 'goal')?'active':''); ?>" href="<?php echo e(route('goal.index')); ?>">
                            <i class="ni ni-calendar-grid-58 text-primary"></i>
                            <span class="nav-link-text"><?php echo e(__('Goal')); ?></span>
                        </a>
                    </li>
                    <?php endif; ?>
                    <?php if(\Auth::user()->type=='company' || \Auth::user()->type=='client' || \Auth::user()->type=='employee'): ?>
                    <li class="nav-item ">
                        <a class="nav-link nav-toggle <?php echo e((Request::segment(1) == 'note')?'active':''); ?>" href="<?php echo e(route('note.index')); ?>">
                            <i class="ni ni-book-bookmark text-pink"></i>
                            <span class="nav-link-text"><?php echo e(__('Notes')); ?></span>
                        </a>
                    </li>
                    <?php endif; ?>
                    <?php if(\Auth::user()->type=='super admin' || \Auth::user()->type=='company'): ?>
                    <li class="nav-item ">
                        <a class="nav-link nav-toggle <?php echo e((Request::segment(1) == 'plan')?'active':''); ?>" href="<?php echo e(route('plan.index')); ?>">
                            <i class="ni ni-trophy text-info"></i>
                            <span class="nav-link-text"><?php echo e(__('Plan')); ?></span>
                        </a>
                    </li>
                    <?php endif; ?>
                    <?php if(\Auth::user()->type=='super admin'): ?>
                    <li class="nav-item ">
                        <a class="nav-link nav-toggle <?php echo e((Request::segment(1) == 'coupon')?'active':''); ?>" href="<?php echo e(route('coupon.index')); ?>">
                            <i class="ni ni-briefcase-24 text-primary"></i>
                            <span class="nav-link-text"><?php echo e(__('Coupon')); ?></span>
                        </a>
                    </li>
                    <?php endif; ?>
                    <?php if(\Auth::user()->type=='super admin' || \Auth::user()->type=='company'): ?>
                    <li class="nav-item ">
                        <a class="nav-link nav-toggle <?php echo e((Request::segment(1) == 'order')?'active':''); ?>" href="<?php echo e(route('order.index')); ?>">
                            <i class="ni ni-cart"></i>
                            <span class="nav-link-text"><?php echo e(__('Order')); ?></span>
                        </a>
                    </li>
                    <?php endif; ?>
                    <?php if(\Auth::user()->type=='super admin' || \Auth::user()->type=='company'): ?>
                    <li class="nav-item ">
                        <a class="nav-link nav-toggle <?php echo e((Request::segment(1) == 'email_template' || Request::segment(1) == 'email_template_lang')?'active':''); ?>" href="<?php echo e(route('email_template.index')); ?>">
                            <i class="ni ni-box-2 text-pink"></i>
                            <span class="nav-link-text"><?php echo e(__('Email Template')); ?></span>
                        </a>
                    </li>
                    <?php endif; ?>
                    <?php if(\Auth::user()->type=='company' || \Auth::user()->type=='employee'): ?>
                    <li class="nav-item">
                        <a class="nav-link  <?php echo e((Request::segment(1) == 'task-report' || Request::segment(1) == 'timelog-report'  || Request::segment(1) == 'finance-report'  || Request::segment(1) == 'income-report'  || Request::segment(1) == 'income-expense-report' || Request::segment(1) == 'leave-report'  ||
 Request::segment(1) == 'estimate-report' || Request::segment(1) == 'invoice-report' || Request::segment(1) == 'lead-report' || Request::segment(1) == 'client-report' || Request::segment(1) == 'attendance-report')?'active':''); ?>" href="#report" data-toggle="collapse" role="button" aria-expanded="<?php echo e((Request::segment(1) == 'task-report' || Request::segment(1) == 'timelog-report' || Request::segment(1) == 'finance-report'  || Request::segment(1) == 'income-report'  || Request::segment(1) == 'income-expense-report' || Request::segment(1) == 'leave-report'  || Request::segment(1) == 'estimate-report' || Request::segment(1) == 'invoice-report' || Request::segment(1) ==
                            'lead-report' || Request::segment(1) == 'client-report' || Request::segment(1) == 'attendance-report')?'true':'false'); ?>" aria-controls="income">
                            <i class="ni ni-align-center text-danger"></i>
                            <span class="nav-link-text "><?php echo e(__('Report')); ?></span>
                        </a>
                        <div class="collapse <?php echo e((Request::segment(1) == 'task-report' || Request::segment(1) == 'timelog-report'  || Request::segment(1) == 'finance-report'  || Request::segment(1) == 'income-report'  || Request::segment(1) == 'income-expense-report' || Request::segment(1) == 'leave-report'  ||
 Request::segment(1) == 'estimate-report' || Request::segment(1) == 'invoice-report' || Request::segment(1) == 'lead-report' || Request::segment(1) == 'client-report' || Request::segment(1) == 'attendance-report')?'show':''); ?>" id="report">
                            <ul class="nav nav-sm flex-column">
                                <li class="nav-item <?php echo e((Request::segment(1) == 'attendance-report')?'active open':''); ?>">
                                    <a href="<?php echo e(route('report.attendance')); ?>" class="nav-link"><?php echo e(__('Attendance')); ?></a>
                                </li>
                                <li class="nav-item <?php echo e((Request::segment(1) == 'task-report')?'active open':''); ?>">
                                    <a href="<?php echo e(route('report.task')); ?>" class="nav-link"><?php echo e(__('Task')); ?></a>
                                </li>
                                <li class="nav-item <?php echo e((Request::segment(1) == 'timelog-report')?'active open':''); ?>">
                                    <a href="<?php echo e(route('report.timelog')); ?>" class="nav-link"><?php echo e(__('Time Log')); ?></a>
                                </li>
                                <li class="nav-item <?php echo e((Request::segment(1) == 'finance-report')?'active open':''); ?>">
                                    <a href="<?php echo e(route('report.finance')); ?>" class="nav-link"><?php echo e(__('Finance')); ?></a>
                                </li>

                                <li class="nav-item <?php echo e((Request::segment(1) == 'income-expense-report')?'active open':''); ?>">
                                    <a href="<?php echo e(route('report.income.expense')); ?>" class="nav-link"><?php echo e(__('Income Vs Expense')); ?></a>
                                </li>
                                <li class="nav-item <?php echo e((Request::segment(1) == 'leave-report')?'active open':''); ?>">
                                    <a href="<?php echo e(route('report.leave')); ?>" class="nav-link"><?php echo e(__('Leave')); ?></a>
                                </li>

                                <li class="nav-item <?php echo e((Request::segment(1) == 'estimate-report')?'active open':''); ?>">
                                    <a href="<?php echo e(route('report.estimate')); ?>" class="nav-link"><?php echo e(__('Estimate')); ?></a>
                                </li>
                                <li class="nav-item <?php echo e((Request::segment(1) == 'invoice-report')?'active open':''); ?>">
                                    <a href="<?php echo e(route('report.invoice')); ?>" class="nav-link"><?php echo e(__('Sales Invoice')); ?></a>
                                </li>
                                <li class="nav-item <?php echo e((Request::segment(1) == 'client-report')?'active open':''); ?>">
                                    <a href="<?php echo e(route('report.client')); ?>" class="nav-link"><?php echo e(__('Client')); ?></a>
                                </li>

                                <li class="nav-item <?php echo e((Request::segment(1) == 'lead-report')?'active open':''); ?>">
                                    <a href="<?php echo e(route('report.lead')); ?>" class="nav-link"><?php echo e(__('Lead')); ?></a>
                                </li>


                            </ul>
                        </div>
                    </li>
                    <?php endif; ?>

                    <?php if(\Auth::user()->type=='company'): ?>
                    <li class="nav-item ">
                        <a class="nav-link <?php echo e((Request::segment(1) == 'department' || Request::segment(1) == 'designation' || Request::segment(1) == 'salaryType'  || Request::segment(1) == 'leaveType' || Request::segment(1) == 'pipeline' || Request::segment(1) == 'leadStage' || Request::segment(1) == 'projectStage' || Request::segment(1) == 'dealStage' || Request::segment(1) == 'source' || Request::segment(1) == 'label'  || Request::segment(1) == 'taxRate' || Request::segment(1) == 'unit' ||
                    Request::segment(1) == 'category' || Request::segment(1) == 'paymentMethod' || Request::segment(1) == 'contractType'  || Request::segment(1) == 'termination-type'  || Request::segment(1) == 'award-type'  || Request::segment(1) == 'training-type')
                    ?'active':''); ?>" href="#constant" data-toggle="collapse" role="button" aria-expanded="<?php echo e((Request::segment(1) == 'department' || Request::segment(1) == 'designation' || Request::segment(1) == 'salaryType'  || Request::segment(1) == 'leaveType' || Request::segment(1) == 'pipeline' || Request::segment(1) == 'leadStage' || Request::segment(1) == 'projectStage' || Request::segment(1) == 'dealStage' || Request::segment(1) == 'source' || Request::segment(1) == 'label'  || Request::segment(1) == 'taxRate' || Request::segment(1) == 'unit' ||
                           Request::segment(1) == 'category' || Request::segment(1) == 'paymentMethod' || Request::segment(1) == 'contractType'  || Request::segment(1) == 'termination-type' || Request::segment(1) == 'award-type'  || Request::segment(1) == 'training-type')
                           ?'true':'false'); ?>" aria-controls="navbar-dashboards1"> <i class="ni ni-atom"></i>
                            <span class="nav-link-text "><?php echo e(__('Constant')); ?></span>
                        </a>
                        <div class="collapse <?php echo e((Request::segment(1) == 'department' || Request::segment(1) == 'designation' || Request::segment(1) == 'salaryType'  || Request::segment(1) == 'leaveType' || Request::segment(1) == 'pipeline' || Request::segment(1) == 'leadStage' || Request::segment(1) == 'projectStage' || Request::segment(1) == 'dealStage' || Request::segment(1) == 'source' || Request::segment(1) == 'label'  || Request::segment(1) == 'taxRate' || Request::segment(1) == 'unit' ||
                        Request::segment(1) == 'category' || Request::segment(1) == 'paymentMethod' || Request::segment(1) == 'contractType'  || Request::segment(1) == 'termination-type'  || Request::segment(1) == 'award-type'  || Request::segment(1) == 'training-type')
                        ?'show':''); ?>" id="constant">

                            <ul class="nav nav-sm flex-column">

                                <a class="nav-link" href="#constant-hr" data-toggle="collapse" role="button" aria-expanded="<?php echo e((Request::segment(1) == 'department' || Request::segment(1) == 'designation' || Request::segment(1) == 'salaryType' || Request::segment(1) == 'leaveType' || Request::segment(1) == 'award-type'|| Request::segment(1) == 'termination-type'|| Request::segment(1) == 'training-type'  )?'true':''); ?>" aria-controls="navbar-dashboards1">
                                    <span class="nav-link-text "><?php echo e(__('HR')); ?></span>
                                </a>
                                <div class="collapse <?php echo e((Request::segment(1) == 'department' || Request::segment(1) == 'designation' || Request::segment(1) == 'salaryType' || Request::segment(1) == 'leaveType'  || Request::segment(1) == 'award-type'|| Request::segment(1) == 'termination-type'|| Request::segment(1) == 'training-type')?'show':''); ?>" id="constant-hr">
                                    <ul class="nav nav-sm flex-column">
                                        <li class="nav-item <?php echo e((Request::segment(1) == 'department')?'active open':''); ?>">
                                            <a href="<?php echo e(route('department.index')); ?>" class="nav-link"><?php echo e(__('Department')); ?></a>
                                        </li>
                                        <li class="nav-item <?php echo e((Request::segment(1) == 'designation')?'active open':''); ?>">
                                            <a href="<?php echo e(route('designation.index')); ?>" class="nav-link"><?php echo e(__('Designation')); ?></a>
                                        </li>
                                        <li class="nav-item <?php echo e((Request::segment(1) == 'salaryType')?'active open':''); ?>">
                                            <a href="<?php echo e(route('salaryType.index')); ?>" class="nav-link"><?php echo e(__('Salary Type')); ?></a>
                                        </li>
                                        <li class="nav-item <?php echo e((Request::segment(1) == 'leaveType')?'active open':''); ?>">
                                            <a href="<?php echo e(route('leaveType.index')); ?>" class="nav-link"><?php echo e(__('Leave Type')); ?></a>
                                        </li>
                                        <li class="nav-item <?php echo e((Request::segment(1) == 'award-type')?'active open':''); ?>">
                                            <a href="<?php echo e(route('award-type.index')); ?>" class="nav-link"><?php echo e(__('Award Type')); ?></a>
                                        </li>
                                        <li class="nav-item <?php echo e((Request::segment(1) == 'termination-type')?'active open':''); ?>">
                                            <a href="<?php echo e(route('termination-type.index')); ?>" class="nav-link"><?php echo e(__('Termination Type')); ?></a>
                                        </li>
                                        <li class="nav-item <?php echo e((Request::segment(1) == 'training-type')?'active open':''); ?>">
                                            <a href="<?php echo e(route('training-type.index')); ?>" class="nav-link"><?php echo e(__('Training Type')); ?></a>
                                        </li>
                                    </ul>
                                </div>

                                <a class="nav-link" href="#constant-presale" data-toggle="collapse" role="button" aria-expanded="<?php echo e((Request::segment(1) == 'pipeline' || Request::segment(1) == 'leadStage' || Request::segment(1) == 'dealStage'  || Request::segment(1) == 'source' || Request::segment(1) == 'label')?'true':''); ?>" aria-controls="navbar-dashboards1">
                                    <span class="nav-link-text "><?php echo e(__('PreSale')); ?></span>
                                </a>
                                <div class="collapse <?php echo e((Request::segment(1) == 'pipeline' || Request::segment(1) == 'leadStage' || Request::segment(1) == 'dealStage' || Request::segment(1) == 'source' || Request::segment(1) == 'label')?'show':''); ?>" id="constant-presale">
                                    <ul class="nav nav-sm flex-column">
                                        <li class="nav-item <?php echo e((Request::segment(1) == 'pipeline')?'active open':''); ?>">
                                            <a href="<?php echo e(route('pipeline.index')); ?>" class="nav-link"><?php echo e(__('Pipeline')); ?></a>
                                        </li>
                                        <li class="nav-item <?php echo e((Request::segment(1) == 'leadStage')?'active open':''); ?>">
                                            <a href="<?php echo e(route('leadStage.index')); ?>" class="nav-link"><?php echo e(__('Lead Stage')); ?></a>
                                        </li>
                                        <li class="nav-item <?php echo e((Request::segment(1) == 'dealStage')?'active open':''); ?>">
                                            <a href="<?php echo e(route('dealStage.index')); ?>" class="nav-link"><?php echo e(__('Deal Stage')); ?></a>
                                        </li>
                                        <li class="nav-item <?php echo e((Request::segment(1) == 'source')?'active open':''); ?>">
                                            <a href="<?php echo e(route('source.index')); ?>" class="nav-link"><?php echo e(__('Source')); ?></a>
                                        </li>
                                        <li class="nav-item <?php echo e((Request::segment(1) == 'label')?'active open':''); ?>">
                                            <a href="<?php echo e(route('label.index')); ?>" class="nav-link"><?php echo e(__('Label')); ?></a>
                                        </li>
                                    </ul>
                                </div>

                                <li class="nav-item <?php echo e((Request::segment(1) == 'projectStage')?'active open':''); ?>">
                                    <a href="<?php echo e(route('projectStage.index')); ?>" class="nav-link"><?php echo e(__('Project Stage')); ?></a>
                                </li>

                                <li class="nav-item <?php echo e((Request::segment(1) == 'taxRate')?'active open':''); ?>">
                                    <a href="<?php echo e(route('taxRate.index')); ?>" class="nav-link"><?php echo e(__('Tax Rate')); ?></a>
                                </li>
                                <li class="nav-item <?php echo e((Request::segment(1) == 'unit')?'active open':''); ?>">
                                    <a href="<?php echo e(route('unit.index')); ?>" class="nav-link"><?php echo e(__('Unit')); ?></a>
                                </li>
                                <li class="nav-item <?php echo e((Request::segment(1) == 'category')?'active open':''); ?>">
                                    <a href="<?php echo e(route('category.index')); ?>" class="nav-link"><?php echo e(__('Category')); ?></a>
                                </li>
                                <li class="nav-item <?php echo e((Request::segment(1) == 'paymentMethod')?'active open':''); ?>">
                                    <a href="<?php echo e(route('paymentMethod.index')); ?>" class="nav-link"><?php echo e(__('Payment Accounts')); ?></a>
                                </li>
                                <li class="nav-item <?php echo e((Request::segment(1) == 'contractType')?'active open':''); ?>">
                                    <a href="<?php echo e(route('contractType.index')); ?>" class="nav-link"><?php echo e(__('Contract Type')); ?></a>
                                </li>

                                <li class="nav-item <?php echo e((Request::segment(1) == 'chartofaccount')?'active open':''); ?>">
                                    <a href="<?php echo e(route('chartofaccount.index')); ?>" class="nav-link"><?php echo e(__('Chart of Account')); ?></a>
                                </li>

                            </ul>
                        </div>
                    </li>
                    <?php endif; ?>

                    <?php if(\Auth::user()->type=='company' || \Auth::user()->type=='super admin'): ?>
                    <li class="nav-item ">
                        <a class="nav-link nav-toggle <?php echo e((Request::segment(1) == 'settings')?'active':''); ?>" href="<?php echo e(route('role')); ?>">
                            <i class="ni ni-settings-gear-65 text-danger"></i>
                            <span class="nav-link-text"><?php echo e(__('Roles')); ?></span>
                        </a>
                        <a class="nav-link nav-toggle <?php echo e((Request::segment(1) == 'settings')?'active':''); ?>" href="<?php echo e(route('permission')); ?>">
                            <i class="ni ni-settings-gear-65 text-danger"></i>
                            <span class="nav-link-text"><?php echo e(__('Permissions')); ?></span>
                        </a>
                    </li>
                    <?php endif; ?>

                    <?php if(\Auth::user()->type=='company' || \Auth::user()->type=='super admin'): ?>
                    <li class="nav-item ">
                        <a class="nav-link nav-toggle <?php echo e((Request::segment(1) == 'settings')?'active':''); ?>" href="<?php echo e(route('settings')); ?>">
                            <i class="ni ni-settings-gear-65 text-danger"></i>
                            <span class="nav-link-text"><?php echo e(__('Settings')); ?></span>
                        </a>
                    </li>
                    <?php endif; ?>

                </ul>
            </div>
        </div>
    </div>
</nav><?php /**PATH /home/mitaapps/public_html/dekomdmc/main_file/resources/views/partials/admin/menu.blade.php ENDPATH**/ ?>