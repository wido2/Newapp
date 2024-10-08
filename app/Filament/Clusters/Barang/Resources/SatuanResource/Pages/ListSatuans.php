<?php

namespace App\Filament\Clusters\Barang\Resources\SatuanResource\Pages;

use App\Filament\Clusters\Barang\Resources\SatuanResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListSatuans extends ListRecords
{
    protected static string $resource = SatuanResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
