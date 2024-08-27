<?php

namespace App\Filament\Resources\HargaBarangResource\Pages;

use App\Filament\Resources\HargaBarangResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListHargaBarangs extends ListRecords
{
    protected static string $resource = HargaBarangResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
