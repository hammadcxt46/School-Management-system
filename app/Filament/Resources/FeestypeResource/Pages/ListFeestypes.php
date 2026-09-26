<?php

namespace App\Filament\Resources\FeestypeResource\Pages;

use App\Filament\Resources\FeestypeResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListFeestypes extends ListRecords
{
    protected static string $resource = FeestypeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
