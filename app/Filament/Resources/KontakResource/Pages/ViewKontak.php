<?php

namespace App\Filament\Resources\KontakResource\Pages;

use App\Filament\Resources\KontakResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewKontak extends ViewRecord
{
    protected static string $resource = KontakResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
        ];
    }
}
