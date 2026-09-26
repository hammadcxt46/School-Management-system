<?php

namespace App\Filament\Widgets;

use BezhanSalleh\FilamentShield\Traits\HasWidgetShield;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use App\Models\SchoolAccount;


class SchoolAccountOverview extends BaseWidget
{
    use HasWidgetShield;
    protected static ?int $sort = 3;

    protected function getStats(): array
    {

        return [
            //Current account balance
            Stat::make('School Account Balance', SchoolAccount::latest() -> first() -> balance)
            -> description('Current Balance')
            -> descriptionIcon('heroicon-o-arrow-right')
            ->icon('heroicon-o-banknotes')
            ->color('success')
            ->chart([
                '7','4','5','3','5','7','4'
            ]),

            //all Expenses Amount
            Stat::make('Total School Expenses', SchoolAccount::latest() -> first() -> expenses)
            -> description('School Expenses')
            -> descriptionIcon('heroicon-o-arrow-right')
            ->icon('heroicon-o-banknotes')
            ->color('warning')
            ->chart([
                '7','4','5','3','5','7','4','5','3','5','7','4'
            ]),

            //all income Amount
            Stat::make('Total School Income', SchoolAccount::latest() -> first() -> income)
            -> description('School Income')
            -> descriptionIcon('heroicon-o-arrow-right')
            ->icon('heroicon-o-banknotes')
            ->color('primary')
            ->chart([
                '7','4','5','3','5','7','4','5','3','5','7','4'
            ]),

        ];
    }
}
