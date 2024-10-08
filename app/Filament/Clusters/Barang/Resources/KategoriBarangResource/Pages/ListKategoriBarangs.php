<?php

namespace App\Filament\Clusters\Barang\Resources\KategoriBarangResource\Pages;

use App\Filament\Clusters\Barang\Resources\KategoriBarangResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListKategoriBarangs extends ListRecords
{
    protected static string $resource = KategoriBarangResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
