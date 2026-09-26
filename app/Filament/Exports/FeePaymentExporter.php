<?php

namespace App\Filament\Exports;

use App\Models\FeePayment;
use Filament\Actions\Exports\ExportColumn;
use Filament\Actions\Exports\Exporter;
use Filament\Actions\Exports\Models\Export;

class FeePaymentExporter extends Exporter
{
    protected static ?string $model = FeePayment::class;

    public static function getColumns(): array
    {
        return [
            ExportColumn::make('student.name') ->label('Student Name'),
            ExportColumn::make('guardian_name') ->label('Guardian Name'),
            ExportColumn::make('student.stream.name') ->label('Class'),
            ExportColumn::make('feestypes.name') ->label('Fees Type'),
            ExportColumn::make('amount') ->label('Amount'),
            ExportColumn::make('paymentmode.name') ->label('Payment Mode'),
            ExportColumn::make('users.name') ->label('Approved By'),
            ExportColumn::make('created_at') ->label('Payment Date'),
        ];
    }

    public static function getCompletedNotificationBody(Export $export): string
    {
        $body = 'Your fee payment table export has completed and ' . number_format($export->successful_rows) . ' ' . str('row')->plural($export->successful_rows) . ' exported.';

        if ($failedRowsCount = $export->getFailedRowsCount()) {
            $body .= ' ' . number_format($failedRowsCount) . ' ' . str('row')->plural($failedRowsCount) . ' failed to export.';
        }

        return $body;
    }
}
