<?php

namespace App\Filament\Resources\HargaBarangResource\Pages;

use App\Filament\Resources\HargaBarangResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewHargaBarang extends ViewRecord
{
    protected static string $resource = HargaBarangResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
        ];
    }
}
