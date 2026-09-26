<?php

namespace App\Filament\Resources\FeeStructureResource\Pages;

use Illuminate\Support\Facades\Auth;
use App\Filament\Resources\FeeStructureResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;
use App\Models\Student;
use App\Models\StudentAccount;
use App\Models\FeeStructure;

class CreateFeeStructure extends CreateRecord
{
    protected static string $resource = FeeStructureResource::class;

    protected function handleRecordCreation(array $data): FeeStructure
    {
        //normal insert
       $record =  static::getModel()::create($data);

       //update current fee structure to student account
            //1.collect data
       $debit = -1*($record->amount); //I multiply with -1 because I am debiting
       $stream = $record->stream_id;

        //2. Select all student accounts belonging to the current stream
       $stdAccounts = StudentAccount::where('stream_id','=', $record->stream_id) ->get();
        
        //3. loop through and update the student account balance with the debit
       foreach($stdAccounts as $stdAccount){
        $stdAccount->balance = $stdAccount->balance + $debit;
        $stdAccount->debit = $stdAccount->debit + $debit;
        $stdAccount->save();
       }

       //return the record
       return $record;

    }

    public function getTitle(): string
    {
     return 'Create New Fee Structure';   
    }
}
