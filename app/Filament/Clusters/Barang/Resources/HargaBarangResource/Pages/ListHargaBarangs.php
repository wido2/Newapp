<?php

namespace App\Filament\Clusters\Barang\Resources\HargaBarangResource\Pages;

use App\Filament\Clusters\Barang\Resources\HargaBarangResource;
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
