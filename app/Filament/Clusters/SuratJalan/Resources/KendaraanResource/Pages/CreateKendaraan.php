<?php

namespace App\Filament\Clusters\SuratJalan\Resources\KendaraanResource\Pages;

use App\Filament\Clusters\SuratJalan\Resources\KendaraanResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateKendaraan extends CreateRecord
{
    protected static string $resource = KendaraanResource::class;
    protected function getRedirectUrl(): string
    {
        return $this->previousUrl ?? $this->getResource()::getUrl('index');
    }
}
