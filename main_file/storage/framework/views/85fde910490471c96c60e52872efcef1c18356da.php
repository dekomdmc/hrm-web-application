<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://fonts.googleapis.com/css?family=Lato&amp;display=swap" rel="stylesheet">
    <link rel="stylesheet" href="<?php echo e(asset('assets/css/app.css')); ?>">

    <style type="text/css">
        .resize-observer[data-v-b329ee4c] {
            position: absolute;
            top: 0;
            left: 0;
            z-index: -1;
            width: 100%;
            height: 100%;
            border: none;
            background-color: transparent;
            pointer-events: none;
            display: block;
            overflow: hidden;
            opacity: 0
        }

        .resize-observer[data-v-b329ee4c] object {
            display: block;
            position: absolute;
            top: 0;
            left: 0;
            height: 100%;
            width: 100%;
            overflow: hidden;
            pointer-events: none;
            z-index: -1
        }
    </style>
    <style type="text/css">
        p[data-v-f2a183a6] {
            line-height: 1.2em;
            margin: 0 0 2px 0;
        }

        pre[data-v-f2a183a6] {
            margin: 0;
        }

        .d-table[data-v-f2a183a6] {
            margin-top: 20px;
        }

        .d-table-footer[data-v-f2a183a6] {
            display: -webkit-box;
            display: flex;
        }

        .d-table-controls[data-v-f2a183a6] {
            -webkit-box-flex: 2;
            flex: 2;
        }

        .d-table-summary[data-v-f2a183a6] {
            -webkit-box-flex: 1;
            flex: 1;
        }

        .d-table-summary-item[data-v-f2a183a6] {
            width: 100%;
            display: -webkit-box;
            display: flex;
        }

        .d-table-label[data-v-f2a183a6] {
            -webkit-box-flex: 1;
            flex: 1;
            display: -webkit-box;
            display: flex;
            -webkit-box-pack: end;
            justify-content: flex-end;
            padding-top: 9px;
            padding-bottom: 9px;
        }

        .d-table-label .form-input[data-v-f2a183a6] {
            margin-left: 10px;
            width: 80px;
            height: 24px;
        }

        .d-table-label .form-input-mask-text[data-v-f2a183a6] {
            top: 3px;
        }

        .d-table-value[data-v-f2a183a6] {
            -webkit-box-flex: 1;
            flex: 1;
            text-align: right;
            padding-top: 9px;
            padding-bottom: 9px;
            padding-right: 10px;
        }

        .d-table-spacer[data-v-f2a183a6] {
            margin-top: 5px;
        }

        .d-table-tr[data-v-f2a183a6] {
            display: -webkit-box;
            display: flex;
            flex-wrap: wrap;
        }


        .d-table-summary {
            padding: 0 0 0 50px !important;

        }

        .d-table-td[data-v-f2a183a6] {
            padding: 10px 10px 10px 10px;
        }

        .d-table-th[data-v-f2a183a6] {
            padding: 10px 10px 10px 10px;
            font-weight: bold;
        }

        .d-body[data-v-f2a183a6] {
            padding: 0px;
            font-size: 13px !important;
        }

        .d-table-tr {
            padding: 0 50px 0 50px;
        }

        .bill_to {
            padding: 50px;
        }

        .ship_to {
            padding: 50px;
        }

        .d[data-v-f2a183a6] {
            font-size: 0.9em !important;
            color: black;
            background: white;
            min-height: 1000px;
        }

        .d-right[data-v-f2a183a6] {
            text-align: right;
        }

        .d-title[data-v-f2a183a6] {
            font-size: 50px;
            line-height: 50px;
            font-weight: bold;
            margin-bottom: 20px;
        }

        .d-header-50[data-v-f2a183a6] {
            -webkit-box-flex: 1;
            flex: 1;
        }

        .d-header-50[data-v-f2a183a6] table {
            margin-left: 150px;
        }

        .d-header-inner[data-v-f2a183a6] {
            display: -webkit-box;
            display: flex;
            padding: 50px;
        }

        .d-header-brand[data-v-f2a183a6] {
            width: 200px;
        }

        .d-logo[data-v-f2a183a6] {
            max-width: 100%;
        }
    </style>
    <style type="text/css">
        p[data-v-37eeda86] {
            line-height: 1.2em;
            margin: 0 0 2px 0;
        }

        pre[data-v-37eeda86] {
            margin: 0;
        }

        img[data-v-37eeda86] {
            max-width: 100%;
        }

        .d-table-value[data-v-37eeda86] {
            padding-right: 0;
        }

        .d-table-controls[data-v-37eeda86] {
            -webkit-box-flex: 5;
            flex: 5;
        }

        .d-table-summary[data-v-37eeda86] {
            -webkit-box-flex: 4;
            flex: 4;
        }
    </style>
    <style type="text/css">
        p[data-v-e95a8a8c] {
            line-height: 1.2em;
            margin: 0 0 2px 0;
        }

        pre[data-v-e95a8a8c] {
            margin: 0;
        }

        img[data-v-e95a8a8c] {
            max-width: 100%;
        }

        .d[data-v-e95a8a8c] {
            font-family: monospace;
        }

        .fancy-title[data-v-e95a8a8c] {
            margin-top: 0;
            padding-top: 0;
        }

        .d-table-value[data-v-e95a8a8c] {
            padding-right: 0;
        }

        .d-table-controls[data-v-e95a8a8c] {
            -webkit-box-flex: 5;
            flex: 5;
        }

        .d-table-summary[data-v-e95a8a8c] {
            -webkit-box-flex: 4;
            flex: 4;
        }
    </style>
    <style type="text/css">
        p[data-v-363339a0] {
            line-height: 1.2em;
            margin: 0 0 2px 0;
        }

        pre[data-v-363339a0] {
            margin: 0;
        }

        img[data-v-363339a0] {
            max-width: 100%;
        }

        .fancy-title[data-v-363339a0] {
            margin-top: 0;
            font-size: 30px;
            line-height: 1.2em;
            padding-top: 0;
        }

        .f-b[data-v-363339a0] {
            font-size: 17px;
            line-height: 1.2em;
        }

        .thank[data-v-363339a0] {
            font-size: 45px;
            line-height: 1.2em;
            text-align: right;
            font-style: italic;
            padding-right: 25px;
        }

        .f-remarks[data-v-363339a0] {
            padding-left: 25px;
        }

        .d-table-value[data-v-363339a0] {
            padding-right: 0;
        }

        .d-table-controls[data-v-363339a0] {
            -webkit-box-flex: 5;
            flex: 5;
        }

        .d-table-summary[data-v-363339a0] {
            -webkit-box-flex: 4;
            flex: 4;
        }
    </style>
    <style type="text/css">
        p[data-v-e23d9750] {
            line-height: 1.2em;
            margin: 0 0 2px 0;
        }

        pre[data-v-e23d9750] {
            margin: 0;
        }

        img[data-v-e23d9750] {
            max-width: 100%;
        }

        .fancy-title[data-v-e23d9750] {
            margin-top: 0;
            font-size: 40px;
            line-height: 1.2em;
            font-weight: bold;
            padding: 25px;
            margin-right: 25px;
        }

        .f-b[data-v-e23d9750] {
            font-size: 17px;
            line-height: 1.2em;
        }

        .thank[data-v-e23d9750] {
            font-size: 45px;
            line-height: 1.2em;
            text-align: right;
            font-style: italic;
            padding-right: 25px;
        }

        .f-remarks[data-v-e23d9750] {
            padding: 25px;
        }

        .d-table-value[data-v-e23d9750] {
            padding-right: 0;
        }

        .d-table-controls[data-v-e23d9750] {
            -webkit-box-flex: 5;
            flex: 5;
        }

        .d-table-summary[data-v-e23d9750] {
            -webkit-box-flex: 4;
            flex: 4;
        }
    </style>
    <style type="text/css">
        p[data-v-4b3dcb8a] {
            line-height: 1.2em;
            margin: 0 0 2px 0;
        }

        pre[data-v-4b3dcb8a] {
            margin: 0;
        }

        img[data-v-4b3dcb8a] {
            max-width: 100%;
        }

        .fancy-title[data-v-4b3dcb8a] {
            margin-top: 0;
            padding-top: 0;
        }

        .sub-title[data-v-4b3dcb8a] {
            margin: 5px 0 3px 0;
            display: block;
        }

        .d-table-value[data-v-4b3dcb8a] {
            padding-right: 0;
        }

        .d-table-controls[data-v-4b3dcb8a] {
            -webkit-box-flex: 5;
            flex: 5;
        }

        .d-table-summary[data-v-4b3dcb8a] {
            -webkit-box-flex: 4;
            flex: 4;
        }
    </style>
    <style type="text/css">
        p[data-v-1ad6e3b9] {
            line-height: 1.2em;
            margin: 0 0 2px 0;
        }

        pre[data-v-1ad6e3b9] {
            margin: 0;
        }

        img[data-v-1ad6e3b9] {
            max-width: 100%;
        }

        .fancy-title[data-v-1ad6e3b9] {
            margin-top: 0;
            padding-top: 0;
        }

        .sub-title[data-v-1ad6e3b9] {
            margin: 5px 0 3px 0;
            display: block;
        }

        .d-no-pad[data-v-1ad6e3b9] {
            padding: 0px;
        }

        .grey-box[data-v-1ad6e3b9] {
            padding: 50px;
            background: #f8f8f8;
        }

        .d-inner-2[data-v-1ad6e3b9] {
            padding: 50px;
        }
    </style>
    <style type="text/css">
        p[data-v-136bf9b5] {
            line-height: 1.2em;
            margin: 0 0 2px 0;
        }

        pre[data-v-136bf9b5] {
            margin: 0;
        }

        img[data-v-136bf9b5] {
            max-width: 100%;
        }

        .fancy-title[data-v-136bf9b5] {
            margin-top: 0;
            padding-top: 0;
        }

        .d-table-value[data-v-136bf9b5] {
            padding-right: 0px;
        }
    </style>
    <style type="text/css">
        p[data-v-7d9d14b5] {
            line-height: 1.2em;
            margin: 0 0 2px 0;
        }

        pre[data-v-7d9d14b5] {
            margin: 0;
        }

        img[data-v-7d9d14b5] {
            max-width: 100%;
        }

        .fancy-title[data-v-7d9d14b5] {
            margin-top: 0;
            padding-top: 0;
        }

        .sub-title[data-v-7d9d14b5] {
            margin: 0 0 5px 0;
        }

        .padd[data-v-7d9d14b5] {
            margin-left: 5px;
            padding-left: 5px;
            border-left: 1px solid #f8f8f8;
            margin-right: 5px;
            padding-right: 5px;
            border-right: 1px solid #f8f8f8;
        }

        .d-inner[data-v-7d9d14b5] {
            padding-right: 0px;
        }

        .d-table-value[data-v-7d9d14b5] {
            padding-right: 5px;
        }

        .d-table-controls[data-v-7d9d14b5] {
            -webkit-box-flex: 5;
            flex: 5;
        }

        .d-table-summary[data-v-7d9d14b5] {
            -webkit-box-flex: 4;
            flex: 4;
        }
    </style>
    <style type="text/css">
        p[data-v-b8f60a0c] {
            line-height: 1.2em;
            margin: 0 0 2px 0;
        }

        pre[data-v-b8f60a0c] {
            margin: 0;
        }

        img[data-v-b8f60a0c] {
            max-width: 100%;
        }

        .fancy-title[data-v-b8f60a0c] {
            margin-top: 0;
            padding-top: 10px;
        }

        .d-table-value[data-v-b8f60a0c] {
            padding-right: 0;
        }

        .d-table-controls[data-v-b8f60a0c] {
            -webkit-box-flex: 5;
            flex: 5;
        }

        .d-table-summary[data-v-b8f60a0c] {
            -webkit-box-flex: 4;
            flex: 4;
        }

        .overflow-x-hidden {
            overflow-x: hidden !important;
        }
    </style>
