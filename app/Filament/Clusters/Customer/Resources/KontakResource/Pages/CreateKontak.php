<?php

namespace App\Filament\Clusters\Customer\Resources\KontakResource\Pages;

use Filament\Actions;
use Filament\Support\Enums\Alignment;
use Filament\Resources\Pages\CreateRecord;
use App\Filament\Clusters\Customer\Resources\KontakResource;

class CreateKontak extends CreateRecord
{
    protected static string $resource = KontakResource::class;
    protected function getRedirectUrl(): string
    {
        return $this->previousUrl ?? $this->getResource()::getUrl('index');
    }
    public function getFormActionsAlignment(): string|Alignment
    {
        return Alignment::Right;
    }
}
