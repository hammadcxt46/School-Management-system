<?php

namespace App\Filament\Widgets;

use BezhanSalleh\FilamentShield\Traits\HasWidgetShield;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Filament\Widgets\ChartWidget;
use App\Models\FeePayment;

class FeesPaymentChart extends ChartWidget
{
    use HasWidgetShield;
    protected static ?string $heading = 'Fee Collection For The Year';
    protected static ?int $sort = 4;
    protected static ?string $pollingInterval = '5s';
    //protected string | int | array $columnSpan = 'full';

    protected function getData(): array
    {
       
        $data = FeePayment::select(DB::raw("CAST(strftime('%m', created_at) AS INTEGER) as month"), DB::raw('SUM(amount) as total'))
            ->where('created_at', '>=', now()->subYears(1))
            ->groupBy('month')
            ->get()
            ->mapWithKeys(function ($item) {
                return [$item->month => $item->total];
            })->toArray();



        return [
            
            'datasets' => [
                [   'label' => 'Fee Payments',
                    'data' => array_values($data),
                ]
            ],
            
            'labels' => array_map(function ($monthFigure) {
                return Carbon::createFromFormat('m', $monthFigure)->format('F');
        }, array_keys($data)),



        ];
    }

    //fetch fee payments per month
    private function getFeePaymentsPerMonth(){
        $now = Carbon::now();
        
        $feePaymentsPerMonth=[];

                $months = collect(range(1, 12))->map(function($month) use ($now) {
                        return FeePayment::whereRaw("CAST(strftime('%m', created_at) AS INTEGER) = ?", [$month])->sum('amount');
                });

    }

    //type of chart
    protected function getType(): string
    {
        return 'bar';
    }

    //chart description
    public function getDescription(): ?string
    {
        return 'The fee collected per month.';
    }
}
