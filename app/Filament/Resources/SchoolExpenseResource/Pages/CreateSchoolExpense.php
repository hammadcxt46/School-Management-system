<?php

namespace App\Filament\Resources\SchoolExpenseResource\Pages;

use App\Filament\Resources\SchoolExpenseResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;
use App\Models\SchoolAccount;
use App\Models\SchoolExpense;

class CreateSchoolExpense extends CreateRecord
{
    protected static string $resource = SchoolExpenseResource::class;

    protected function handleRecordCreation(array $data): SchoolExpense
    {
         //normal insert
       $record =  static::getModel()::create($data);

       $expense=$record->amount;

        //Fetch school account for Expense update
       $schoolAccount=SchoolAccount::latest()->first();
       $schoolAccount->balance=$schoolAccount->balance-$expense; //update balance
       $schoolAccount->expenses=$schoolAccount->expenses+$expense; //update expenses
       $schoolAccount->save();


       return $record;

   }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

     protected function getCreatedNotificationTitle(): ?string
    {
        return 'Expense recorded Successfuly with an update to the school account';
    }

    public function getTitle(): string
    {
        return 'Add New School Expense';
    }


}
