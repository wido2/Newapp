<?php

namespace App\Filament\Clusters\Customer\Resources\CastamerResource\Pages;

use Filament\Actions;
use Filament\Support\Enums\Alignment;
use Filament\Resources\Pages\EditRecord;
use App\Filament\Clusters\Customer\Resources\CastamerResource;

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
    public function getFormActionsAlignment(): string|Alignment
    {
        return Alignment::Right;
    }
}
