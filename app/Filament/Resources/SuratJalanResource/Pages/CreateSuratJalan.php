<?php

namespace App\Filament\Resources\SuratJalanResource\Pages;

use App\Filament\Resources\SuratJalanResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateSuratJalan extends CreateRecord
{
    protected static string $resource = SuratJalanResource::class;
    protected function getRedirectUrl(): string
    {
        return $this->previousUrl ?? $this->getResource()::getUrl('index');
    }
}
