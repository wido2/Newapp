<?php

namespace App\Filament\Clusters\SuratJalan\Resources\DriverResource\Pages;

use App\Filament\Clusters\SuratJalan\Resources\DriverResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListDrivers extends ListRecords
{
    protected static string $resource = DriverResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
