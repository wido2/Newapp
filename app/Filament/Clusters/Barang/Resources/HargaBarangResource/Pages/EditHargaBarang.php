<?php

namespace App\Filament\Clusters\Barang\Resources\HargaBarangResource\Pages;

use App\Filament\Clusters\Barang\Resources\HargaBarangResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditHargaBarang extends EditRecord
{
    protected static string $resource = HargaBarangResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
