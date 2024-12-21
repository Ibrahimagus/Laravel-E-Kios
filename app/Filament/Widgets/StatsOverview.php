<?php

namespace App\Filament\Widgets;

use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use App\Models\Product;
use App\Models\Order;
use App\Models\Expense;

class StatsOverview extends BaseWidget
{
    protected function getStats(): array
    {
        $product_count = product::count();
        $order_count = order::count();
        $omset = order::sum('total_price');
        $expense = expense::sum('amount');
        return [
            Stat::make('product', $product_count),
            Stat::make('order', $order_count),
            Stat::make('omset',number_format($omset,0,",",".")),
            Stat::make('expense', number_format($expense, 0, ",", ".")),
        ];
    }
}
