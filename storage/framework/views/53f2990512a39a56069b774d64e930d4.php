<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag;

$__newAttributes = [];
$__propNames = \Illuminate\View\ComponentAttributeBag::extractPropNames(([
    'livewire' => null,
]));

foreach ($attributes->all() as $__key => $__value) {
    if (in_array($__key, $__propNames)) {
        $$__key = $$__key ?? $__value;
    } else {
        $__newAttributes[$__key] = $__value;
    }
}

$attributes = new \Illuminate\View\ComponentAttributeBag($__newAttributes);

unset($__propNames);
unset($__newAttributes);

foreach (array_filter(([
    'livewire' => null,
]), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
}

$__defined_vars = get_defined_vars();

foreach ($attributes->all() as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
}

unset($__defined_vars); ?>

<!DOCTYPE html>
<html
    lang="<?php echo e(str_replace('_', '-', app()->getLocale())); ?>"
    dir="<?php echo e(__('filament-panels::layout.direction') ?? 'ltr'); ?>"
    class="<?php echo \Illuminate\Support\Arr::toCssClasses([
        'fi min-h-screen',
        'dark' => filament()->hasDarkModeForced(),
    ]); ?>"
>
    <head>
        <?php echo e(\Filament\Support\Facades\FilamentView::renderHook(\Filament\View\PanelsRenderHook::HEAD_START, scopes: $livewire->getRenderHookScopes())); ?>


        <meta charset="utf-8" />
        <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>" />
        <meta name="viewport" content="width=device-width, initial-scale=1" />

        <?php if($favicon = filament()->getFavicon()): ?>
            <link rel="icon" href="<?php echo e($favicon); ?>" />
        <?php endif; ?>

        <title>
            <?php echo e(filled($title = strip_tags(($livewire ?? null)?->getTitle() ?? '')) ? "{$title} - " : null); ?>

            <?php echo e(strip_tags(filament()->getBrandName())); ?>

        </title>

        <!-- QZ Tray JavaScript Library for Silent Printing -->
        <script src="https://cdn.jsdelivr.net/npm/qz-tray@2.2.6/qz-tray.min.js"></script>

        <?php echo e(\Filament\Support\Facades\FilamentView::renderHook(\Filament\View\PanelsRenderHook::STYLES_BEFORE, scopes: $livewire->getRenderHookScopes())); ?>


        <style>
            [x-cloak=''],
            [x-cloak='x-cloak'],
            [x-cloak='1'] {
                display: none !important;
            }

            @media (max-width: 1023px) {
                [x-cloak='-lg'] {
                    display: none !important;
                }
            }

            @media (min-width: 1024px) {
                [x-cloak='lg'] {
                    display: none !important;
                }
            }
        </style>

        <?php echo \Filament\Support\Facades\FilamentAsset::renderStyles() ?>

        <?php echo e(filament()->getTheme()->getHtml()); ?>

        <?php echo e(filament()->getFontHtml()); ?>


        <style>
            :root {
                --font-family: '<?php echo filament()->getFontFamily(); ?>';
                --sidebar-width: <?php echo e(filament()->getSidebarWidth()); ?>;
                --collapsed-sidebar-width: <?php echo e(filament()->getCollapsedSidebarWidth()); ?>;
                --default-theme-mode: <?php echo e(filament()->getDefaultThemeMode()->value); ?>;
            }
        </style>

        <?php echo $__env->yieldPushContent('styles'); ?>

        <?php echo e(\Filament\Support\Facades\FilamentView::renderHook(\Filament\View\PanelsRenderHook::STYLES_AFTER, scopes: $livewire->getRenderHookScopes())); ?>


        <script>
            document.addEventListener('DOMContentLoaded', () => {
                setTimeout(() => {
                    const activeSidebarItem = document.querySelector(
                        '.fi-sidebar-item-active',
                    )

                    if (!activeSidebarItem) {
                        return
                    }

                    const sidebarWrapper =
                        document.querySelector('.fi-sidebar-nav')

                    if (!sidebarWrapper) {
                        return
                    }

                    sidebarWrapper.scrollTo(
                        0,
                        activeSidebarItem.offsetTop - window.innerHeight / 2,
                    )
                }, 0)
            })
        </script>

        <?php if(! filament()->hasDarkMode()): ?>
            <script>
                localStorage.setItem('theme', 'light')
            </script>
        <?php elseif(filament()->hasDarkModeForced()): ?>
            <script>
                localStorage.setItem('theme', 'dark')
            </script>
        <?php else: ?>
            <script>
                const theme = localStorage.getItem('theme') ?? <?php echo \Illuminate\Support\Js::from(filament()->getDefaultThemeMode()->value)->toHtml() ?>

                if (
                    theme === 'dark' ||
                    (theme === 'system' &&
                        window.matchMedia('(prefers-color-scheme: dark)')
                            .matches)
                ) {
                    document.documentElement.classList.add('dark')
                }
            </script>
        <?php endif; ?>

        <?php echo e(\Filament\Support\Facades\FilamentView::renderHook(\Filament\View\PanelsRenderHook::HEAD_END, scopes: $livewire->getRenderHookScopes())); ?>

    </head>

    <body
        <?php echo e($attributes
                ->merge(($livewire ?? null)?->getExtraBodyAttributes() ?? [], escape: false)
                ->class([
                    'fi-body',
                    'fi-panel-' . filament()->getId(),
                    'min-h-screen bg-gray-50 font-normal text-gray-950 antialiased dark:bg-gray-950 dark:text-white',
                ])); ?>

    >
        <?php echo e(\Filament\Support\Facades\FilamentView::renderHook(\Filament\View\PanelsRenderHook::BODY_START, scopes: $livewire->getRenderHookScopes())); ?>


        <?php echo e($slot); ?>


        <?php
