<?php

namespace App\Filament\Imports;

use Illuminate\Support\Facades\Auth;
use App\Models\Student;
use App\Models\StudentAccount;
use App\Models\FeeStructure;
use Filament\Actions\Imports\ImportColumn;
use Filament\Actions\Imports\Importer;
use Filament\Actions\Imports\Models\Import;

class StudentImporter extends Importer
{
    protected static ?string $model = Student::class;

    public static function getColumns(): array
    {
        return [
            ImportColumn::make('name')
                ->requiredMapping()
                ->rules(['required', 'max:255']),
            ImportColumn::make('admission_number')
                ->requiredMapping()
                ->rules(['required', 'max:255']),
            ImportColumn::make('guardian_phone')
                ->rules(['max:255']),
            ImportColumn::make('guardian_name')
                ->rules(['max:255']),
            ImportColumn::make('stream_id')
                ->requiredMapping()
                ->numeric()
                ->rules(['required', 'integer']),
            ImportColumn::make('added_by')
                ->requiredMapping()
                ->numeric()
                ->rules(['required', 'integer']),
            ImportColumn::make('gender')
                ->requiredMapping()
                ->rules(['required', 'max:255']),
        ];
    }

    protected function beforeSave(): void
    {
        //
         //check if there is an existing fee structure for the stream, and bill the student
       $feeStructure=FeeStructure::where('stream_id',$this->record->stream_id)
                                        ->latest()
                                        ->value('amount') ?? 0;
        //multiply by -1 because it is a fee debit
        $feeStructure =$feeStructure * -1;

        //transaction to create a student account
        $stdAccount=new StudentAccount();
        $stdAccount->student_id=$this->record->id;
        $stdAccount->stream_id=$this->record->stream_id;
        $stdAccount->balance=$feeStructure;
        $stdAccount->debit=$feeStructure;
        $stdAccount->created_by=Auth::user()->id;
        $stdAccount->save();

        $record ->studentaccount()->save($stdAccount);
        //return $record;
    }

    public function resolveRecord(): ?Student
    {
       // $record =  static::getModel()::create($data);

        // return Student::firstOrNew([
        //     // Update existing records, matching them by `$this->data['column_name']`
        //     'email' => $this->data['email'],
        // ]);

        return new Student();
    }

    public static function getCompletedNotificationBody(Import $import): string
    {
        $body = 'Your student import has completed and ' . number_format($import->successful_rows) . ' ' . str('row')->plural($import->successful_rows) . ' imported.';

        if ($failedRowsCount = $import->getFailedRowsCount()) {
            $body .= ' ' . number_format($failedRowsCount) . ' ' . str('row')->plural($failedRowsCount) . ' failed to import.';
        }

        return $body;
    }
}
