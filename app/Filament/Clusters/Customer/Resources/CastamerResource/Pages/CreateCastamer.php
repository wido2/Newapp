<?php

namespace App\Filament\Clusters\Customer\Resources\CastamerResource\Pages;

use App\Filament\Clusters\Customer\Resources\CastamerResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateCastamer extends CreateRecord
{
    protected static string $resource = CastamerResource::class;
    protected function getRedirectUrl(): string
    {
        return $this->previousUrl ?? $this->getResource()::getUrl('index');
    }
}
