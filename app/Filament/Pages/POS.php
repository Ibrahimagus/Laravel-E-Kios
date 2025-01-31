<?php

namespace App\Filament\Pages;

use Filament\Pages\Page;

class POS extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    protected static string $view = 'filament.pages.p-o-s';

    protected static ?int $navigationSort = 105;
}
