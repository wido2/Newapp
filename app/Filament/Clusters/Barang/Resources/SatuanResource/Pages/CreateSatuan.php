<?php

namespace App\Filament\Clusters\Barang\Resources\SatuanResource\Pages;

use Filament\Actions;
use Filament\Support\Enums\Alignment;
use Filament\Resources\Pages\CreateRecord;
use App\Filament\Clusters\Barang\Resources\SatuanResource;

class CreateSatuan extends CreateRecord
{
    protected static string $resource = SatuanResource::class;
    protected function getRedirectUrl(): string
    {
        return $this->previousUrl ?? $this->getResource()::getUrl('index');
    }
    public function getFormActionsAlignment(): string|Alignment
    {
        return Alignment::Right;
    }
}
