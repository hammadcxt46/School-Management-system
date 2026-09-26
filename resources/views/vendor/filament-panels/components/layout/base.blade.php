@props([
    'livewire' => null,
])

<!DOCTYPE html>
<html
    lang="{{ str_replace('_', '-', app()->getLocale()) }}"
    dir="{{ __('filament-panels::layout.direction') ?? 'ltr' }}"
    @class([
        'fi min-h-screen',
        'dark' => filament()->hasDarkModeForced(),
    ])
>
    <head>
        {{ \Filament\Support\Facades\FilamentView::renderHook(\Filament\View\PanelsRenderHook::HEAD_START, scopes: $livewire->getRenderHookScopes()) }}

        <meta charset="utf-8" />
        <meta name="csrf-token" content="{{ csrf_token() }}" />
        <meta name="viewport" content="width=device-width, initial-scale=1" />

        @if ($favicon = filament()->getFavicon())
            <link rel="icon" href="{{ $favicon }}" />
        @endif

        <title>
            {{ filled($title = strip_tags(($livewire ?? null)?->getTitle() ?? '')) ? "{$title} - " : null }}
            {{ strip_tags(filament()->getBrandName()) }}
        </title>

        <!-- QZ Tray JavaScript Library for Silent Printing -->
        <script src="https://cdn.jsdelivr.net/npm/qz-tray@2.2.6/qz-tray.min.js"></script>

        {{ \Filament\Support\Facades\FilamentView::renderHook(\Filament\View\PanelsRenderHook::STYLES_BEFORE, scopes: $livewire->getRenderHookScopes()) }}

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

        @filamentStyles

        {{ filament()->getTheme()->getHtml() }}
        {{ filament()->getFontHtml() }}

        <style>
            :root {
                --font-family: '{!! filament()->getFontFamily() !!}';
                --sidebar-width: {{ filament()->getSidebarWidth() }};
                --collapsed-sidebar-width: {{ filament()->getCollapsedSidebarWidth() }};
                --default-theme-mode: {{ filament()->getDefaultThemeMode()->value }};
            }
        </style>

        @stack('styles')

        {{ \Filament\Support\Facades\FilamentView::renderHook(\Filament\View\PanelsRenderHook::STYLES_AFTER, scopes: $livewire->getRenderHookScopes()) }}

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

        @if (! filament()->hasDarkMode())
            <script>
                localStorage.setItem('theme', 'light')
            </script>
        @elseif (filament()->hasDarkModeForced())
            <script>
                localStorage.setItem('theme', 'dark')
            </script>
        @else
            <script>
                const theme = localStorage.getItem('theme') ?? @js(filament()->getDefaultThemeMode()->value)

                if (
                    theme === 'dark' ||
                    (theme === 'system' &&
                        window.matchMedia('(prefers-color-scheme: dark)')
                            .matches)
                ) {
                    document.documentElement.classList.add('dark')
                }
            </script>
        @endif

        {{ \Filament\Support\Facades\FilamentView::renderHook(\Filament\View\PanelsRenderHook::HEAD_END, scopes: $livewire->getRenderHookScopes()) }}
    </head>

    <body
        {{ $attributes
                ->merge(($livewire ?? null)?->getExtraBodyAttributes() ?? [], escape: false)
                ->class([
                    'fi-body',
                    'fi-panel-' . filament()->getId(),
                    'min-h-screen bg-gray-50 font-normal text-gray-950 antialiased dark:bg-gray-950 dark:text-white',
                ]) }}
    >
        {{ \Filament\Support\Facades\FilamentView::renderHook(\Filament\View\PanelsRenderHook::BODY_START, scopes: $livewire->getRenderHookScopes()) }}

        {{ $slot }}

        @livewire(Filament\Livewire\Notifications::class)

        {{ \Filament\Support\Facades\FilamentView::renderHook(\Filament\View\PanelsRenderHook::SCRIPTS_BEFORE, scopes: $livewire->getRenderHookScopes()) }}

        @filamentScripts(withCore: true)

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

        @stack('scripts')

        {{ \Filament\Support\Facades\FilamentView::renderHook(\Filament\View\PanelsRenderHook::SCRIPTS_AFTER, scopes: $livewire->getRenderHookScopes()) }}

        {{ \Filament\Support\Facades\FilamentView::renderHook(\Filament\View\PanelsRenderHook::BODY_END, scopes: $livewire->getRenderHookScopes()) }}
    </body>
</html>
