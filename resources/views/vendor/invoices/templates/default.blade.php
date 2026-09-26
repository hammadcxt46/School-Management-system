<!DOCTYPE html>
<html lang="en">
    <head>
        <title>{{ $invoice->name }}</title>
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
        {{-- Header Logo --}}
        @if($invoice->logo)
            <div class="text-center">
                <img src="{{ $invoice->getLogo() }}" alt="logo">
            </div>
        @endif

        {{-- Invoice Title & Info --}}
        <table>
            <tbody>
                <tr>
                    <td class="border-0" width="55%">
                        <h4 class="text-uppercase">
                            <strong>{{ $invoice->name }}</strong>
                        </h4>
                        @if($invoice->status)
                            <span class="text-uppercase cool-gray">
                                <strong>[{{ $invoice->status }}]</strong>
                            </span>
                        @endif
                    </td>
                    <td class="border-0 text-right" width="45%">
                        <p>{{ __('invoices::invoice.serial') }} <strong>{{ $invoice->getSerialNumber() }}</strong></p>
                        <p>{{ __('invoices::invoice.date') }}: <strong>{{ $invoice->getDate() }}</strong></p>
                    </td>
                </tr>
            </tbody>
        </table>

        <div class="divider"></div>

        {{-- Seller & Buyer Info --}}
        <table>
            <tbody>
                <tr>
                    <td class="border-0" width="48%">
                        <strong>{{ __('invoices::invoice.seller') }}:</strong><br>
                        @if($invoice->seller->name)
                            <strong>{{ $invoice->seller->name }}</strong><br>
                        @endif
                        @if($invoice->seller->phone)
                            {{ __('invoices::invoice.phone') }}: {{ $invoice->seller->phone }}<br>
                        @endif
                        @foreach($invoice->seller->custom_fields as $key => $value)
                            {{ ucfirst($key) }}: {{ $value }}<br>
                        @endforeach
                    </td>
                    <td class="border-0" width="4%"></td>
                    <td class="border-0" width="48%">
                        <strong>{{ __('invoices::invoice.buyer') }}:</strong><br>
                        @if($invoice->buyer->name)
                            <strong>{{ $invoice->buyer->name }}</strong><br>
                        @endif
                        @foreach($invoice->buyer->custom_fields as $key => $value)
                            {{ ucfirst($key) }}: {{ $value }}<br>
                        @endforeach
                    </td>
                </tr>
            </tbody>
        </table>

        {{-- Items Table --}}
        <table class="table-items mt-1">
            <thead>
                <tr>
                    <th class="text-left" width="60%">{{ __('invoices::invoice.description') }}</th>
                    <th class="text-right" width="40%">{{ __('invoices::invoice.sub_total') }}</th>
                </tr>
            </thead>
            <tbody>
                @foreach($invoice->items as $item)
                <tr>
                    <td>
                        <strong>{{ $item->title }}</strong>
                        @if($item->description)
                            <br><span class="cool-gray">{{ $item->description }}</span>
                        @endif
                    </td>
                    <td class="text-right">
                        {{ $invoice->formatCurrency($item->sub_total_price) }}
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>

        {{-- Totals --}}
        <table>
            <tbody>
                <tr>
                    <td class="text-right" width="60%"><strong>{{ __('invoices::invoice.total_amount') }}:</strong></td>
                    <td class="text-right total-amount" width="40%">
                        {{ $invoice->formatCurrency($invoice->total_amount) }}
                    </td>
                </tr>
            </tbody>
        </table>

        {{-- Notes & Words --}}
        @if($invoice->notes)
            <div class="mt-1">
                <strong>{{ __('invoices::invoice.notes') }}:</strong> {!! $invoice->notes !!}
            </div>
        @endif

        <p class="mt-1">
            {{ __('invoices::invoice.amount_in_words') }}: <i>{{ $invoice->getTotalAmountInWords() }}</i>
        </p>
    </body>
</html>