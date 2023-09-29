<?php

namespace App\Filament\Resources\NaskahResource\Pages;

use App\Filament\Resources\NaskahResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\ListRecords;

class ListNaskahs extends ListRecords
{
    protected static string $resource = NaskahResource::class;

    protected function getActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
