<?php
    $logo=asset(Storage::url('uploads/logo/'));
    $company_logo=Utility::getValByName('company_logo');
    $company_small_logo=Utility::getValByName('company_small_logo');
    $company_favicon=Utility::getValByName('company_favicon');
$lang=\App\Utility::getValByName('default_language');
?>
<?php $__env->startSection('page-title'); ?>
    <?php echo e(__('Settings')); ?>

<?php $__env->stopSection(); ?>
<?php $__env->startPush('css-page'); ?>
    <link href="<?php echo e(asset('assets/module/bootstrap-fileinput/bootstrap-fileinput.css')); ?>" rel="stylesheet" type="text/css"/>
    <style>
        .card-body {
            padding: 9px 24px;
            flex: 1 1 auto;
        }
    </style>
<?php $__env->stopPush(); ?>

<?php $__env->startPush('script-page'); ?>
    <script src="<?php echo e(asset('assets/module/bootstrap-fileinput/bootstrap-fileinput.js')); ?>" type="text/javascript"></script>
    <script>
        $(document).on("change", "select[name='estimate_template'], input[name='estimate_color']", function () {
            var template = $("select[name='estimate_template']").val();
            var color = $("input[name='estimate_color']:checked").val();
            $('#estimate_frame').attr('src', '<?php echo e(url('/estimate/preview')); ?>/' + template + '/' + color);
        });
        $(document).on("change", "select[name='invoice_template'], input[name='invoice_color']", function () {
            var template = $("select[name='invoice_template']").val();
            var color = $("input[name='invoice_color']:checked").val();
            $('#invoice_frame').attr('src', '<?php echo e(url('/invoice/preview')); ?>/' + template + '/' + color);
        });

    </script>

