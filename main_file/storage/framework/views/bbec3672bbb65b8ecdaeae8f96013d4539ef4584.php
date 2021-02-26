<?php $__env->startSection('page-title'); ?>
<?php echo e(__('Purchase Invoice')); ?>

<?php $__env->stopSection(); ?>
<?php $__env->startPush('css-page'); ?>
<?php $__env->stopPush(); ?>
<?php $__env->startPush('script-page'); ?>
<script>
    $(document).on('change', 'select[name=client]', function() {
        var client_id = $(this).val();
        getClientProject(client_id);
    });

    function getClientProject(client_id) {
        $.ajax({
            url: "<?php echo e(route('purchaseinvoice.client.project')); ?>",
            type: 'POST',
            data: {
                "client_id": client_id,
                "_token": "<?php echo e(csrf_token()); ?>",
            },
            success: function(data) {
                $('#project').empty();
                $.each(data, function(key, value) {
                    $('#project').append('<option value="' + key + '">' + value + '</option>');
                });
            }
        });
    }

    $(document).on('click', '.type', function() {
        var type = $(this).val();
        if (type == 'Project') {
            $('.project-field').removeClass('d-none')
            $('.project-field').addClass('d-block');
        } else {
            $('.project-field').addClass('d-none')
            $('.project-field').removeClass('d-block');
        }
    });
</script>
<?php $__env->stopPush(); ?>
<?php $__env->startSection('breadcrumb'); ?>
<h6 class="h2 d-inline-block mb-0"><?php echo e(__('Purchase Invoice')); ?></h6>
<nav aria-label="breadcrumb" class="d-none d-md-inline-block ml-md-4">
    <ol class="breadcrumb breadcrumb-links">
        <li class="breadcrumb-item"><a href="#"><i class="fas fa-home"></i></a></li>
        <li class="breadcrumb-item"><a href="<?php echo e(route('dashboard')); ?>"><?php echo e(__('Dashboard')); ?></a></li>
        <li class="breadcrumb-item active" aria-current="page"><?php echo e(__('Purchase Invoice')); ?></li>
    </ol>