$__split = function ($name, $params = []) {
    return [$name, $params];
};
[$__name, $__params] = $__split(Filament\Livewire\Notifications::class);

$__html = app('livewire')->mount($__name, $__params, 'lw-2433849146-0', $__slots ?? [], get_defined_vars());

echo $__html;

unset($__html);
unset($__name);
unset($__params);
unset($__split);
if (isset($__slots)) unset($__slots);
?>

        <?php echo e(\Filament\Support\Facades\FilamentView::renderHook(\Filament\View\PanelsRenderHook::SCRIPTS_BEFORE, scopes: $livewire->getRenderHookScopes())); ?>


        <?php echo \Filament\Support\Facades\FilamentAsset::renderScripts(withCore: true) ?>

<script>
    window.__filamentOpenNewTab = null;

    document.addEventListener('click', function (event) {
        const button = event.target.closest('[data-create-and-open-receipt]');

        if (! button) {
            return;
        }

        // Silent Print ke liye blank tab popup open karne ki zaroorat nahi hai.
    });

    document.addEventListener('open-in-new-tab', function (event) {
        const payload = Array.isArray(event?.detail) ? event.detail[0] : event?.detail;
        const url = payload?.url ?? payload;

        if (! url) {
            return;
        }

        // Direct Silent Print via QZ Tray Trigger
        printReceiptViaQZTray(url);
    });

    function printReceiptViaQZTray(pdfUrl) {
        // Check if QZ WebSocket is connected
        if (typeof qz !== 'undefined' && !qz.websocket.isActive()) {
            qz.websocket.connect().then(function() {
                sendToPrinter(pdfUrl);
            }).catch(function(err) {
                console.error("QZ Connection Error: ", err);
                // Fallback: Agar QZ Tray active na ho toh normal new tab mein browser popup khol dein
                window.open(pdfUrl, '_blank');
            });
        } else if (typeof qz !== 'undefined' && qz.websocket.isActive()) {
            sendToPrinter(pdfUrl);
        } else {
            // Fallback agar JS library load na hui ho
            window.open(pdfUrl, '_blank');
        }
    }

    function sendToPrinter(pdfUrl) {
        var printerName = "MP-POS80"; 
        var config = qz.configs.create(printerName); 

        var printData = [{
            type: 'pixel',
            format: 'pdf',
            flavor: 'file',
            data: pdfUrl
        }];

        qz.print(config, printData).then(function() {
            console.log("Receipt Printed Silently!");
        }).catch(function(err) {
            console.error("Printing Failed: ", err);
            // Fallback to tab open if silent print fails
            window.open(pdfUrl, '_blank');
        });
    }

    // ==========================================
    // QZ TRAY SECURITY & CERTIFICATE CONFIG
    // ==========================================
    if (typeof qz !== 'undefined') {
        // Updated Demo Certificate Pass Kar Diya Gaya Hai
        qz.security.setCertificatePromise(function(resolve, reject) {
            resolve("-----BEGIN CERTIFICATE-----\n" +
                    "MIIECzCCAvOgAwIBAgIGAaBJ7a1EMA0GCSqGSIb3DQEBCwUAMIGiMQswCQYDVQQG\n" +
                    "EwJVUzELMAkGA1UECAwCTlkxEjAQBgNVBAcMCUNhbmFzdG90YTEbMBkGA1UECgwS\n" +
                    "UVogSW5kdXN0cmllcywgTExDMRswGQYDVQQLDBJRWiBJbmR1c3RyaWVzLCBMTEMx\n" +
                    "HDAaBgkqhkiG9w0BCQEWDXN1cHBvcnRAcXouaW8xGjAYBgNVBAMMEVFaIFRyYXkg\n" +
                    "RGVtbyBDZXJ0MB4XDTI2MDgyNzE5NTE0OFoXDTQ2MDgyNzE5NTE0OFowgaIxCzAJ\n" +
                    "BgNVBAYTAlVTMQswCQYDVQQIDAJOWTESMBAGA1UEBwwJQ2FuYXN0b3RhMRswGQYD\n" +
                    "VQQKDBJRWiBJbmR1c3RyaWVzLCBMTEMxGzAZBgNVBAsMElFaIEluZHVzdHJpZXMs\n" +
                    "IExMQzEcMBoGCSqGSIb3DQEJARYNc3VwcG9ydEBxei5pbzEaMBgGA1UEAwwRUVog\n" +
                    "VHJheSBEZW1vIENlcnQwggEiMA0GCSqGSIb3DQEBAQUAA4IBDwAwggEKAoIBAQC7\n" +
                    "7NaEYNgGST87QheySFAoMHr9aJYBCElLsFuyLOAeVMXq+xbfh9CL4SrQtdDAIV99\n" +
                    "jTdkCzXWI2t2MVDKhrfxR9MmXkXldWOZqJjr7o8D190dyGbIthpCh+HLnVwsCugG\n" +
                    "2bV8JdzOzEGO+3cU1Zxy1osrsMl6wycxOLKM8xB471XVtZZvfhShsmUEeZykG0a+\n" +
                    "XYKrK93bdwzImzplBXPdwL0b6lVgXjDh5wV8FL0pqZAuWdFG7RL+RuHFrpzXEWDW\n" +
                    "5Ql9uNHjogp4j/pCFGVtAOheulHiAVTjf5JeNJJ8zh9IHhWKI5/d31altwIb3ki+\n" +
                    "z9Y8sZ00vMUipCYOH93rAgMBAAGjRTBDMBIGA1UdEwEB/wQIMAYBAf8CAQEwDgYD\n" +
                    "VR0PAQH/BAQDAgEGMB0GA1UdDgQWBBTGJsBsesSbExelm7qaCF8YjimQEjANBgkq\n" +
                    "hkiG9w0BAQsFAAOCAQEAkN+Mw5JSfoVSGxxSpONfl2df3LolVyXBBcmhvHKPU8sJ\n" +
                    "tAzpKFMg9cG1NknUcbWHOR3JYrgA/kIeBG6CWtIQyAavnoLvZ/WkckbzgDzVVONA\n" +
                    "CTiqF23AN5uZ8eHCzy6VtVwdH3ixCKj4LwHC+1cybsHOMm0OEGUnZWYFaclqdQTW\n" +
                    "T6M+ou9tCOUDkHbZ/Yx2lS/i8BkpQwSEJmp/shdtI8TGm2hJ7a5ZR8MLU0/sioZg\n" +
                    "eM69kOSbLT0dwn0HxNrYPF0nkRcBh+8SYQEg4QxkBH1mKn9eqVG64etGRLymZ6GN\n" +
                    "nAbxVzf0nBn0r7sXYInOo2wniYjpCmNRzpGv+p6VjQ==\n" +
                    "-----END CERTIFICATE-----");
        });

        // Laravel Route Se Signature Verify Karwane Ka Logic
        qz.security.setSignatureAlgorithm("SHA512");
        qz.security.setSignaturePromise(function(toSign) {
            return function(resolve, reject) {
                fetch('/qz/sign-message?request=' + encodeURIComponent(toSign))
                    .then(function(response) { return response.text(); })
                    .then(resolve)
                    .catch(reject);
            };
        });
    }
</script>

        <?php echo $__env->yieldPushContent('scripts'); ?>

        <?php echo e(\Filament\Support\Facades\FilamentView::renderHook(\Filament\View\PanelsRenderHook::SCRIPTS_AFTER, scopes: $livewire->getRenderHookScopes())); ?>


        <?php echo e(\Filament\Support\Facades\FilamentView::renderHook(\Filament\View\PanelsRenderHook::BODY_END, scopes: $livewire->getRenderHookScopes())); ?>

    </body>
</html>
<?php /**PATH C:\Users\Hammad-Khan\OneDrive\Documents\School Management Software\resources\views\vendor\filament-panels\components\layout\base.blade.php ENDPATH**/ ?>