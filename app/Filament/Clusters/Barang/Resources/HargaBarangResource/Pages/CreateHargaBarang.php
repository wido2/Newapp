<?php

namespace App\Filament\Clusters\Barang\Resources\HargaBarangResource\Pages;

use Filament\Actions;
use Filament\Support\Enums\Alignment;
use Filament\Resources\Pages\CreateRecord;
use App\Filament\Clusters\Barang\Resources\HargaBarangResource;

class CreateHargaBarang extends CreateRecord
{
    protected static string $resource = HargaBarangResource::class;
    protected function getRedirectUrl(): string
    {
        return $this->previousUrl ?? $this->getResource()::getUrl('index');
    }
    public function getFormActionsAlignment(): string|Alignment
    {
        return Alignment::Right;
    }
}
