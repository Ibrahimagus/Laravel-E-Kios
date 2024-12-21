<?php

namespace App\Filament\Widgets;

use Filament\Widgets\ChartWidget;
use Flowframe\Trend\Trend;
use Flowframe\Trend\TrendValue;
use App\Models\expense;
use Carbon\Carbon;

class ExpenseChart extends ChartWidget
{
    protected static ?string $heading = 'expense';
    protected static ?int $sort = 2;
    protected static string $color = 'danger';
    public ?string $filter = 'today';



    protected function getData(): array
    {
        $activeFilter = $this->filter;

        $daterange = match ($activeFilter) {
            'today' => [
                'start' => now()->startOfDay(),
                'end' => now()->endOfDay(),
                'period' => 'perhour'
            ],
            'week' => [
                'start' => now()->startOfWeek(),
                'end' => now()->endOfWeek(),
                'period' => 'perday'
            ],
            'month' => [
                'start' => now()->startOfMonth(),
                'end' => now()->endOfMonth(),
                'period' => 'perday'
            ],
            'year' => [
                'start' => now()->startOfYear(),
                'end' => now()->endOfYear(),
                'period' => 'permonth'
            ],
        };

        $query = Trend::model(Expense::class)
            ->between(
                start: $daterange['start'],
                end: $daterange['end'],
            );

        if ($daterange['period'] === 'perhour') {
            $data = $query->perHour();
        } elseif ($daterange['period'] === 'perday') {
            $data = $query->perDay();
        } else {
            $data = $query->perMonth();
        }

        $data = $data->sum('total_price');

        $labels = $data->map(function (TrendValue $value) use ($daterange) {
            $date = Carbon::parse($value->date);

            if ($daterange['period'] === 'perhour') {
                return $date->format('h:i');
            } elseif ($daterange['period'] === 'perday') {
                return $date->format('d M');
            }
            return $date->format('M Y');
        });

        return [
            'datasets' => [
                [
                    'label' => 'expense ' . $this->getFilters()[$activeFilter],
                    'data' => $data->map(fn (TrendValue $value) => $value->aggregate),
                ],
            ],
            'labels' => $labels,
        ];
    }

    protected function getFilters(): ?array
    {
        return [
            'today' => 'Today',
            'week' => 'Last Week',
            'month' => 'Last Month',
            'year' => 'This Year',
        ];
    }

    protected function getType(): string
    {
        return 'line';
    }
}

