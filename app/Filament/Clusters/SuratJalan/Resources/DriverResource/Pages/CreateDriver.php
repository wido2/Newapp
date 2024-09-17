<?php

namespace App\Filament\Clusters\SuratJalan\Resources\DriverResource\Pages;

use App\Filament\Clusters\SuratJalan\Resources\DriverResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateDriver extends CreateRecord
{
    protected static string $resource = DriverResource::class;
    protected function getRedirectUrl(): string
    {
        return $this->previousUrl ?? $this->getResource()::getUrl('index');
    }
}
