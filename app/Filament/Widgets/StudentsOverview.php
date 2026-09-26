<?php

namespace App\Filament\Widgets;

use BezhanSalleh\FilamentShield\Traits\HasWidgetShield;
use Carbon\Carbon;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use App\Models\Student;

use App\Filament\Resources\StudentResource;

class StudentsOverview extends BaseWidget
{
    use HasWidgetShield;
    protected static ?int $sort = 1;

    protected function getStats(): array
    {
        return [

            //Students Widgets
            Stat::make('Total Students', Student::count())
            -> description('All Admitted Students')
            -> descriptionIcon('heroicon-o-arrow-trending-up')
            ->icon('heroicon-o-users')
            ->url(StudentResource::getUrl('index'))
            ->color('success')
            ->chart([
                '4','5','3','7','9','6','8'
            ]),

                Stat::make('Recently Admitted', 
                    Student::whereRaw("CAST(strftime('%m', created_at) AS INTEGER) = ?", [Carbon::now()->month])
                   ->get()
                   ->count())
            -> description('Admitted This Month')
            -> descriptionIcon('heroicon-o-arrow-right')
            ->url(StudentResource::getUrl('index'))
            ->icon('heroicon-o-clock')
            ->color('success'),

                 Stat::make('Class Admissions', Student::whereRaw("CAST(strftime('%m', created_at) AS INTEGER) = ?", [Carbon::now()->month])
                     ->distinct('stream_id')
                     ->count())
            -> description('Classes that Admitted This Month')
            -> descriptionIcon('heroicon-o-arrow-right')
            ->icon('heroicon-o-building-library')
            ->url(StudentResource::getUrl('index'))
            ->color('primary'),

        ];
    }
}
