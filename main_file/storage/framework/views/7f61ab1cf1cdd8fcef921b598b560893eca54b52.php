<?php $__env->startSection('page-title'); ?>
<?php echo e(__('Email Templates')); ?>

<?php $__env->stopSection(); ?>
<?php $__env->startPush('css-page'); ?>
<?php $__env->stopPush(); ?>
<?php $__env->startPush('script-page'); ?>
<script type="text/javascript">
    $(document).on("click", ".email-template-checkbox", function() {
        var chbox = $(this);
        $.ajax({
            url: chbox.attr('data-url'),
            data: {
                _token: $('meta[name="csrf-token"]').attr('content'),
                status: chbox.val()
            },
            type: 'PUT',
            success: function(response) {
                if (response.is_success) {
                    toastr('Success', response.success, 'success');
                    if (chbox.val() == 1) {
                        $('#' + chbox.attr('id')).val(0);
                    } else {
                        $('#' + chbox.attr('id')).val(1);
                    }
                } else {
                    toastr('Error', response.error, 'error');
                }
            },
            error: function(response) {
                response = response.responseJSON;
                if (response.is_success) {
                    toastr('Error', response.error, 'error');
                } else {
                    toastr('Error', response, 'error');
                }
            }
        })
    });
</script>
<?php $__env->stopPush(); ?>
<?php $__env->startSection('breadcrumb'); ?>
<h6 class="h2 d-inline-block mb-0"><?php echo e(__('Email Templates')); ?></h6>
<nav aria-label="breadcrumb" class="d-none d-md-inline-block ml-md-4">
    <ol class="breadcrumb breadcrumb-links">
        <li class="breadcrumb-item"><a href="#"><i class="fas fa-home"></i></a></li>
        <li class="breadcrumb-item"><a href="<?php echo e(route('dashboard')); ?>"><?php echo e(__('Dashboard')); ?></a></li>
        <li class="breadcrumb-item active" aria-current="page"><?php echo e(__('Email Templates')); ?></li>
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
                                <h2 class="h3 mb-0"><?php echo e(__('Manage Email Templates')); ?></h2>
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
                                    <th class="w-85"> <?php echo e(__('Name')); ?></th>
                                    <th class="text-right"> <?php echo e(__('Action')); ?></th>
                                </tr>
                            </thead>

                            <tbody>
                                <?php $__currentLoopData = $EmailTemplates; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $EmailTemplate): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr>
                                    <td></td>
                                    <td><?php echo e($EmailTemplate->name); ?></td>
                                    <td>
                                        <?php if(\Auth::user()->type=='super admin'): ?>
                                        <a href="<?php echo e(route('manage.email.language',[$EmailTemplate->id,\Auth::user()->lang])); ?>" class="table-action float-right">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <?php endif; ?>
                                        <?php if(\Auth::user()->type=='company'): ?>
                                        <label class="custom-toggle float-right email-custom-toggle">
                                            <input type="checkbox" class="email-template-checkbox" id="email_tempalte_<?php echo e($EmailTemplate->template->id); ?>" <?php if($EmailTemplate->template->is_active == 1): ?> checked="checked" <?php endif; ?> type="checkbox" value="<?php echo e($EmailTemplate->template->is_active); ?>" data-url="<?php echo e(route('status.email.language',[$EmailTemplate->template->id])); ?>">
                                            <span class="custom-toggle-slider rounded-circle" data-label-off="No" data-label-on="Yes"></span>
                                        </label>
                                        <?php endif; ?>
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
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/mitaapps/public_html/dekomdmc/main_file/resources/views/email_templates/index.blade.php ENDPATH**/ ?>