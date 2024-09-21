<?php

namespace App\Filament\Clusters\Customer\Resources\KontakResource\Pages;

use App\Filament\Clusters\Customer\Resources\KontakResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditKontak extends EditRecord
{
    protected static string $resource = KontakResource::class;
    protected function getRedirectUrl(): string
    {
        return $this->previousUrl ?? $this->getResource()::getUrl('index');
    }
    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
