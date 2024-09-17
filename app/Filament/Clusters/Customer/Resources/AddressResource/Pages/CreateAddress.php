<?php

namespace App\Filament\Clusters\Customer\Resources\AddressResource\Pages;

use App\Filament\Clusters\Customer\Resources\AddressResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateAddress extends CreateRecord
{
    protected static string $resource = AddressResource::class;
    protected function getRedirectUrl(): string
    {
        return $this->previousUrl ?? $this->getResource()::getUrl('index');
    }
}
