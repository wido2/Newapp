<?php

namespace App\Filament\Resources\AddressResource\Pages;

use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;
use App\Filament\Resources\AddressResource;

class CreateAddress extends CreateRecord
{
    protected static string $resource = AddressResource::class;
    protected function getRedirectUrl(): string
        {
            return $this->previousUrl ?? $this->getResource()::getUrl('index');
        }
}
