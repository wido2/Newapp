<?php

namespace App\Filament\Clusters\Barang\Resources\ProdukResource\Pages;

use App\Filament\Clusters\Barang\Resources\ProdukResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListProduks extends ListRecords
{
    protected static string $resource = ProdukResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
