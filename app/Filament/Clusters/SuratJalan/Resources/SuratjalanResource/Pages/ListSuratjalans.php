<?php

namespace App\Filament\Clusters\SuratJalan\Resources\SuratjalanResource\Pages;

use App\Filament\Clusters\SuratJalan\Resources\SuratjalanResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListSuratjalans extends ListRecords
{
    protected static string $resource = SuratjalanResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
