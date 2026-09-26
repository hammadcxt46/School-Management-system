<?php

namespace App\Filament\Exports;

use App\Models\Student;
use Filament\Actions\Exports\ExportColumn;
use Filament\Actions\Exports\Exporter;
use Filament\Actions\Exports\Models\Export;

class StudentExporter extends Exporter
{
    protected static ?string $model = Student::class;

    public static function getColumns(): array
    {
        return [
            ExportColumn::make('admission_number') ->label('Admission Number'),
            ExportColumn::make('name') ->label('Student Name'),
            ExportColumn::make('gender') ->label('Gender'),
            ExportColumn::make('stream.name') ->label('Class'),
            ExportColumn::make('guardian_name') ->label('Guardian Name'),
            ExportColumn::make('guardian_phone') ->label('Guardian Phone'),
            ExportColumn::make('studentaccount.balance') ->label('Fee Balance'),
            ExportColumn::make('user.name') ->label('Admitted By'),
            ExportColumn::make('created_at') ->label('Date of Admission'),
        ];
    }

    public static function getCompletedNotificationBody(Export $export): string
    {
        $body = 'Your student record export has completed and ' . number_format($export->successful_rows) . ' ' . str('row')->plural($export->successful_rows) . ' exported.';

        if ($failedRowsCount = $export->getFailedRowsCount()) {
            $body .= ' ' . number_format($failedRowsCount) . ' ' . str('row')->plural($failedRowsCount) . ' failed to export.';
        }

        return $body;
    }
}
