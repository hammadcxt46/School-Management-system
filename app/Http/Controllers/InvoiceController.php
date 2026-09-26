<?php

namespace App\Http\Controllers;

use App\Models\FeePayment;
use Illuminate\Http\Request;
use LaravelDaily\Invoices\Invoice;
use LaravelDaily\Invoices\Classes\Party;
use LaravelDaily\Invoices\Classes\InvoiceItem;

class InvoiceController extends Controller
{
    public function invoice($payment)
    {
        // Finding the payment
        $payment = FeePayment::findOrFail($payment);

        $client = new Party([
            'name'          => config('app.name'),
            'phone'         => '03450212304',
            'custom_fields' => [
                'Served By' => $payment->users->name,
            ],
        ]);

        $customer = new Party([
            'name'          => $payment->student->name,
            'custom_fields' => [
                'Class'    => $payment->student->stream->name,
                'Guardian' => $payment->student->guardian_name ?? 'N/A',
            ],
        ]);

        $items = [
            InvoiceItem::make('Fee Payment')
                ->description($payment->feestypes->name)
                ->pricePerUnit($payment->amount)
                ->quantity(1),
        ];

        // Short notes to fit within 4 inches
        $notes = 'System Generated Receipt - ' . config('app.name');

        $invoice = Invoice::make('receipt')
            ->series('SMS')
            ->status(__('invoices::invoice.paid'))
            ->sequence($payment->id)
            ->serialNumberFormat('{SEQUENCE}/{SERIES}')
            ->seller($client)
            ->buyer($customer)
            ->date($payment->created_at)
            ->dateFormat('m/d/Y')
            ->currencySymbol('Rs. ')
            ->currencyCode('PKR')
            ->currencyFormat('{SYMBOL}{VALUE}')
            ->currencyThousandsSeparator(',')
            ->currencyDecimalPoint('.')
            ->filename($client->name . ' ' . $customer->name)
            ->addItems($items)
            ->notes($notes)
            ->logo(public_path('images/logo.png'));

        return $invoice->stream();
    }
}