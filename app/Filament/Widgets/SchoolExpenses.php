<?php

namespace App\Filament\Widgets;

use BezhanSalleh\FilamentShield\Traits\HasWidgetShield;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Filament\Widgets\ChartWidget;
use App\Models\SchoolExpense;

class SchoolExpenses extends ChartWidget
{
    use HasWidgetShield;
    protected static ?string $heading =" School Expenses";
    protected static ?int $sort = 4;
    protected static ?string $pollingInterval = '5s';


    protected function getData(): array
    {

        $data = SchoolExpense::select(DB::raw("CAST(strftime('%m', created_at) AS INTEGER) as month"), DB::raw('SUM(amount) as total'))
            ->where('created_at', '>=', now()->subYears(1))
            ->groupBy('month')
            ->get()
            ->mapWithKeys(function ($item) {
                return [$item->month => $item->total];
            })->toArray();


        return [

             'datasets' => [
                [   'label' => 'School Expenses',
                    'data' => array_values($data),
                ]
            ],
            
            'labels' => array_map(function ($monthFigure) {
                return Carbon::createFromFormat('m', $monthFigure)->format('F');
        }, array_keys($data)),


        ];
    }

    protected function getType(): string
    {
        return 'line';
    }

     //chart description
    public function getDescription(): ?string
    {
        return 'The School Expenses for the year ' . now()->year;
    }
}
