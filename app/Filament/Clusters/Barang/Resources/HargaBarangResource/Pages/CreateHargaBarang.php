<?php

namespace App\Filament\Clusters\Barang\Resources\HargaBarangResource\Pages;

use App\Filament\Clusters\Barang\Resources\HargaBarangResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateHargaBarang extends CreateRecord
{
    protected static string $resource = HargaBarangResource::class;
    protected function getRedirectUrl(): string
    {
        return $this->previousUrl ?? $this->getResource()::getUrl('index');
    }
}
