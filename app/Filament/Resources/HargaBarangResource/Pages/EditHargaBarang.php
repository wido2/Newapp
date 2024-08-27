<?php

namespace App\Filament\Resources\HargaBarangResource\Pages;

use App\Filament\Resources\HargaBarangResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditHargaBarang extends EditRecord
{
    protected static string $resource = HargaBarangResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\ViewAction::make(),
            Actions\DeleteAction::make(),
        ];
    }
}
