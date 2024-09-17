<?php

namespace App\Filament\Clusters\SuratJalan\Resources\DriverResource\Pages;

use App\Filament\Clusters\SuratJalan\Resources\DriverResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditDriver extends EditRecord
{
    protected static string $resource = DriverResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
