<?php

namespace App\Filament\Resources\SuratJalanResource\Pages;

use App\Filament\Resources\SuratJalanResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewSuratJalan extends ViewRecord
{
    protected static string $resource = SuratJalanResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
        ];
    }
}
