<div
    <?php echo e($attributes
            ->merge([
                'id' => $getId(),
            ], escape: false)
            ->merge($getExtraAttributes(), escape: false)); ?>

>
    <?php echo e($getChildComponentContainer()); ?>

</div>
<?php /**PATH C:\Users\Hammad-Khan\OneDrive\Documents\School Management Software\vendor\filament\infolists\resources\views\components\grid.blade.php ENDPATH**/ ?>