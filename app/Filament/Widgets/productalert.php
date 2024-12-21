<?php

namespace App\Filament\Widgets;

use Filament\Tables;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;
use App\models\product;



class productalert extends BaseWidget
{
    protected static ?int $sort = 3;
    protected static ?string $heading = 'Product Hampir habis';
    public function table(Table $table): Table
    {
        return $table
            ->query(
                product::query()->where('stock', '<=', 10)->orderby('stock', 'asc')
            )
            ->columns([
                Tables\Columns\TextColumn::make('name'),
                Tables\Columns\TextColumn::make('image')
                ->searchable(),
                Tables\columns\badgecolumn::make('stock')
                ->label('stock')
                ->numeric()
                ->color(static function ($state): string {
                    if ($state <5) {
                        return 'danger';
                    }elseif ($state < 10) {
                        return 'warning';
                    }else{
                        return 'success';
                    }
                })
                ->sortable()
            ])
            ->defaultpaginationpageoption(5);
    }

}
