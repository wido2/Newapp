<?php

namespace App\Filament\Clusters\Barang\Resources\ProdukResource\Pages;

use App\Filament\Clusters\Barang\Resources\ProdukResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateProduk extends CreateRecord
{
    protected static string $resource = ProdukResource::class;
    protected function getRedirectUrl(): string
    {
        return $this->previousUrl ?? $this->getResource()::getUrl('index');
    }
}
