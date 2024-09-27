<?php

namespace App\Filament\Clusters\Barang\Resources\KategoriBarangResource\Pages;

use Filament\Actions;
use Filament\Support\Enums\Alignment;
use Filament\Resources\Pages\CreateRecord;
use App\Filament\Clusters\Barang\Resources\KategoriBarangResource;

class CreateKategoriBarang extends CreateRecord
{
    protected static string $resource = KategoriBarangResource::class;
    protected function getRedirectUrl(): string
    {
        return $this->previousUrl ?? $this->getResource()::getUrl('index');
    }
    public function getFormActionsAlignment(): string|Alignment
    {
        return Alignment::Right;
    }
}
