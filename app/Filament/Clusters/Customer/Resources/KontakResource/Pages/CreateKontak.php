<?php

namespace App\Filament\Clusters\Customer\Resources\KontakResource\Pages;

use App\Filament\Clusters\Customer\Resources\KontakResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateKontak extends CreateRecord
{
    protected static string $resource = KontakResource::class;
    protected function getRedirectUrl(): string
    {
        return $this->previousUrl ?? $this->getResource()::getUrl('index');
    }
}