<?php $__env->stopPush(); ?>
<?php $__env->startSection('breadcrumb'); ?>
    <h6 class="h2 d-inline-block mb-0"><?php echo e(__('Settings')); ?></h6>
    <nav aria-label="breadcrumb" class="d-none d-md-inline-block ml-md-4">
        <ol class="breadcrumb breadcrumb-links">
            <li class="breadcrumb-item"><a href="#"><i class="fas fa-home"></i></a></li>
            <li class="breadcrumb-item"><a href="<?php echo e(route('dashboard')); ?>"><?php echo e(__('Dashboard')); ?></a></li>
            <li class="breadcrumb-item active" aria-current="page"><?php echo e(__('Settings')); ?></li>
        </ol>
    </nav>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <!-- Card header -->
                    <div class="card-header">
                        <div class="row">
                            <div class="col-md-12">
                                <ul class="nav nav-tabs">
                                    <?php if(\Auth::user()->type=='super admin' || \Auth::user()->type=='company'): ?>
                                        <li><a class="active" data-toggle="tab" href="#business-setting"><?php echo e(__('Business Setting')); ?></a></li>
                                    <?php endif; ?>
                                    <?php if(\Auth::user()->type=='company'): ?>
                                        <li><a data-toggle="tab" href="#company-setting"><?php echo e(__('Company Setting')); ?></a></li>
                                    <?php endif; ?>
                                    <?php if(\Auth::user()->type=='super admin'): ?>
                                        <li><a data-toggle="tab" href="#email-setting"><?php echo e(__('Email Setting')); ?></a></li>
                                    <?php endif; ?>
                                    <?php if(\Auth::user()->type=='company'): ?>
                                        <li><a data-toggle="tab" href="#system-setting"><?php echo e(__('System Setting')); ?></a></li>
                                    <?php endif; ?>
                                    <?php if(\Auth::user()->type=='company'): ?>
                                        <li><a data-toggle="tab" href="#estimate-template-setting"><?php echo e(__('Estimate Print Setting')); ?></a></li>
                                    <?php endif; ?>
                                    <?php if(\Auth::user()->type=='company'): ?>
                                        <li><a data-toggle="tab" href="#invoice-template-setting"><?php echo e(__('Invoice Print Setting')); ?></a></li>
                                    <?php endif; ?>
                                    <?php if(\Auth::user()->type=='super admin'): ?>
                                        <li><a data-toggle="tab" href="#pusher-template-setting"><?php echo e(__('Pusher Setting')); ?></a></li>
                                    <?php endif; ?>
                                    <?php if(\Auth::user()->type=='super admin'): ?>
                                        <li><a data-toggle="tab" href="#payment-template-setting"><?php echo e(__('Payment Setting')); ?></a></li>
                                    <?php endif; ?>
                                    <?php if(\Auth::user()->type=='company'): ?>
                                        <li><a data-toggle="tab" href="#company-payment-template-setting"><?php echo e(__('Payment Setting')); ?></a></li>
                                    <?php endif; ?>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="tab-content">
                            <?php if(\Auth::user()->type=='super admin'): ?>
                                <div id="business-setting" class="tab-pane fade in active show">
                                    <?php echo e(Form::model($settings,array('route'=>'business.setting','method'=>'POST','enctype' => "multipart/form-data"))); ?>

                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-md-4">
                                                <div class="fileinput fileinput-new" data-provides="fileinput">
                                                    <div class="fileinput-new thumbnail" style="width: 290px; height: 150px;">
                                                        <img src="<?php echo e($logo.'/'.(isset($company_logo) && !empty($company_logo)?$company_logo:'logo.png')); ?>" alt=""></div>
                                                    <div class="fileinput-preview fileinput-exists thumbnail" style="max-width: 290px; max-height: 150px; line-height: 10px;"></div>
                                                    <div>
                                                        <span class="btn default btn-file">
                                                            <span class="fileinput-new">  <?php echo e(__('Select image')); ?>  </span>
                                                            <span class="fileinput-exists"> <?php echo e(__('Change')); ?> </span>
                                                            <input type="hidden">
                                                            <input type="file" name="logo" id="logo">
                                                        </span>
                                                        <a href="javascript:;" class="btn default fileinput-exists" data-dismiss="fileinput"> <?php echo e(__('Remove')); ?> </a>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-md-4 text-center">
                                                <div class="fileinput fileinput-new" data-provides="fileinput">
                                                    <div class="fileinput-new thumbnail" style="width: 200px; height: 150px;">
                                                        <img src="<?php echo e($logo.'/'.(isset($company_small_logo) && !empty($company_small_logo)?$company_small_logo:'small_logo.png')); ?>" alt=""></div>
                                                    <div class="fileinput-preview fileinput-exists thumbnail" style="max-width: 340px; max-height: 150px; line-height: 10px;"></div>
                                                    <div>
                                                        <span class="btn default btn-file">
                                                            <span class="fileinput-new">  <?php echo e(__('Select image')); ?>  </span>
                                                            <span class="fileinput-exists"> <?php echo e(__('Change')); ?> </span>
                                                            <input type="hidden">
                                                            <input type="file" name="small_logo" id="logo">
                                                        </span>
                                                        <a href="javascript:;" class="btn default fileinput-exists" data-dismiss="fileinput"> <?php echo e(__('Remove')); ?> </a>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-4 text-right">
                                                <div class="fileinput fileinput-new" data-provides="fileinput">
                                                    <div class="fileinput-new thumbnail" style="width: 200px; height: 150px;">
                                                        <img src="<?php echo e($logo.'/'.(isset($company_favicon) && !empty($company_favicon)?$company_favicon:'favicon.png')); ?>" alt=""></div>
                                                    <div class="fileinput-preview fileinput-exists thumbnail" style="max-width: 340px; max-height: 150px; line-height: 10px;"></div>
                                                    <div>
                                                        <span class="btn default btn-file">
                                                            <span class="fileinput-new">  <?php echo e(__('Select image')); ?>  </span>
                                                            <span class="fileinput-exists"> <?php echo e(__('Change')); ?> </span>
                                                            <input type="hidden">
                                                            <input type="file" name="favicon" id="logo">
                                                        </span>
                                                        <a href="javascript:;" class="btn default fileinput-exists" data-dismiss="fileinput"> <?php echo e(__('Remove')); ?> </a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <?php $__errorArgs = ['logo'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                        <div class="row mt-10 mb-10">
                                                <span class="invalid-logo" role="alert">
                                                    <strong class="text-danger"><?php echo e($message); ?></strong>
                                                 </span>
                                        </div>
                                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                        <div class="row">
                                            <div class="form-group col-md-6">
                                                <?php echo e(Form::label('title_text',__('Title Text'))); ?>

                                                <?php echo e(Form::text('title_text',null,array('class'=>'form-control','placeholder'=>__('Title Text')))); ?>

                                                <?php $__errorArgs = ['title_text'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                                <span class="invalid-title_text" role="alert">
                                             <strong class="text-danger"><?php echo e($message); ?></strong>
                                             </span>
                                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                            </div>
                                            <?php if(\Auth::user()->type=='super admin'): ?>
                                                <div class="form-group col-md-6">
                                                    <?php echo e(Form::label('footer_text',__('Footer Text'))); ?>

                                                    <?php echo e(Form::text('footer_text',null,array('class'=>'form-control','placeholder'=>__('Footer Text')))); ?>

                                                    <?php $__errorArgs = ['footer_text'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                                    <span class="invalid-footer_text" role="alert">
                                                         <strong class="text-danger"><?php echo e($message); ?></strong>
                                                         </span>
                                                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                                </div>
                                                <div class="form-group col-md-6">
                                                    <?php echo e(Form::label('default_language',__('Default Language'))); ?>

                                                    <div class="changeLanguage">
                                                        <select name="default_language" id="default_language" class="form-control custom-select">
                                                            <?php $__currentLoopData = \App\Utility::languages(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $language): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                                <option <?php if($lang == $language): ?> selected <?php endif; ?> value="<?php echo e($language); ?>"><?php echo e(Str::upper($language)); ?></option>
                                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                        </select>
                                                    </div>
                                                </div>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                    <div class="card-footer text-right">
                                        <?php echo e(Form::submit(__('Save Change'),array('class'=>'btn btn-primary'))); ?>

                                    </div>
                                    <?php echo e(Form::close()); ?>

                                </div>
                            <?php endif; ?>
                            <?php if(\Auth::user()->type=='company'): ?>
                                <div id="business-setting" class="tab-pane fade in active show">
                                    <?php echo e(Form::model($settings,array('route'=>'business.setting','method'=>'POST','enctype' => "multipart/form-data"))); ?>

                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-md-4">
                                                <div class="fileinput fileinput-new" data-provides="fileinput">
                                                    <div class="fileinput-new thumbnail" style="width: 290px; height: 150px;">
                                                        <img src="<?php echo e($logo.'/'.(isset($company_logo) && !empty($company_logo)?$company_logo:'logo.png')); ?>" alt=""></div>
                                                    <div class="fileinput-preview fileinput-exists thumbnail" style="max-width: 290px; max-height: 150px; line-height: 10px;"></div>
                                                    <div>
                                                        <span class="btn default btn-file">
                                                            <span class="fileinput-new">  <?php echo e(__('Select image')); ?>  </span>
                                                            <span class="fileinput-exists"> <?php echo e(__('Change')); ?> </span>
                                                            <input type="hidden">
                                                            <input type="file" name="company_logo" id="logo">
                                                        </span>
                                                        <a href="javascript:;" class="btn default fileinput-exists" data-dismiss="fileinput"> <?php echo e(__('Remove')); ?> </a>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-md-4 text-center">
                                                <div class="fileinput fileinput-new" data-provides="fileinput">
                                                    <div class="fileinput-new thumbnail" style="width: 200px; height: 150px;">
                                                        <img src="<?php echo e($logo.'/'.(isset($company_small_logo) && !empty($company_small_logo)?$company_small_logo:'small_logo.png')); ?>" alt=""></div>
                                                    <div class="fileinput-preview fileinput-exists thumbnail" style="max-width: 340px; max-height: 150px; line-height: 10px;"></div>
                                                    <div>
                                                        <span class="btn default btn-file">
                                                            <span class="fileinput-new">  <?php echo e(__('Select image')); ?>  </span>
                                                            <span class="fileinput-exists"> <?php echo e(__('Change')); ?> </span>
                                                            <input type="hidden">
                                                            <input type="file" name="company_small_logo" id="logo">
                                                        </span>
                                                        <a href="javascript:;" class="btn default fileinput-exists" data-dismiss="fileinput"> <?php echo e(__('Remove')); ?> </a>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-4 text-right">
                                                <div class="fileinput fileinput-new" data-provides="fileinput">
                                                    <div class="fileinput-new thumbnail" style="width: 200px; height: 150px;">
                                                        <img src="<?php echo e($logo.'/'.(isset($company_favicon) && !empty($company_favicon)?$company_favicon:'favicon.png')); ?>" alt=""></div>
                                                    <div class="fileinput-preview fileinput-exists thumbnail" style="max-width: 340px; max-height: 150px; line-height: 10px;"></div>
                                                    <div>
                                                        <span class="btn default btn-file">
                                                            <span class="fileinput-new">  <?php echo e(__('Select image')); ?>  </span>
                                                            <span class="fileinput-exists"> <?php echo e(__('Change')); ?> </span>
                                                            <input type="hidden">
                                                            <input type="file" name="company_favicon" id="logo">
                                                        </span>
                                                        <a href="javascript:;" class="btn default fileinput-exists" data-dismiss="fileinput"> <?php echo e(__('Remove')); ?> </a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <?php $__errorArgs = ['logo'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                        <div class="row mt-10 mb-10">
                                                <span class="invalid-logo" role="alert">
                                                    <strong class="text-danger"><?php echo e($message); ?></strong>
                                                 </span>
                                        </div>
                                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                        <div class="row">
                                            <div class="form-group col-md-6">
                                                <?php echo e(Form::label('title_text',__('Title Text'))); ?>

                                                <?php echo e(Form::text('title_text',null,array('class'=>'form-control','placeholder'=>__('Title Text')))); ?>

                                                <?php $__errorArgs = ['title_text'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                                <span class="invalid-title_text" role="alert">
                                             <strong class="text-danger"><?php echo e($message); ?></strong>
                                             </span>
                                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                            </div>

                                        </div>
                                    </div>
                                    <div class="card-footer text-right">
                                        <?php echo e(Form::submit(__('Save Change'),array('class'=>'btn btn-primary'))); ?>

                                    </div>
                                    <?php echo e(Form::close()); ?>

                                </div>
                            <?php endif; ?>
                            <?php if(\Auth::user()->type=='company'): ?>
                                <div id="company-setting" class="tab-pane fade">
                                    <div class="row">
                                        <?php echo e(Form::model($settings,array('route'=>'company.setting','method'=>'post'))); ?>

                                        <div class="card-body">
                                            <div class="row">
                                                <div class="form-group col-md-6">
                                                    <?php echo e(Form::label('company_name *',__('Company Name *'))); ?>

                                                    <?php echo e(Form::text('company_name',null,array('class'=>'form-control font-style'))); ?>

                                                    <?php $__errorArgs = ['company_name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                                    <span class="invalid-company_name" role="alert">
                                                            <strong class="text-danger"><?php echo e($message); ?></strong>
                                                        </span>
                                                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                                </div>
                                                <div class="form-group col-md-6">
                                                    <?php echo e(Form::label('company_address',__('Address'))); ?>

                                                    <?php echo e(Form::text('company_address',null,array('class'=>'form-control font-style'))); ?>

                                                    <?php $__errorArgs = ['company_address'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                                    <span class="invalid-company_address" role="alert">
                                                            <strong class="text-danger"><?php echo e($message); ?></strong>
                                                        </span>
                                                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                                </div>
                                                <div class="form-group col-md-6">
                                                    <?php echo e(Form::label('company_city',__('City'))); ?>

                                                    <?php echo e(Form::text('company_city',null,array('class'=>'form-control font-style'))); ?>

                                                    <?php $__errorArgs = ['company_city'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                                    <span class="invalid-company_city" role="alert">
                                                                    <strong class="text-danger"><?php echo e($message); ?></strong>
                                                                </span>
                                                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                                </div>
                                                <div class="form-group col-md-6">
                                                    <?php echo e(Form::label('company_state',__('State'))); ?>

                                                    <?php echo e(Form::text('company_state',null,array('class'=>'form-control font-style'))); ?>

                                                    <?php $__errorArgs = ['company_state'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                                    <span class="invalid-company_state" role="alert">
                                                            <strong class="text-danger"><?php echo e($message); ?></strong>
                                                        </span>
                                                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                                </div>
                                                <div class="form-group col-md-6">
                                                    <?php echo e(Form::label('company_zipcode',__('Zip/Post Code'))); ?>

                                                    <?php echo e(Form::text('company_zipcode',null,array('class'=>'form-control'))); ?>

                                                    <?php $__errorArgs = ['company_zipcode'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                                    <span class="invalid-company_zipcode" role="alert">
                                                            <strong class="text-danger"><?php echo e($message); ?></strong>
                                                        </span>
                                                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                                </div>
                                                <div class="form-group  col-md-6">
                                                    <?php echo e(Form::label('company_country',__('Country'))); ?>

                                                    <?php echo e(Form::text('company_country',null,array('class'=>'form-control font-style'))); ?>

                                                    <?php $__errorArgs = ['company_country'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                                    <span class="invalid-company_country" role="alert">
                                                            <strong class="text-danger"><?php echo e($message); ?></strong>
                                                        </span>
                                                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                                </div>
                                                <div class="form-group col-md-6">
                                                    <?php echo e(Form::label('company_telephone',__('Telephone'))); ?>

                                                    <?php echo e(Form::text('company_telephone',null,array('class'=>'form-control'))); ?>

                                                    <?php $__errorArgs = ['company_telephone'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                                    <span class="invalid-company_telephone" role="alert">
                                                            <strong class="text-danger"><?php echo e($message); ?></strong>
                                                        </span>
                                                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                                </div>
                                                <div class="form-group col-md-6">
                                                    <?php echo e(Form::label('company_email',__('System Email *'))); ?>

                                                    <?php echo e(Form::text('company_email',null,array('class'=>'form-control'))); ?>

                                                    <?php $__errorArgs = ['company_email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                                    <span class="invalid-company_email" role="alert">
                                                            <strong class="text-danger"><?php echo e($message); ?></strong>
                                                        </span>
                                                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                                </div>
                                                <div class="form-group col-md-6">
                                                    <?php echo e(Form::label('company_email_from_name',__('Email (From Name) *'))); ?>

                                                    <?php echo e(Form::text('company_email_from_name',null,array('class'=>'form-control font-style'))); ?>

                                                    <?php $__errorArgs = ['company_email_from_name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                                    <span class="invalid-company_email_from_name" role="alert">
                                                            <strong class="text-danger"><?php echo e($message); ?></strong>
                                                        </span>
                                                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                                </div>
                                                <div class="form-group col-md-6">
                                                    <?php echo e(Form::label('registration_number',__('Company Registration Number *'))); ?>

                                                    <?php echo e(Form::text('registration_number',null,array('class'=>'form-control'))); ?>

                                                    <?php $__errorArgs = ['registration_number'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                                    <span class="invalid-registration_number" role="alert">
                                                            <strong class="text-danger"><?php echo e($message); ?></strong>
                                                        </span>
                                                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                                </div>
                                                <div class="form-group col-md-6">
                                                    <?php echo e(Form::label('vat_number',__('VAT Number *'))); ?>

                                                    <?php echo e(Form::text('vat_number',null,array('class'=>'form-control'))); ?>

                                                    <?php $__errorArgs = ['vat_number'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                                    <span class="invalid-vat_number" role="alert">
                                                                <strong class="text-danger"><?php echo e($message); ?></strong>
                                                            </span>
                                                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                                </div>
                                                <div class="col-md-6">
                                                    <?php echo e(Form::label('timezone',__('Timezone'))); ?>

                                                    <select type="text" name="timezone" class="form-control custom-select" id="timezone">
                                                        <option value=""><?php echo e(__('Select Timezone')); ?></option>
                                                        <?php $__currentLoopData = $timezones; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $k=>$timezone): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                            <option value="<?php echo e($k); ?>" <?php echo e((env('TIMEZONE')==$k)?'selected':''); ?>><?php echo e($timezone); ?></option>
                                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                    </select>
                                                </div>
                                                <div class="form-group col-md-6">
                                                    <?php echo e(Form::label('company_start_time',__('Company Start Time *'))); ?>

                                                    <?php echo e(Form::time('company_start_time',null,array('class'=>'form-control'))); ?>

                                                    <?php $__errorArgs = ['company_start_time'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                                    <span class="invalid-company_start_time" role="alert">
                                                        <strong class="text-danger"><?php echo e($message); ?></strong>
                                                    </span>
                                                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                                </div>
                                                <div class="form-group col-md-6">
                                                    <?php echo e(Form::label('company_end_time',__('Company End Time *'))); ?>

                                                    <?php echo e(Form::time('company_end_time',null,array('class'=>'form-control'))); ?>

                                                    <?php $__errorArgs = ['company_end_time'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                                    <span class="invalid-company_end_time" role="alert">
                                                                    <strong class="text-danger"><?php echo e($message); ?></strong>
                                                                </span>
                                                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="card-footer text-right">
                                            <?php echo e(Form::submit(__('Save Change'),array('class'=>'btn btn-primary'))); ?>

                                        </div>
                                        <?php echo e(Form::close()); ?>

                                    </div>
                                </div>
                            <?php endif; ?>
                            <?php if(\Auth::user()->type=='super admin'): ?>
                                <div id="email-setting" class="tab-pane fade">
                                    <div class="card-body">
                                        <div class="row">
                                            <?php echo e(Form::open(array('route'=>'email.setting','method'=>'post'))); ?>

                                            <div class="row">
                                                <div class="form-group col-md-4">
                                                    <?php echo e(Form::label('mail_driver',__('Mail Driver'))); ?>

                                                    <?php echo e(Form::text('mail_driver',env('MAIL_DRIVER'),array('class'=>'form-control','placeholder'=>__('Enter Mail Driver')))); ?>

                                                    <?php $__errorArgs = ['mail_driver'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                                    <span class="invalid-mail_driver" role="alert">
                                                 <strong class="text-danger"><?php echo e($message); ?></strong>
                                                 </span>
                                                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                                </div>
                                                <div class="form-group col-md-4">
                                                    <?php echo e(Form::label('mail_host',__('Mail Host'))); ?>

                                                    <?php echo e(Form::text('mail_host',env('MAIL_HOST'),array('class'=>'form-control ','placeholder'=>__('Enter Mail Driver')))); ?>

                                                    <?php $__errorArgs = ['mail_host'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                                    <span class="invalid-mail_driver" role="alert">
                                                 <strong class="text-danger"><?php echo e($message); ?></strong>
                                                 </span>
                                                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                                </div>
                                                <div class="form-group col-md-4">
                                                    <?php echo e(Form::label('mail_port',__('Mail Port'))); ?>

                                                    <?php echo e(Form::text('mail_port',env('MAIL_PORT'),array('class'=>'form-control','placeholder'=>__('Enter Mail Port')))); ?>

                                                    <?php $__errorArgs = ['mail_port'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                                    <span class="invalid-mail_port" role="alert">
                                                    <strong class="text-danger"><?php echo e($message); ?></strong>
                                                </span>
                                                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                                </div>
                                                <div class="form-group col-md-4">
                                                    <?php echo e(Form::label('mail_username',__('Mail Username'))); ?>

                                                    <?php echo e(Form::text('mail_username',env('MAIL_USERNAME'),array('class'=>'form-control','placeholder'=>__('Enter Mail Username')))); ?>

                                                    <?php $__errorArgs = ['mail_username'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                                    <span class="invalid-mail_username" role="alert">
                                                 <strong class="text-danger"><?php echo e($message); ?></strong>
                                                 </span>
                                                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                                </div>
                                                <div class="form-group col-md-4">
                                                    <?php echo e(Form::label('mail_password',__('Mail Password'))); ?>

                                                    <?php echo e(Form::text('mail_password',env('MAIL_PASSWORD'),array('class'=>'form-control','placeholder'=>__('Enter Mail Password')))); ?>

                                                    <?php $__errorArgs = ['mail_password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                                    <span class="invalid-mail_password" role="alert">
                                                 <strong class="text-danger"><?php echo e($message); ?></strong>
                                                 </span>
                                                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                                </div>
                                                <div class="form-group col-md-4">
                                                    <?php echo e(Form::label('mail_encryption',__('Mail Encryption'))); ?>

                                                    <?php echo e(Form::text('mail_encryption',env('MAIL_ENCRYPTION'),array('class'=>'form-control','placeholder'=>__('Enter Mail Encryption')))); ?>

                                                    <?php $__errorArgs = ['mail_encryption'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                                    <span class="invalid-mail_encryption" role="alert">
                                                 <strong class="text-danger"><?php echo e($message); ?></strong>
                                                 </span>
                                                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                                </div>
                                                <div class="form-group col-md-4">
                                                    <?php echo e(Form::label('mail_from_address',__('Mail From Address'))); ?>

                                                    <?php echo e(Form::text('mail_from_address',env('MAIL_FROM_ADDRESS'),array('class'=>'form-control','placeholder'=>__('Enter Mail From Address')))); ?>

                                                    <?php $__errorArgs = ['mail_from_address'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                                    <span class="invalid-mail_from_address" role="alert">
                                                 <strong class="text-danger"><?php echo e($message); ?></strong>
                                                 </span>
                                                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                                </div>
                                                <div class="form-group col-md-4">
                                                    <?php echo e(Form::label('mail_from_name',__('Mail From Name'))); ?>

                                                    <?php echo e(Form::text('mail_from_name',env('MAIL_FROM_NAME'),array('class'=>'form-control','placeholder'=>__('Enter Mail Encryption')))); ?>

                                                    <?php $__errorArgs = ['mail_from_name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                                    <span class="invalid-mail_from_name" role="alert">
                                                 <strong class="text-danger"><?php echo e($message); ?></strong>
                                                 </span>
                                                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                                </div>
                                            </div>
                                            <div class="card-footer text-right">
                                                <?php echo e(Form::submit(__('Save Change'),array('class'=>'btn btn-primary'))); ?>

                                            </div>
                                            <div class="card-footer text-right">
                                                <a href="#" data-url="<?php echo e(route('test.mail' )); ?>" data-ajax-popup="true" data-title="<?php echo e(__('Send Test Mail')); ?>" class="btn btn-primary btn-action mr-1 float-right">
                                                    <?php echo e(__('Send Test Mail')); ?>

                                                </a>
                                            </div>
                                            <?php echo e(Form::close()); ?>

                                        </div>
                                    </div>
                                </div>
                            <?php endif; ?>
                            <?php if(\Auth::user()->type=='company'): ?>
                                <div id="system-setting" class="tab-pane fade">
                                    <div class="card-body">
                                        <div class="row">
                                            <?php echo e(Form::model($settings,array('route'=>'system.setting','method'=>'post'))); ?>

                                            <div class="row">
                                                <div class="form-group col-md-6">
                                                    <?php echo e(Form::label('site_currency',__('Currency *'))); ?>

                                                    <?php echo e(Form::text('site_currency',null,array('class'=>'form-control font-style'))); ?>

                                                    <?php $__errorArgs = ['site_currency'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                                    <span class="invalid-site_currency" role="alert">
                                                            <strong class="text-danger"><?php echo e($message); ?></strong>
                                                        </span>
                                                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                                </div>
                                                <div class="form-group col-md-6">
                                                    <?php echo e(Form::label('site_currency_symbol',__('Currency Symbol *'))); ?>

                                                    <?php echo e(Form::text('site_currency_symbol',null,array('class'=>'form-control'))); ?>

                                                    <?php $__errorArgs = ['site_currency_symbol'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                                    <span class="invalid-site_currency_symbol" role="alert">
                                                            <strong class="text-danger"><?php echo e($message); ?></strong>
                                                        </span>
                                                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label class="form-control-label" for="example3cols3Input"><?php echo e(__('Currency Symbol Position')); ?></label>
                                                        <div class="row">
                                                            <div class="col-md-6">
                                                                <div class="custom-control custom-radio mb-3">

                                                                    <input type="radio" id="customRadio5" name="site_currency_symbol_position" value="pre" class="custom-control-input" <?php if(@$settings['site_currency_symbol_position'] == 'pre'): ?> checked <?php endif; ?>>
                                                                    <label class="custom-control-label" for="customRadio5"><?php echo e(__('Pre')); ?></label>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <div class="custom-control custom-radio mb-3">
                                                                    <input type="radio" id="customRadio6" name="site_currency_symbol_position" value="post" class="custom-control-input" <?php if(@$settings['site_currency_symbol_position'] == 'post'): ?> checked <?php endif; ?>>
                                                                    <label class="custom-control-label" for="customRadio6"><?php echo e(__('Post')); ?></label>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group col-md-6">
                                                    <label for="site_date_format" class="form-control-label"><?php echo e(__('Date Format')); ?></label>
                                                    <select type="text" name="site_date_format" class="form-control selectric" id="site_date_format">
                                                        <option value="M j, Y" <?php if(@$settings['site_date_format'] == 'M j, Y'): ?> selected="selected" <?php endif; ?>>Jan 1,2015</option>
                                                        <option value="d-m-Y" <?php if(@$settings['site_date_format'] == 'd-m-Y'): ?> selected="selected" <?php endif; ?>>d-m-y</option>
                                                        <option value="m-d-Y" <?php if(@$settings['site_date_format'] == 'm-d-Y'): ?> selected="selected" <?php endif; ?>>m-d-y</option>
                                                        <option value="Y-m-d" <?php if(@$settings['site_date_format'] == 'Y-m-d'): ?> selected="selected" <?php endif; ?>>y-m-d</option>
                                                    </select>
                                                </div>
                                                <div class="form-group col-md-6">
                                                    <label for="site_time_format" class="form-control-label"><?php echo e(__('Time Format')); ?></label>
                                                    <select type="text" name="site_time_format" class="form-control selectric" id="site_time_format">
                                                        <option value="g:i A" <?php if(@$settings['site_time_format'] == 'g:i A'): ?> selected="selected" <?php endif; ?>>10:30 PM</option>
                                                        <option value="g:i a" <?php if(@$settings['site_time_format'] == 'g:i a'): ?> selected="selected" <?php endif; ?>>10:30 pm</option>
                                                        <option value="H:i" <?php if(@$settings['site_time_format'] == 'H:i'): ?> selected="selected" <?php endif; ?>>22:30</option>
                                                    </select>
                                                </div>
                                                <div class="form-group col-md-6">
                                                    <?php echo e(Form::label('client_prefix',__('Client Prefix'))); ?>

                                                    <?php echo e(Form::text('client_prefix',null,array('class'=>'form-control'))); ?>

                                                    <?php $__errorArgs = ['client_prefix'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                                    <span class="invalid-client_prefix" role="alert">
                                                <strong class="text-danger"><?php echo e($message); ?></strong>
                                            </span>
                                                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                                </div>
                                                <div class="form-group col-md-6">
                                                    <?php echo e(Form::label('employee_prefix',__('Employee Prefix'))); ?>

                                                    <?php echo e(Form::text('employee_prefix',null,array('class'=>'form-control'))); ?>

                                                    <?php $__errorArgs = ['employee_prefix'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                                    <span class="invalid-employee_prefix" role="alert">
                                                <strong class="text-danger"><?php echo e($message); ?></strong>
                                            </span>
                                                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                                </div>
                                                <div class="form-group col-md-6">
                                                    <?php echo e(Form::label('estimate_prefix',__('Estimate Prefix'))); ?>

                                                    <?php echo e(Form::text('estimate_prefix',null,array('class'=>'form-control'))); ?>

                                                    <?php $__errorArgs = ['estimate_prefix'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                                    <span class="invalid-estimate_prefix" role="alert">
                                                <strong class="text-danger"><?php echo e($message); ?></strong>
                                            </span>
                                                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                                </div>
                                                <div class="form-group col-md-6">
                                                    <?php echo e(Form::label('invoice_prefix',__('Invoice Prefix'))); ?>

                                                    <?php echo e(Form::text('invoice_prefix',null,array('class'=>'form-control'))); ?>

                                                    <?php $__errorArgs = ['invoice_prefix'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                                    <span class="invalid-invoice_prefix" role="alert">
                                                <strong class="text-danger"><?php echo e($message); ?></strong>
                                            </span>
                                                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                                </div>
                                                <div class="form-group col-md-6">
                                                    <?php echo e(Form::label('footer_title',__('Estimate/Invoice Footer Title'))); ?>

                                                    <?php echo e(Form::text('footer_title',null,array('class'=>'form-control'))); ?>

                                                    <?php $__errorArgs = ['footer_title'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                                    <span class="invalid-footer_title" role="alert">
                                                <strong class="text-danger"><?php echo e($message); ?></strong>
                                            </span>
                                                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                                </div>
                                                <div class="form-group col-md-6">
                                                    <?php echo e(Form::label('footer_notes',__('Estimate/Invoice Footer Notes'))); ?>

                                                    <?php echo e(Form::textarea('footer_notes', null, ['class'=>'form-control','rows'=>'4'])); ?>

                                                    <?php $__errorArgs = ['footer_notes'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                                    <span class="invalid-footer_notes" role="alert">
                                                <strong class="text-danger"><?php echo e($message); ?></strong>
                                            </span>
                                                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                                </div>
                                                <div class="col-md-12">
                                                    <div class="text-right">
                                                        <?php echo e(Form::submit(__('Save Change'),array('class'=>'btn btn-primary'))); ?>

                                                    </div>
                                                </div>
                                            </div>
                                            <?php echo e(Form::close()); ?>

                                        </div>
                                    </div>
                                </div>
                            <?php endif; ?>
                            <?php if(\Auth::user()->type=='company'): ?>
                                <div id="estimate-template-setting" class="tab-pane fade">
                                    <div class="col-md-12">
                                        <div class="row">
                                            <div class="col-md-2">
                                                <form id="setting-form" method="post" action="<?php echo e(route('estimate.template.setting')); ?>">
                                                    <?php echo csrf_field(); ?>
                                                    <div class="form-group">
                                                        <label for="address"><?php echo e(__('Estimate Template')); ?></label>
                                                        <select class="form-control" name="estimate_template">
                                                            <?php $__currentLoopData = Utility::templateData()['templates']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $template): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                                <option value="<?php echo e($key); ?>" <?php echo e((isset($settings['estimate_template']) && $settings['estimate_template'] == $key) ? 'selected' : ''); ?>> <?php echo e($template); ?> </option>
                                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                        </select>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="form-label"><?php echo e(__('Color Input')); ?></label>
                                                        <div class="row gutters-xs">
                                                            <?php $__currentLoopData = Utility::templateData()['colors']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $color): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                                <div class="col-auto">
                                                                    <label class="colorinput">
                                                                        <input name="estimate_color" type="radio" value="<?php echo e($color); ?>" class="colorinput-input" <?php echo e((isset($settings['estimate_color']) && $settings['estimate_color'] == $color) ? 'checked' : ''); ?>>
                                                                        <span class="colorinput-color" style="background: #<?php echo e($color); ?>"></span>
                                                                    </label>
                                                                </div>
                                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                        </div>
                                                    </div>
                                                    <button class="btn btn-primary">
                                                        <?php echo e(__('Save')); ?>

                                                    </button>
                                                </form>
                                            </div>
                                            <div class="col-md-10">
                                                <?php if(isset($settings['estimate_template']) && isset($settings['estimate_color'])): ?>
                                                    <iframe id="estimate_frame" class="w-100 h-1220" frameborder="0" src="<?php echo e(route('estimate.preview',[$settings['estimate_template'],$settings['estimate_color']])); ?>"></iframe>
                                                <?php else: ?>
                                                    <iframe id="estimate_frame" class="w-100 h-1220" frameborder="0" src="<?php echo e(route('estimate.preview',['template1','fffff'])); ?>"></iframe>
                                                <?php endif; ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php endif; ?>
                            <?php if(\Auth::user()->type=='company'): ?>
                                <div id="invoice-template-setting" class="tab-pane fade">
                                    <div class="col-md-12">
                                        <div class="row">
                                            <div class="col-md-2">
                                                <form id="setting-form" method="post" action="<?php echo e(route('invoice.template.setting')); ?>">
                                                    <?php echo csrf_field(); ?>
                                                    <div class="form-group">
                                                        <label for="address"><?php echo e(__('Invoice Template')); ?></label>
                                                        <select class="form-control" name="invoice_template">
                                                            <?php $__currentLoopData = Utility::templateData()['templates']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $template): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                                <option value="<?php echo e($key); ?>" <?php echo e((isset($settings['estimate_template']) && $settings['estimate_template'] == $key) ? 'selected' : ''); ?>> <?php echo e($template); ?> </option>
                                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                        </select>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="form-label"><?php echo e(__('Color Input')); ?></label>
                                                        <div class="row gutters-xs">
                                                            <?php $__currentLoopData = Utility::templateData()['colors']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $color): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                                <div class="col-auto">
                                                                    <label class="colorinput">
                                                                        <input name="invoice_color" type="radio" value="<?php echo e($color); ?>" class="colorinput-input" <?php echo e((isset($settings['invoice_color']) && $settings['invoice_color'] == $color) ? 'checked' : ''); ?>>
                                                                        <span class="colorinput-color" style="background: #<?php echo e($color); ?>"></span>
                                                                    </label>
                                                                </div>
                                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                        </div>
                                                    </div>
                                                    <button class="btn btn-primary">
                                                        <?php echo e(__('Save')); ?>

                                                    </button>
                                                </form>
                                            </div>
                                            <div class="col-md-10">
                                                <?php if(isset($settings['invoice_template']) && isset($settings['invoice_color'])): ?>
                                                    <iframe id="invoice_frame" class="w-100 h-1220" frameborder="0" src="<?php echo e(route('invoice.preview',[$settings['invoice_template'],$settings['invoice_color']])); ?>"></iframe>
                                                <?php else: ?>
                                                    <iframe id="invoice_frame" class="w-100 h-1220" frameborder="0" src="<?php echo e(route('invoice.preview',['template1','fffff'])); ?>"></iframe>
                                                <?php endif; ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php endif; ?>
                            <?php if(\Auth::user()->type=='super admin'): ?>
                                <div id="pusher-template-setting" class="tab-pane fade">
                                    <?php echo e(Form::model($settings,array('route'=>'pusher.setting','method'=>'post'))); ?>

                                    <div class="row">
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="form-group col-md-6">
                                                    <?php echo e(Form::label('pusher_app_id *',__('Pusher App Id *'))); ?>

                                                    <?php echo e(Form::text('pusher_app_id',env('PUSHER_APP_ID'),array('class'=>'form-control font-style'))); ?>

                                                    <?php $__errorArgs = ['pusher_app_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                                    <span class="invalid-pusher_app_id" role="alert">
                                                    <strong class="text-danger"><?php echo e($message); ?></strong>
                                                </span>
                                                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                                </div>
                                                <div class="form-group col-md-6">
                                                    <?php echo e(Form::label('pusher_app_key',__('Pusher App Key'))); ?>

                                                    <?php echo e(Form::text('pusher_app_key',env('PUSHER_APP_KEY'),array('class'=>'form-control font-style'))); ?>

                                                    <?php $__errorArgs = ['pusher_app_key'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                                    <span class="invalid-pusher_app_key" role="alert">
                                                    <strong class="text-danger"><?php echo e($message); ?></strong>
                                                </span>
                                                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                                </div>
                                                <div class="form-group col-md-6">
                                                    <?php echo e(Form::label('pusher_app_secret',__('Pusher App Secret'))); ?>

                                                    <?php echo e(Form::text('pusher_app_secret',env('PUSHER_APP_SECRET'),array('class'=>'form-control font-style'))); ?>

                                                    <?php $__errorArgs = ['pusher_app_secret'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                                    <span class="invalid-pusher_app_secret" role="alert">
                                                    <strong class="text-danger"><?php echo e($message); ?></strong>
                                                </span>
                                                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                                </div>
                                                <div class="form-group col-md-6">
                                                    <?php echo e(Form::label('pusher_app_cluster',__('Pusher App Cluster'))); ?>

                                                    <?php echo e(Form::text('pusher_app_cluster',env('PUSHER_APP_CLUSTER'),array('class'=>'form-control font-style'))); ?>

                                                    <?php $__errorArgs = ['pusher_app_cluster'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                                    <span class="invalid-pusher_app_cluster" role="alert">
                                                    <strong class="text-danger"><?php echo e($message); ?></strong>
                                                </span>
                                                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-footer text-right">
                                        <?php echo e(Form::submit(__('Save Change'),array('class'=>'btn btn-primary'))); ?>

                                    </div>
                                    <?php echo e(Form::close()); ?>

                                </div>
                            <?php endif; ?>
                            <?php if(\Auth::user()->type=='super admin'): ?>
                                <div class="tab-pane fade" id="payment-template-setting" role="tabpanel">
                                    <div class="row">
                                        <div class="card-body">
                                            <?php echo e(Form::open(array('route'=>'payment.setting','method'=>'post'))); ?>

                                            <div class="row">
                                                <div class="form-group col-md-12">
                                                    <h5><?php echo e(__("This detail will use for collect payment on invoice from clients. On invoice client will find out pay now button based on your below configuration.")); ?></h5>
                                                </div>
                                                <div class="form-group col-md-6">
                                                    <?php echo e(Form::label('currency_symbol',__('Currency Symbol *'))); ?>

                                                    <?php echo e(Form::text('currency_symbol',env('CURRENCY_SYMBOL'),array('class'=>'form-control','required'))); ?>

                                                    <?php $__errorArgs = ['currency_symbol'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                                    <span class="invalid-currency_symbol" role="alert">
                                                    <strong class="text-danger"><?php echo e($message); ?></strong>
                                                </span>
                                                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                                </div>
                                                <div class="form-group col-md-6">
                                                    <?php echo e(Form::label('currency',__('Currency *'))); ?>

                                                    <?php echo e(Form::text('currency',env('CURRENCY'),array('class'=>'form-control font-style','required'))); ?>

                                                    <small> <?php echo e(__('Note: Add currency code as per three-letter ISO code.')); ?><br> <a href="https://stripe.com/docs/currencies" target="_blank"><?php echo e(__('you can find out here..')); ?></a></small> <br>
                                                    <?php $__errorArgs = ['currency'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                                    <span class="invalid-currency" role="alert">
                                                    <strong class="text-danger"><?php echo e($message); ?></strong>
                                                </span>
                                                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                                </div>
                                                <div class="form-group col-md-6">
                                                    <h2><?php echo e(__('Stripe')); ?></h2>
                                                </div>
                                                <div class="form-group col-md-12">
                                                    <?php echo e(Form::label('is_enable_stripe',__('Enable Stripe'), ['class' => 'custom-toggle-btn'])); ?>

                                                    <label class="custom-toggle">
                                                        <input type="checkbox" name="enable_stripe" <?php echo e(env('ENABLE_STRIPE') == 'on' ? 'checked="checked"' : ''); ?>>
                                                        <span class="custom-toggle-slider rounded-circle"></span>
                                                    </label>

                                                </div>
                                                <div class="form-group col-md-6">
                                                    <?php echo e(Form::label('stripe_key',__('Stripe Key'))); ?>

                                                    <?php echo e(Form::text('stripe_key',env('STRIPE_KEY'),['class'=>'form-control','placeholder'=>__('Enter Stripe Key')])); ?>

                                                    <?php $__errorArgs = ['stripe_key'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                                    <span class="invalid-stripe_key" role="alert">
                                                                 <strong class="text-danger"><?php echo e($message); ?></strong>
                                                             </span>
                                                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                                </div>
                                                <div class="form-group col-md-6">
                                                    <?php echo e(Form::label('stripe_secret',__('Stripe Secret'))); ?>

                                                    <?php echo e(Form::text('stripe_secret',env('STRIPE_SECRET'),['class'=>'form-control ','placeholder'=>__('Enter Stripe Secret')])); ?>

                                                    <?php $__errorArgs = ['stripe_secret'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                                    <span class="invalid-stripe_secret" role="alert">
                                                     <strong class="text-danger"><?php echo e($message); ?></strong>
                                                 </span>
                                                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                                </div>
                                                <div class="form-group col-md-6">
                                                    <h2><?php echo e(__('Paypal')); ?></h2>
                                                </div>
                                                <div class="form-group col-md-12">
                                                    <?php echo e(Form::label('enable_stripe',__('Enable Paypal'), ['class' => 'custom-toggle-btn'])); ?>

                                                    <label class="custom-toggle">
                                                        <input type="checkbox" name="enable_paypal" class="custom-switch-input" <?php echo e(env('ENABLE_PAYPAL') == 'on' ? 'checked="checked"' : ''); ?>>
                                                        <span class="custom-toggle-slider rounded-circle"></span>
                                                    </label>
                                                </div>
                                                <div class="form-group form-group col-md-12">
                                                    <label for="paypal_mode" class="custom-radio"><?php echo e(__('Paypal Mode')); ?></label>
                                                    <div class="custom-control custom-radio custom-control-inline">
                                                        <input type="radio" id="customRadioInline1" name="paypal_mode" value="sandbox" class="custom-control-input" <?php echo e(env('PAYPAL_MODE') == '' || env('PAYPAL_MODE') == 'sandbox' ? 'checked="checked"' : ''); ?>>
                                                        <label class="custom-control-label" for="customRadioInline1"><?php echo e(__('Sandbox')); ?></label>
                                                    </div>
                                                    <div class="custom-control custom-radio custom-control-inline ">
                                                        <input type="radio" id="customRadioInline2" name="paypal_mode" value="live" class="custom-control-input" <?php echo e(env('PAYPAL_MODE') == 'live' ? 'checked="checked"' : ''); ?>>
                                                        <label class="custom-control-label" for="customRadioInline2"><?php echo e(__('Live')); ?></label>
                                                    </div>
                                                </div>
                                                <div class="form-group col-md-6">
                                                    <label for="paypal_client_id"><?php echo e(__('Client ID')); ?></label>
                                                    <input type="text" name="paypal_client_id" id="paypal_client_id" class="form-control" value="<?php echo e(env('PAYPAL_CLIENT_ID')); ?>" placeholder="<?php echo e(__('Client ID')); ?>"/>
                                                    <?php if($errors->has('paypal_client_id')): ?>
                                                        <span class="invalid-feedback d-block">
                                                        <?php echo e($errors->first('paypal_client_id')); ?>

                                                    </span>
                                                    <?php endif; ?>
                                                </div>
                                                <div class="form-group col-md-6">
                                                    <label for="paypal_secret_key"><?php echo e(__('Secret Key')); ?></label>
                                                    <input type="text" name="paypal_secret_key" id="paypal_secret_key" class="form-control" value="<?php echo e(env('PAYPAL_SECRET_KEY')); ?>" placeholder="<?php echo e(__('Secret Key')); ?>"/>
                                                    <?php if($errors->has('paypal_secret_key')): ?>
                                                        <span class="invalid-feedback d-block">
                                                        <?php echo e($errors->first('paypal_secret_key')); ?>

                                                    </span>
                                                    <?php endif; ?>
                                                </div>
                                                <div class="col-md-12">
                                                    <div class="card-footer text-right">
                                                        <?php echo e(Form::submit(__('Save Change'),array('class'=>'btn btn-primary'))); ?>

                                                    </div>
                                                </div>
                                            </div>
                                            <?php echo e(Form::close()); ?>

                                        </div>
                                    </div>
                                </div>
                            <?php endif; ?>
                            <?php if(\Auth::user()->type=='company'): ?>
                                <div class="tab-pane fade" id="company-payment-template-setting" role="tabpanel">
                                    <div class="row">
                                        <div class="card-body">
                                            <?php echo e(Form::model($settings,['route'=>'company.payment.setting', 'method'=>'POST'])); ?>

                                            <div class="row">
                                                <div class="form-group col-md-12">
                                                    <h5><?php echo e(__("This detail will use for collect payment on invoice from clients. On invoice client will find out pay now button based on your below configuration.")); ?></h5>
                                                </div>
                                                <div class="form-group col-md-6">
                                                    <h2><?php echo e(__('Stripe')); ?></h2>
                                                </div>
                                                <div class="form-group col-md-12">
                                                    <?php echo e(Form::label('is_enable_stripe',__('Enable Stripe'), ['class' => 'custom-toggle-btn'])); ?>

                                                    <label class="custom-toggle">
                                                        <input type="checkbox" name="enable_stripe" <?php echo e(isset($settings['enable_stripe']) && $settings['enable_stripe'] == 'on' ? 'checked="checked"' : ''); ?>>
                                                        <span class="custom-toggle-slider rounded-circle"></span>
                                                    </label>
                                                </div>
                                                <div class="form-group col-md-6">
                                                    <?php echo e(Form::label('stripe_key',__('Stripe Key'))); ?>

                                                    <?php echo e(Form::text('stripe_key',(isset($settings['stripe_key'])?$settings['stripe_key']:''),['class'=>'form-control','placeholder'=>__('Enter Stripe Key')])); ?>

                                                    <?php $__errorArgs = ['stripe_key'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                                    <span class="invalid-stripe_key" role="alert">
                                                         <strong class="text-danger"><?php echo e($message); ?></strong>
                                                     </span>
                                                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                                </div>
                                                <div class="form-group col-md-6">
                                                    <?php echo e(Form::label('stripe_secret',__('Stripe Secret'))); ?>

                                                    <?php echo e(Form::text('stripe_secret',(isset($settings['stripe_secret'])?$settings['stripe_secret']:''),['class'=>'form-control ','placeholder'=>__('Enter Stripe Secret')])); ?>

                                                    <?php $__errorArgs = ['stripe_secret'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                                    <span class="invalid-stripe_secret" role="alert">
                                                     <strong class="text-danger"><?php echo e($message); ?></strong>
                                                 </span>
                                                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                                </div>
                                                <div class="form-group col-md-6">
                                                    <h2><?php echo e(__('Paypal')); ?></h2>
                                                </div>
                                                <div class="form-group col-md-12">
                                                    <?php echo e(Form::label('enable_stripe',__('Enable Paypal'), ['class' => 'custom-toggle-btn'])); ?>

                                                    <label class="custom-toggle">
                                                        <input type="checkbox" name="enable_paypal" class="custom-switch-input" <?php echo e(isset($settings['enable_paypal']) && $settings['enable_paypal'] == 'on' ? 'checked="checked"' : ''); ?>>
                                                        <span class="custom-toggle-slider rounded-circle"></span>
                                                    </label>
                                                </div>
                                                <div class="form-group form-group col-md-12">
                                                    <label for="paypal_mode" class="custom-radio"><?php echo e(__('Paypal Mode')); ?></label>
                                                    <div class="custom-control custom-radio custom-control-inline">
                                                        <input type="radio" id="customRadioInline1" name="paypal_mode" value="sandbox" class="custom-control-input"<?php echo e(isset($settings['paypal_mode']) &&  $settings['paypal_mode'] == '' || isset($settings['paypal_mode']) && $settings['paypal_mode'] == 'sandbox' ? 'checked="checked"' : ''); ?>>
                                                        <label class="custom-control-label" for="customRadioInline1"><?php echo e(__('Sandbox')); ?></label>
                                                    </div>
                                                    <div class="custom-control custom-radio custom-control-inline ">
                                                        <input type="radio" id="customRadioInline2" name="paypal_mode" value="live" class="custom-control-input" <?php echo e(isset($settings['paypal_mode']) &&  $settings['paypal_mode'] == 'live' ? 'checked="checked"' : ''); ?>>
                                                        <label class="custom-control-label" for="customRadioInline2"><?php echo e(__('Live')); ?></label>
                                                    </div>
                                                </div>
                                                <div class="form-group col-md-6">
                                                    <label for="paypal_client_id"><?php echo e(__('Client ID')); ?></label>
                                                    <input type="text" name="paypal_client_id" id="paypal_client_id" class="form-control" value="<?php echo e(isset($settings['paypal_client_id'])?$settings['paypal_client_id']:''); ?>" placeholder="<?php echo e(__('Client ID')); ?>"/>
                                                    <?php if($errors->has('paypal_client_id')): ?>
                                                        <span class="invalid-feedback d-block">
                                                        <?php echo e($errors->first('paypal_client_id')); ?>

                                                    </span>
                                                    <?php endif; ?>
                                                </div>
                                                <div class="form-group col-md-6">
                                                    <label for="paypal_secret_key"><?php echo e(__('Secret Key')); ?></label>
                                                    <input type="text" name="paypal_secret_key" id="paypal_secret_key" class="form-control" value="<?php echo e(isset($settings['paypal_secret_key'])?$settings['paypal_secret_key']:''); ?>" placeholder="<?php echo e(__('Secret Key')); ?>"/>
                                                    <?php if($errors->has('paypal_secret_key')): ?>
                                                        <span class="invalid-feedback d-block">
                                                        <?php echo e($errors->first('paypal_secret_key')); ?>

                                                    </span>
                                                    <?php endif; ?>
                                                </div>
                                                <div class="col-md-12">
                                                    <div class="card-footer text-right">
                                                        <?php echo e(Form::submit(__('Save Change'),array('class'=>'btn btn-primary'))); ?>

                                                    </div>
                                                </div>
                                            </div>
                                            <?php echo e(Form::close()); ?>

                                        </div>
                                    </div>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>


<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/mitaapps/public_html/dekomdmc/main_file/resources/views/settings/index.blade.php ENDPATH**/ ?>