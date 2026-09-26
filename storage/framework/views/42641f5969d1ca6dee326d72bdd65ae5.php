<?php
    use Filament\Support\Facades\FilamentView;
?>

<?php if($this->hasUnsavedDataChangesAlert() && (! FilamentView::hasSpaMode())): ?>
        <?php
        $__scriptKey = '3841886800-0';
        ob_start();
    ?>
        <script>
            window.addEventListener('beforeunload', (event) => {
                if (
                    window.jsMd5(
                        JSON.stringify($wire.data).replace(/\\/g, ''),
                    ) === $wire.savedDataHash ||
                    $wire?.__instance?.effects?.redirect
                ) {
                    return
                }

                event.preventDefault()
                event.returnValue = true
            })
        </script>
        <?php
        $__output = ob_get_clean();

        \Livewire\store($this)->push('scripts', $__output, $__scriptKey)
    ?>
<?php endif; ?>
<?php /**PATH C:\Users\Hammad-Khan\OneDrive\Documents\School Management Software\vendor\filament\filament\resources\views\components\page\unsaved-data-changes-alert.blade.php ENDPATH**/ ?>