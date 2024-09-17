<?php

namespace App\Filament\Clusters\Barang\Resources\SatuanResource\Pages;

use App\Filament\Clusters\Barang\Resources\SatuanResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateSatuan extends CreateRecord
{
    protected static string $resource = SatuanResource::class;
    protected function getRedirectUrl(): string
    {
        return $this->previousUrl ?? $this->getResource()::getUrl('index');
    }
}
