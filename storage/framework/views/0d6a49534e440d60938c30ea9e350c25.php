<!DOCTYPE html>
<html lang="en">
    <head>
        <title><?php echo e($invoice->name); ?></title>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>

        <style type="text/css" media="screen">
            @page {
                margin: 3px;
            }

            html {
                font-family: "DejaVu Sans", sans-serif;
                line-height: 1.1;
                margin: 0;
            }

            body {
                font-family: "DejaVu Sans", sans-serif;
                font-weight: 400;
                line-height: 1.1;
                color: #000;
                text-align: left;
                background-color: #fff;
                font-size: 8px;
                margin: 4px;
            }

            h4, .h4 {
                margin-top: 0;
                margin-bottom: 2px;
                font-size: 11px;
                font-weight: bold;
                line-height: 1.1;
            }

            p {
                margin-top: 0;
                margin-bottom: 3px;
                line-height: 1.1;
            }

            strong {
                font-weight: bold;
            }

            img {
                vertical-align: middle;
                border-style: none;
                width: 36mm;
                height: auto;
                max-width: 100%;
                display: block;
                margin: 0 auto 4px auto;
            }

            table {
                border-collapse: collapse;
                width: 100%;
                margin-bottom: 4px;
            }

            th, td {
                padding: 2px 0;
                vertical-align: top;
            }

            .table-items td, .table-items th {
                padding: 3px 0;
            }

            .table-items th {
                border-bottom: 1px solid #000;
                border-top: 1px solid #000;
            }

            .table-items td {
                border-bottom: 1px dashed #ccc;
            }

            .mt-1 { margin-top: 2px !important; }
            .mt-2 { margin-top: 5px !important; }

            .text-right { text-align: right !important; }
            .text-center { text-align: center !important; }
            .text-uppercase { text-transform: uppercase !important; }

            .border-0 { border: none !important; }
            .cool-gray { color: #4b5563; }
            .total-amount {
                font-size: 9px;
                font-weight: bold;
            }
            .divider {
                border-top: 1px dashed #000;
                margin: 4px 0;
            }
        </style>
    </head>

    <body>
        
        <?php if($invoice->logo): ?>
            <div class="text-center">
                <img src="<?php echo e($invoice->getLogo()); ?>" alt="logo">
            </div>
        <?php endif; ?>

        
        <table>
            <tbody>
                <tr>
                    <td class="border-0" width="55%">
                        <h4 class="text-uppercase">
                            <strong><?php echo e($invoice->name); ?></strong>
                        </h4>
                        <?php if($invoice->status): ?>
                            <span class="text-uppercase cool-gray">
                                <strong>[<?php echo e($invoice->status); ?>]</strong>
                            </span>
                        <?php endif; ?>
                    </td>
                    <td class="border-0 text-right" width="45%">
                        <p><?php echo e(__('invoices::invoice.serial')); ?> <strong><?php echo e($invoice->getSerialNumber()); ?></strong></p>
                        <p><?php echo e(__('invoices::invoice.date')); ?>: <strong><?php echo e($invoice->getDate()); ?></strong></p>
                    </td>
                </tr>
            </tbody>
        </table>

        <div class="divider"></div>

        
        <table>
            <tbody>
                <tr>
                    <td class="border-0" width="48%">
                        <strong><?php echo e(__('invoices::invoice.seller')); ?>:</strong><br>
                        <?php if($invoice->seller->name): ?>
                            <strong><?php echo e($invoice->seller->name); ?></strong><br>
                        <?php endif; ?>
                        <?php if($invoice->seller->phone): ?>
                            <?php echo e(__('invoices::invoice.phone')); ?>: <?php echo e($invoice->seller->phone); ?><br>
                        <?php endif; ?>
                        <?php $__currentLoopData = $invoice->seller->custom_fields; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <?php echo e(ucfirst($key)); ?>: <?php echo e($value); ?><br>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </td>
                    <td class="border-0" width="4%"></td>
                    <td class="border-0" width="48%">
                        <strong><?php echo e(__('invoices::invoice.buyer')); ?>:</strong><br>
                        <?php if($invoice->buyer->name): ?>
                            <strong><?php echo e($invoice->buyer->name); ?></strong><br>
                        <?php endif; ?>
                        <?php $__currentLoopData = $invoice->buyer->custom_fields; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <?php echo e(ucfirst($key)); ?>: <?php echo e($value); ?><br>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </td>
                </tr>
            </tbody>
        </table>

        
        <table class="table-items mt-1">
            <thead>
                <tr>
                    <th class="text-left" width="60%"><?php echo e(__('invoices::invoice.description')); ?></th>
                    <th class="text-right" width="40%"><?php echo e(__('invoices::invoice.sub_total')); ?></th>
                </tr>
            </thead>
            <tbody>
                <?php $__currentLoopData = $invoice->items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <tr>
                    <td>
                        <strong><?php echo e($item->title); ?></strong>
                        <?php if($item->description): ?>
                            <br><span class="cool-gray"><?php echo e($item->description); ?></span>
                        <?php endif; ?>
                    </td>
                    <td class="text-right">
                        <?php echo e($invoice->formatCurrency($item->sub_total_price)); ?>

                    </td>
                </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </tbody>
        </table>

        
        <table>
            <tbody>
                <tr>
                    <td class="text-right" width="60%"><strong><?php echo e(__('invoices::invoice.total_amount')); ?>:</strong></td>
                    <td class="text-right total-amount" width="40%">
                        <?php echo e($invoice->formatCurrency($invoice->total_amount)); ?>

                    </td>
                </tr>
            </tbody>
        </table>

        
        <?php if($invoice->notes): ?>
            <div class="mt-1">
                <strong><?php echo e(__('invoices::invoice.notes')); ?>:</strong> <?php echo $invoice->notes; ?>

            </div>
        <?php endif; ?>

        <p class="mt-1">
            <?php echo e(__('invoices::invoice.amount_in_words')); ?>: <i><?php echo e($invoice->getTotalAmountInWords()); ?></i>
        </p>
    </body>
</html><?php /**PATH C:\Users\Hammad-Khan\OneDrive\Documents\School Management Software\resources\views/vendor/invoices/templates/default.blade.php ENDPATH**/ ?>