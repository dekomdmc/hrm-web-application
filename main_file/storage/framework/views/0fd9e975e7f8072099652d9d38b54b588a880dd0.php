<?php $__env->startSection('page-title'); ?>
    <?php echo e(__('Credit Notes')); ?>

<?php $__env->stopSection(); ?>
<?php $__env->startPush('css-page'); ?>
<?php $__env->stopPush(); ?>
<?php $__env->startPush('script-page'); ?>
    <script>
        $(document).on('change', '#invoice', function () {

            var id = $(this).val();
            var url = "<?php echo e(route('invoice.get')); ?>";

            $.ajax({
                url: url,
                type: 'get',
                cache: false,
                data: {
                    'id': id,

                },
                success: function (data) {
                    $('#amount').val(data)
                },

            });

        })
    </script>
<?php $__env->stopPush(); ?>
<?php $__env->startSection('breadcrumb'); ?>
    <h6 class="h2 d-inline-block mb-0"><?php echo e(__('Credit Notes')); ?></h6>
    <nav aria-label="breadcrumb" class="d-none d-md-inline-block ml-md-4">
        <ol class="breadcrumb breadcrumb-links">
            <li class="breadcrumb-item"><a href="#"><i class="fas fa-home"></i></a></li>
            <li class="breadcrumb-item"><a href="<?php echo e(route('dashboard')); ?>"><?php echo e(__('Dashboard')); ?></a></li>
            <li class="breadcrumb-item active" aria-current="page"><?php echo e(__('Credit Note')); ?></li>
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
                                <h2 class="h3 mb-0"><?php echo e(__('Manage Credit Note')); ?></h2>
                            </div>
                            <?php if(\Auth::user()->type=='company'): ?>
                                <div class="col-auto">
                                <span class="create-btn">
                                    <a href="#" data-url="<?php echo e(route('creditNote.create')); ?>" data-ajax-popup="true" data-title="<?php echo e(__('Create New Credit Note')); ?>" class="btn btn-outline-primary btn-sm">
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
                                <th><?php echo e(__('Invoice')); ?></th>
                                <th><?php echo e(__('Client')); ?></th>
                                <th><?php echo e(__('Date')); ?></th>
                                <th><?php echo e(__('Amount')); ?></th>
                                <th><?php echo e(__('Description')); ?></th>
                                <th class="text-right"><?php echo e(__('Action')); ?></th>
                            </tr>
                            </thead>

                            <tbody>
                            <?php $__currentLoopData = $invoices; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $invoice): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <?php if(!empty($invoice->creditNote)): ?>
                                    <?php $__currentLoopData = $invoice->creditNote; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $creditNote): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <tr>
                                            <td><?php echo e(AUth::user()->invoiceNumberFormat($invoice->invoice_id)); ?></td>
                                            <td><?php echo e((!empty($invoice->clients)?$invoice->clients->name:'')); ?></td>
                                            <td><?php echo e(Auth::user()->dateFormat($creditNote->date)); ?></td>
                                            <td><?php echo e(Auth::user()->priceFormat($creditNote->amount)); ?></td>
                                            <td><?php echo e($creditNote->description); ?></td>
                                            <td class="table-actions text-right">
                                                <a href="<?php echo e(route('invoice.show',Crypt::encrypt($invoice->id))); ?>" class="table-action" data-toggle="tooltip" data-original-title="View">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                                <?php if(\Auth::user()->type=='company'): ?>
                                                    <a href="#" data-url="<?php echo e(route('creditNote.edit',$creditNote->id)); ?>" class="table-action" data-toggle="tooltip" data-original-title="<?php echo e(__('Edit')); ?>" data-ajax-popup="true" data-title="<?php echo e(__('Edit Credit Note')); ?>">
                                                        <i class="far fa-edit"></i>
                                                    </a>
                                                    <a href="#!" class="table-action table-action-delete" data-toggle="tooltip" data-original-title="<?php echo e(__('Delete')); ?>" data-confirm="Are You Sure?|This action can not be undone. Do you want to continue?" data-confirm-yes="document.getElementById('delete-form-<?php echo e($creditNote->id); ?>').submit();">
                                                        <i class="fas fa-trash"></i>
                                                    </a>
                                                    <?php echo Form::open(['method' => 'DELETE', 'route' => ['creditNote.destroy', $creditNote->id],'id'=>'delete-form-'.$creditNote->id]); ?>

                                                    <?php echo Form::close(); ?>

                                                <?php endif; ?>
                                            </td>
                                        </tr>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                <?php endif; ?>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>


<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/mitaapps/public_html/dekomdmc/main_file/resources/views/creditNote/index.blade.php ENDPATH**/ ?>