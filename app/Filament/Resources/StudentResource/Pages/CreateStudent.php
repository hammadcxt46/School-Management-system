<?php

namespace App\Filament\Resources\StudentResource\Pages;

use Illuminate\Support\Facades\Auth;
use App\Filament\Resources\StudentResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;
use App\Models\StudentAccount;
use App\Models\Student;
use App\Models\FeeStructure;

class CreateStudent extends CreateRecord
{
    protected static string $resource = StudentResource::class;

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

    protected function getCreatedNotificationTitle(): ?string
    {
        return 'Student Admitted Successfuly';
    }

    //handles the redirection
    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
    
    //the custom title for admitting a student
    public function getTitle(): string
    {
        return 'Admit a Student';
    }


    
}