</head>

<body class="">

    <div class="container">
        <div id="app" class="content">
            <div class="editor">
                <div class="invoice-preview-inner">
                    <div class="editor-content">
                        <div class="preview-main client-preview">
                            <div data-v-f2a183a6="" class="d" id="boxes" style="width:800px;margin-left: auto;margin-right: auto;">
                                <div data-v-f2a183a6="" class="d-header" style="background: <?php echo e($color); ?>;color:<?php echo e($font_color); ?>">
                                    <div data-v-f2a183a6="" class="d-header-inner">
                                        <div data-v-f2a183a6="" class="d-header-50">
                                            <div data-v-f2a183a6="" class="d-header-brand">
                                                <img src="<?php echo e($img); ?>" style="max-width: 250px" />
                                            </div>
                                            <div data-v-f2a183a6="" class="break-25"></div>

                                        </div>
                                        <div data-v-f2a183a6="" class="d-header-50 d-right">
                                            <div data-v-f2a183a6="" class="d-title"><?php echo e(__('INVOICE')); ?></div>
                                            <table style="width: 200px" data-v-f2a183a6="" class="summary-table">
                                                <tbody data-v-f2a183a6="">
                                                    <tr>
                                                        <td><?php echo e(__('Number')); ?>:</td>
                                                        <td><?php echo e(\App\Utility::invoiceNumberFormat($settings,$invoice->invoice)); ?></td>
                                                    </tr>
                                                    <tr>
                                                        <td><?php echo e(__('Issue Date')); ?>:</td>
                                                        <td><?php echo e(\App\Utility::dateFormat($settings,$invoice->issue_date)); ?></td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                                <div data-v-f2a183a6="" class="d-body">
                                    <div data-v-f2a183a6="" class="d-bill-to">
                                        <div class="row">
                                            <div class="bill_to">
                                                <strong data-v-f2a183a6=""><?php echo e(__('From')); ?>:</strong>
                                                <p>
                                                    <?php if($settings['company_name']): ?><?php echo e($settings['company_name']); ?><?php endif; ?><br>
                                                    <?php if($settings['company_address']): ?><?php echo e($settings['company_address']); ?><?php endif; ?>
                                                    <?php if($settings['company_city']): ?> <br> <?php echo e($settings['company_city']); ?>, <?php endif; ?> <?php if($settings['company_state']): ?><?php echo e($settings['company_state']); ?><?php endif; ?> <?php if($settings['company_zipcode']): ?> - <?php echo e($settings['company_zipcode']); ?><?php endif; ?>
                                                    <?php if($settings['company_country']): ?> <br><?php echo e($settings['company_country']); ?><?php endif; ?>
                                                </p>
                                                <p data-v-f2a183a6="">
                                                    <?php echo e(__('Registration Number')); ?> : <?php echo e($settings['registration_number']); ?> <br>
                                                    <?php echo e(__('VAT Number')); ?> : <?php echo e($settings['vat_number']); ?> <br>
                                                </p>
                                            </div>
                                            <div class="ship_to">
                                                <strong data-v-f2a183a6=""><?php echo e(__('To')); ?>:</strong>
                                                <p>
                                                    <?php echo e(!empty($client->company_name)?$client->company_name:''); ?><br>
                                                    <?php echo e(!empty($client->name)?$client->name:''); ?><br>
                                                    <?php echo e(!empty($client->email)?$client->email:''); ?><br>
                                                    <?php echo e(!empty($client->mobile)?$client->mobile:''); ?><br>
                                                    <?php echo e(!empty($client->address)?$client->address:''); ?><br>
                                                    <?php echo e(!empty($client->zip)?$client->zip:''); ?><br>
                                                    <?php echo e(!empty($client->city)?$client->city:'' . ', '); ?> <?php echo e(!empty($client->state)?$client->state:'' .', '); ?>,<?php echo e(!empty($client->country)?$client->country:''); ?>

                                                </p>
                                            </div>
                                        </div>
                                        <div data-v-363339a0="" class="d-table">
                                            <div data-v-363339a0="" class="d-table">
                                                <div data-v-f2a183a6="" class="d-table-tr" style="background: <?php echo e($color); ?>;color:<?php echo e($font_color); ?>">
                                                    <div class="d-table-th w-5"><?php echo e(__('Item')); ?></div>
                                                    <div class="d-table-th w-3"><?php echo e(__('Quantity')); ?></div>
                                                    <div class="d-table-th w-3"><?php echo e(__('Rate')); ?></div>
                                                    <div class="d-table-th w-6"><?php echo e(__('Tax')); ?> (%)</div>
                                                    <?php if($invoice->discount_apply==1): ?>
                                                    <div class="d-table-th w-3"><?php echo e(__('Discount')); ?></div>
                                                    <?php else: ?>
                                                    <div class="d-table-th w-3"></div>
                                                    <?php endif; ?>
                                                    <div class="d-table-th w-4 text-right"><?php echo e(__('Price')); ?><br><small class="text-danger"><?php echo e(__('before tax & discount')); ?></small>
                                                    </div>
                                                </div>
                                                <div class="d-table-body">
                                                    <?php if(isset($invoice->items) && count($invoice->items) > 0): ?>
                                                    <?php $__currentLoopData = $invoice->items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

                                                    <div class="d-table-tr" style="border-bottom:1px solid <?php echo e($color); ?>;">
                                                        <div class="d-table-td w-5">
                                                            <pre data-v-f2a183a6=""><?php echo e($item->name); ?></pre>
                                                        </div>
                                                        <div class="d-table-td w-3">
                                                            <pre data-v-f2a183a6=""><?php echo e($item->quantity); ?></pre>
                                                        </div>
                                                        <div class="d-table-td w-3">
                                                            <pre data-v-f2a183a6=""><?php echo e(\App\Utility::priceFormat($settings,$item->price)); ?></pre>
                                                        </div>
                                                        <div class="d-table-td w-6">
                                                            <pre data-v-f2a183a6="">
                                                                    <?php $__currentLoopData = $item->itemTax; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $taxes): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                                        <span><?php echo e($taxes['name']); ?></span>  <span>(<?php echo e($taxes['rate']); ?>)</span> <span><?php echo e($taxes['price']); ?></span>
                                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                                </pre>
                                                        </div>
                                                        <?php if($invoice->discount_apply==1): ?>
                                                        <div class="d-table-td w-3">
                                                            <pre data-v-f2a183a6=""><?php echo e(($item->discount!=0)?\App\Utility::priceFormat($settings,$item->discount):'-'); ?></pre>
                                                        </div>
                                                        <?php else: ?>
                                                        <div class="d-table-td w-3">
                                                            <pre data-v-f2a183a6="">-</pre>
                                                        </div>
                                                        <?php endif; ?>

                                                        <div class="d-table-td w-4 text-right"><span><?php echo e(\App\Utility::priceFormat($settings,$item->price * $item->quantity)); ?></span></div>
                                                    </div>
                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                    <?php else: ?>
                                                    <div class="d-table-tr" style="border-bottom:1px solid <?php echo e($color); ?>;">
                                                        <div class="d-table-td w-2"><span>-</span></div>
                                                        <div class="d-table-td w-7">
                                                            <pre data-v-f2a183a6="">-</pre>
                                                        </div>
                                                        <div class="d-table-td w-5">
                                                            <pre data-v-f2a183a6="">-</pre>
                                                        </div>
                                                        <div class="d-table-td w-5">
                                                            <pre data-v-f2a183a6="">-</pre>
                                                        </div>
                                                        <div class="d-table-td w-4 text-right"><span>-</span></div>
                                                    </div>
                                                    <?php endif; ?>
                                                </div>
                                                <div class="d-table-tr" style="border-bottom:1px solid <?php echo e($color); ?>;">
                                                    <div class="d-table-td w-5">
                                                        <pre data-v-f2a183a6=""><?php echo e(__('Total')); ?></pre>
                                                    </div>
                                                    <div class="d-table-td w-3">
                                                        <pre data-v-f2a183a6=""><?php echo e($invoice->totalQuantity); ?></pre>
                                                    </div>
                                                    <div class="d-table-td w-3">
                                                        <pre data-v-f2a183a6=""><?php echo e(\App\Utility::priceFormat($settings,$invoice->totalRate)); ?></pre>
                                                    </div>
                                                    <div class="d-table-td w-6">
                                                        <pre data-v-f2a183a6=""><?php echo e(\App\Utility::priceFormat($settings,$invoice->totalTaxPrice)); ?></pre>
                                                    </div>
                                                    <?php if($invoice->discount_apply==1): ?>
                                                    <div class="d-table-td w-3">
                                                        <pre data-v-f2a183a6=""><?php echo e(\App\Utility::priceFormat($settings,$invoice->totalDiscount)); ?></pre>
                                                    </div>
                                                    <?php else: ?>
                                                    <div class="d-table-td w-3">
                                                        <pre data-v-f2a183a6="">-</pre>
                                                    </div>
                                                    <?php endif; ?>

                                                    <div class="d-table-td w-4 text-right">
                                                        <span><?php echo e(\App\Utility::priceFormat($settings,$invoice->getSubTotal())); ?>

                                                        </span>
                                                    </div>
                                                </div>
                                                <div data-v-f2a183a6="" class="d-table-footer">
                                                    <div data-v-f2a183a6="" class="d-table-controls"></div>
                                                    <div data-v-f2a183a6="" class="d-table-summary">
                                                        <?php if($invoice->discount_apply==1): ?>
                                                        <?php if($invoice->getTotalDiscount()): ?>
                                                        <div data-v-f2a183a6="" class="d-table-summary-item">
                                                            <div data-v-f2a183a6="" class="d-table-label"><?php echo e(__('Discount')); ?>:</div>
                                                            <div data-v-f2a183a6="" class="d-table-value"><?php echo e(\App\Utility::priceFormat($settings,$invoice->getTotalDiscount())); ?></div>
                                                        </div>
                                                        <?php endif; ?>
                                                        <?php endif; ?>
                                                        <?php if(!empty($invoice->taxesData)): ?>
                                                        <?php $__currentLoopData = $invoice->taxesData; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $taxName => $taxPrice): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                        <div data-v-f2a183a6="" class="d-table-summary-item">
                                                            <div data-v-f2a183a6="" class="d-table-label"><?php echo e($taxName); ?> :</div>
                                                            <div data-v-f2a183a6="" class="d-table-value"><?php echo e(\App\Utility::priceFormat($settings,$taxPrice)); ?></div>
                                                        </div>
                                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                        <?php endif; ?>

                                                        <div data-v-f2a183a6="" class="d-table-summary-item" style="border-top: 1px solid <?php echo e($color); ?>; border-bottom: 1px solid <?php echo e($color); ?>;">
                                                            <div data-v-f2a183a6="" class="d-table-label"><?php echo e(__('Total')); ?>:</div>
                                                            <div data-v-f2a183a6="" class="d-table-value"><?php echo e(\App\Utility::priceFormat($settings,$invoice->getSubTotal()-$invoice->getTotalDiscount()+$invoice->getTotalTax())); ?></div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div data-v-f2a183a6="" class="d-header-50">
                                        <p data-v-f2a183a6="">
                                            <?php echo e($settings['footer_title']); ?> :<br>
                                            <?php echo e($settings['footer_notes']); ?>

                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php if(!isset($preview)): ?>
    <?php echo $__env->make('invoice.script', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>;
    <?php endif; ?>
</body>

</html><?php /**PATH /home/mitaapps/public_html/dekomdmc/main_file/resources/views/invoice/templates/template1.blade.php ENDPATH**/ ?>