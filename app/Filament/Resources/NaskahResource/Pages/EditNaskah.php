<?php

namespace App\Filament\Resources\NaskahResource\Pages;

use App\Models\naskah;
use Filament\Pages\Actions;
use Illuminate\Support\Facades\Storage;
use Filament\Resources\Pages\EditRecord;
use App\Filament\Resources\NaskahResource;

class EditNaskah extends EditRecord
{
    protected static string $resource = NaskahResource::class;

    protected function getActions(): array
    {
        return [
            Actions\DeleteAction::make()->after(
                function(naskah $record){
                    if($record->thumbnail){
                        Storage::disk('public')->delete($record->thumbnail);
                    }
                }
            ),
        ];
    }
}
