<?php

namespace App\Filament\Clusters\Barang\Resources\KategoriBarangResource\Pages;

use App\Filament\Clusters\Barang\Resources\KategoriBarangResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateKategoriBarang extends CreateRecord
{
    protected static string $resource = KategoriBarangResource::class;
    protected function getRedirectUrl(): string
    {
        return $this->previousUrl ?? $this->getResource()::getUrl('index');
    }
}
