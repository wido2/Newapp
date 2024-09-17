<?php

namespace App\Filament\Clusters\SuratJalan\Resources\SuratjalanResource\Pages;

use App\Filament\Clusters\SuratJalan\Resources\SuratjalanResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateSuratjalan extends CreateRecord
{
    protected static string $resource = SuratjalanResource::class;
    protected function getRedirectUrl(): string
    {
        return $this->previousUrl ?? $this->getResource()::getUrl('index');
    }
}