</nav>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
<div class="container-fluid">
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <?php echo e(Form::open(array('url' => 'purchaseinvoice','method'=>'get'))); ?>

                    <div class="row">
                        <div class="col">
                            <h2 class="h3 mb-0"><?php echo e(__('Filter')); ?></h2>
                        </div>
                        <div class="col-md-2">
                            <?php echo e(Form::label('status',__('Status'))); ?>

                            <select class="form-control custom-select" name="status">
                                <option value=""><?php echo e(__('All')); ?></option>

                                <?php $__currentLoopData = $status; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $k=>$val): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($k); ?>" <?php echo e(isset($_GET['status']) && $_GET['status'] == $k?'selected':''); ?>> <?php echo e($val); ?> </option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                        </div>
                        <div class="col-md-2">
                            <?php echo e(Form::label('start_date',__('Start Date'))); ?>

                            <?php echo e(Form::date('start_date',isset($_GET['start_date'])?$_GET['start_date']:'',array('class'=>'form-control'))); ?>

                        </div>
                        <div class="col-md-2">
                            <?php echo e(Form::label('end_date',__('End Date'))); ?>

                            <?php echo e(Form::date('end_date',isset($_GET['end_date'])?$_GET['end_date']:'',array('class'=>'form-control'))); ?>

                        </div>
                        <div class="col-auto apply-btn">
                            <?php echo e(Form::submit(__('Apply'),array('class'=>'btn btn-outline-primary btn-sm'))); ?>

                            <a href="<?php echo e(route('purchaseinvoice.index')); ?>" class="btn btn-outline-danger btn-sm"><?php echo e(__('Reset')); ?></a>
                        </div>
                    </div>
                    <?php echo e(Form::close()); ?>


                </div>
            </div>
        </div>
        <div class="col">
            <div class="card">
                <!-- Card header -->
                <div class="card-header">
                    <div class="row">
                        <div class="col">
                            <h2 class="h3 mb-0"><?php echo e(__('Manage Purchase Invoice')); ?></h2>
                        </div>
                        <?php if(\Auth::user()->type=='company'): ?>
                        <div class="col-auto">
                            <span class="create-btn">
                                <a href="#" data-url="<?php echo e(route('purchaseinvoice.create')); ?>" data-ajax-popup="true" data-title="<?php echo e(__('Create New Invoice')); ?>" class="btn btn-outline-primary btn-sm">
                                    <i class="fa fa-plus"></i> <?php echo e(__('Create')); ?>

                                </a>
                                <a href="<?php echo e(route('purchaseinvoice.create')); ?>" data-url="<?php echo e(route('purchaseinvoice.create')); ?>" data-ajax-popup="true" data-title="<?php echo e(__('Create New Invoice')); ?>" class="btn btn-outline-primary btn-sm">
                                    <i class="fa fa-plus"></i> <?php echo e(__('Create Link')); ?>

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
                                <th>
                                    <div class="btn btn-primary btn-sm"><i class="fa fa-check"></i></div>
                                </th>
                                <th>#</th>
                                <?php if(\Auth::user()->type!='client'): ?>
                                <th><?php echo e(__('Client')); ?></th>
                                <?php endif; ?>
                                <th><?php echo e(__('Issue Date')); ?></th>
                                <th><?php echo e(__('Due Date')); ?></th>
                                <th><?php echo e(__('Total')); ?></th>
                                <th><?php echo e(__('Due')); ?></th>
                                <th><?php echo e(__('Status')); ?></th>
                                <th><?php echo e(__('Type')); ?></th>
                                <th class="text-right"><?php echo e(__('Action')); ?></th>
                            </tr>
                        </thead>

                        <tbody>
                            <?php $__currentLoopData = $invoices; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $invoice): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr>
                                <td></td>
                                <td><a class="btn btn-outline-primary btn-sm" href="<?php echo e(route('purchaseinvoice.show',\Crypt::encrypt($invoice->id))); ?>"><?php echo e(\Auth::user()->invoiceNumberFormat($invoice->invoice_id)); ?></a></td>
                                <?php if(\Auth::user()->type!='client'): ?>
                                <td><?php echo e(!empty($invoice->clients)?$invoice->clients->name:''); ?></td>
                                <?php endif; ?>
                                <td><?php echo e(\Auth::user()->dateFormat($invoice->issue_date)); ?></td>
                                <td><?php echo e(\Auth::user()->dateFormat($invoice->due_date)); ?></td>
                                <td><?php echo e(\Auth::user()->priceFormat($invoice->getTotal())); ?></td>
                                <td><?php echo e(\Auth::user()->priceFormat($invoice->getDue())); ?></td>
                                <td>
                                    <?php if($invoice->status == 0): ?>
                                    <span class="badge badge-primary"><?php echo e(__(\App\Invoice::$statues[$invoice->status])); ?></span>
                                    <?php elseif($invoice->status == 1): ?>
                                    <span class="badge badge-info"><?php echo e(__(\App\Invoice::$statues[$invoice->status])); ?></span>
                                    <?php elseif($invoice->status == 2): ?>
                                    <span class="badge badge-default"><?php echo e(__(\App\Invoice::$statues[$invoice->status])); ?></span>
                                    <?php elseif($invoice->status == 3): ?>
                                    <span class="badge badge-danger"><?php echo e(__(\App\Invoice::$statues[$invoice->status])); ?></span>
                                    <?php elseif($invoice->status == 4): ?>
                                    <span class="badge badge-warning"><?php echo e(__(\App\Invoice::$statues[$invoice->status])); ?></span>
                                    <?php elseif($invoice->status == 5): ?>
                                    <span class="badge badge-success"><?php echo e(__(\App\Invoice::$statues[$invoice->status])); ?></span>
                                    <?php endif; ?>
                                </td>
                                <td><?php echo e($invoice->type); ?></td>
                                <td class="table-actions text-right">
                                    <a href="<?php echo e(route('purchaseinvoice.show',\Crypt::encrypt($invoice->id))); ?>" class="table-action" data-toggle="tooltip" data-original-title="<?php echo e(__('View')); ?>">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <?php if(\Auth::user()->type=='company'): ?>
                                    <a href="#!" data-url="<?php echo e(route('purchaseinvoice.edit',$invoice->id)); ?>" class="table-action" data-toggle="tooltip" data-original-title="<?php echo e(__('Edit')); ?>" data-ajax-popup="true" data-title="<?php echo e(__('Edit Purchase Invoice')); ?>">
                                        <i class="far fa-edit"></i>
                                    </a>

                                    <a href="#!" class="table-action table-action-delete" data-toggle="tooltip" data-original-title="<?php echo e(__('Delete')); ?>" data-confirm="Are You Sure?|This action can not be undone. Do you want to continue?" data-confirm-yes="document.getElementById('purchaseinvoice-delete-form-<?php echo e($invoice->id); ?>').submit();">
                                        <i class="fas fa-trash"></i>
                                    </a>
                                    <?php echo Form::open(['method' => 'DELETE', 'route' => ['purchaseinvoice.destroy', $invoice->id],'id'=>'purchaseinvoice-delete-form-'.$invoice->id]); ?>

                                    <?php echo Form::close(); ?>

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
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/mitaapps/public_html/dekomdmc/main_file/resources/views/purchaseinvoice/index.blade.php ENDPATH**/ ?>