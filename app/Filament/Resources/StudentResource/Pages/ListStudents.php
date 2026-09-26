<?php

namespace App\Filament\Resources\StudentResource\Pages;

use App\Filament\Resources\StudentResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use Filament\Resources\Pages\ListRecords\Tab;
use Illuminate\Database\Eloquent\Builder;

use App\Models\Student;
use App\Models\StudentAccount;
use App\Models\FeeStructure;

class ListStudents extends ListRecords
{
    protected static string $resource = StudentResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }

    protected function handleRecordCreation(array $data): Student
    {
        //normal insert
       $record =  static::getModel()::create($data);

       //check if there is an existing fee structure for the stream, and bill the student
       $feeStructure=FeeStructure::where('stream_id',$record->stream_id)
                                        ->latest()
                                        ->value('amount') ?? 0;
        //multiply by -1 because it is a fee debit
        $feeStructure =$feeStructure * -1;

        //transaction to create a student account
        $stdAccount=new StudentAccount();
        $stdAccount->student_id=$record->id;
        $stdAccount->stream_id=$record->stream_id;
        $stdAccount->balance=$feeStructure;
        $stdAccount->debit=$feeStructure;
        $stdAccount->created_by=Auth::user()->id;
        $stdAccount->save();

        return $record;
    }

    public function getTabs(): array
    {
        return [
            'All' => Tab::make()
            ->badge(Student::count()),

            'With Fee Balance' => Tab::make()
            ->modifyQueryUsing(fn (Builder $query): Builder => $query->whereHas('studentAccount', fn (Builder $query) => $query->where('balance', '<', 0)))
            ->badge(Student::query()->whereHas('studentAccount', fn (Builder $query) => $query->where('balance', '<', 0))->count())
            ->badgeColor('warning'),

            'Without Fee Balance' => Tab::make()
            ->modifyQueryUsing(fn (Builder $query): Builder => $query->whereHas('studentAccount', fn (Builder $query) => $query->where('balance', '>', -1)))
            ->badge(Student::query()->whereHas('studentAccount', fn (Builder $query) => $query->where('balance', '>', -1))->count())
            ->badgeColor('success'),

            'Fee Overpaid' => Tab::make()
            ->modifyQueryUsing(fn (Builder $query): Builder => $query->whereHas('studentAccount', fn (Builder $query) => $query->where('balance', '>', 0)))
            ->badge(Student::query()->whereHas('studentAccount', fn (Builder $query) => $query->where('balance', '>', 0))->count())
            ->badgeColor('primary'),

            ];
        
    }
}
