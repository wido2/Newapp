<?php

namespace App\Filament\Clusters\Customer\Resources\CastamerResource\Pages;

use App\Filament\Clusters\Customer\Resources\CastamerResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditCastamer extends EditRecord
{
    protected static string $resource = CastamerResource::class;
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
