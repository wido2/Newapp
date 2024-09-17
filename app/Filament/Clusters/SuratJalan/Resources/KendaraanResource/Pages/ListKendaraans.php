<?php

namespace App\Filament\Clusters\SuratJalan\Resources\KendaraanResource\Pages;

use App\Filament\Clusters\SuratJalan\Resources\KendaraanResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListKendaraans extends ListRecords
{
    protected static string $resource = KendaraanResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
